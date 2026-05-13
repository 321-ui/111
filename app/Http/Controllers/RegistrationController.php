<?php

namespace App\Http\Controllers;

use App\Models\MasterClass;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
	public function confirm(int $id): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
	{
		$masterClass = MasterClass::with(['category', 'instructor'])->withCount('registrations')->findOrFail($id);
		$user = Auth::user();

		if ($masterClass->registrations_count >= $masterClass->max_participants) {
			return redirect()->route('categories.show', $masterClass->category_id)
				->withErrors(['error' => 'Нет свободных мест']);
		}

		$existingRegistration = Registration::where('user_id', $user->id)
			->where('master_class_id', $id)
			->first();

		if ($existingRegistration) {
			return redirect()->route('categories.show', $masterClass->category_id)
				->withErrors(['error' => 'Вы уже записаны на этот мастер-класс']);
		}

		return view('registrations.confirm', compact('masterClass', 'user'));
	}

	public function store(Request $request, int $id): \Illuminate\Http\RedirectResponse
	{
		$masterClass = MasterClass::findOrFail($id);
		$user = Auth::user();

		$existingRegistration = Registration::where('user_id', $user->id)
			->where('master_class_id', $id)
			->first();

		if ($existingRegistration) {
			return redirect()->route('categories.show', $masterClass->category_id)
				->withErrors(['error' => 'Вы уже записаны на этот мастер-класс']);
		}

		DB::beginTransaction();
		try {
			$masterClass = MasterClass::withCount('registrations')->findOrFail($id);

			if ($masterClass->registrations_count >= $masterClass->max_participants) {
				DB::rollBack();
				return redirect()->route('categories.show', $masterClass->category_id)
					->withErrors(['error' => 'Нет свободных мест']);
			}

			Registration::create([
				'user_id' => $user->id,
				'master_class_id' => $id,
			]);

			DB::commit();
		} catch (\Exception $e) {
			DB::rollBack();
			return redirect()->route('categories.show', $masterClass->category_id)
				->withErrors(['error' => 'Ошибка при записи. Попробуйте еще раз.']);
		}

		return redirect()->route('categories.show', $masterClass->category_id)
			->with('success', 'Вы успешно записались на мастер-класс!');
	}

	public function myRegistrations(): \Illuminate\Contracts\View\View
	{
		$user = Auth::user();
		$registrations = $user->registrations()->with('masterClass.category', 'masterClass.instructor')->get();

		return view('registrations.my', compact('registrations'));
	}
}
