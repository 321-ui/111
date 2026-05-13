<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MasterClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterClassController extends Controller
{
    public function cabinet(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $instructor = Auth::user();
        if (!$instructor instanceof User || !$instructor->isInstructor()) {
            return redirect()->route('home')->withErrors(['error' => 'Доступ только для ведущих']);
        }

        $masterClasses = $instructor->masterClasses()->with('category')->get();
        return view('master-classes.cabinet', compact('masterClasses', 'instructor'));
    }

    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $instructor = Auth::user();
        if (!$instructor instanceof User || !$instructor->isInstructor()) {
            return redirect()->route('home')->withErrors(['error' => 'Доступ только для ведущих']);
        }

        $categories = Category::all();
        $timeSlots = ['09:00', '11:00', '13:00', '15:00'];

        return view('master-classes.create', compact('categories', 'timeSlots'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $instructor = Auth::user();
        if (!$instructor instanceof User || !$instructor->isInstructor()) {
            return redirect()->route('home')->withErrors(['error' => 'Доступ только для ведущих']);
        }

        /** @var array{category_id: int|string, title: string, description: string, date: string, time: string, max_participants: int|string, price: float|int|string} $validated */
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|in:09:00,11:00,13:00,15:00',
            'max_participants' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        $validated['instructor_id'] = $instructor->id;

        try {
            MasterClass::create($validated);
            return redirect()->route('cabinet')->with('success', 'Мастер-класс успешно добавлен!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Это время уже занято другим мастер-классом']);
        }
    }

    public function edit(int $id): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $instructor = Auth::user();
        if (!$instructor instanceof User || !$instructor->isInstructor()) {
            return redirect()->route('home')->withErrors(['error' => 'Доступ только для ведущих']);
        }

        $masterClass = MasterClass::where('id', $id)
            ->where('instructor_id', $instructor->id)
            ->firstOrFail();

        return view('master-classes.edit', compact('masterClass'));
    }

    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $instructor = Auth::user();
        if (!$instructor instanceof User || !$instructor->isInstructor()) {
            return redirect()->route('home')->withErrors(['error' => 'Доступ только для ведущих']);
        }

        $masterClass = MasterClass::where('id', $id)
            ->where('instructor_id', $instructor->id)
            ->firstOrFail();

        /** @var array{description: string, price: float|int|string} $validated */
        $validated = $request->validate([
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        $masterClass->update($validated);

        return redirect()->route('cabinet')->with('success', 'Мастер-класс успешно обновлен!');
    }

    public function show(int $id): \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
    {
        $instructor = Auth::user();
        if (!$instructor instanceof User || !$instructor->isInstructor()) {
            return redirect()->route('home')->withErrors(['error' => 'Доступ только для ведущих']);
        }

        $masterClass = MasterClass::where('id', $id)
            ->where('instructor_id', $instructor->id)
            ->with(['category', 'registrations.user'])
            ->firstOrFail();

        return view('master-classes.show', compact('masterClass'));
    }

    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $instructor = Auth::user();
        if (!$instructor instanceof User || !$instructor->isInstructor()) {
            return redirect()->route('home')->withErrors(['error' => 'Доступ только для ведущих']);
        }

        $masterClass = MasterClass::where('id', $id)
            ->where('instructor_id', $instructor->id)
            ->firstOrFail();

        $masterClass->delete();

        return redirect()->route('cabinet')->with('success', 'Мастер-класс успешно удален!');
    }

    public function getBusySlots(Request $request): \Illuminate\Http\JsonResponse
    {
        $date = $request->query('date');
        $instructorId = $request->query('instructor_id');

        $busySlots = MasterClass::where('date', $date)
            ->where('instructor_id', $instructorId)
            ->pluck('time')
            ->map(function ($time) {
                return substr($time, 0, 5);
            })
            ->toArray();

        return response()->json($busySlots);
    }
}
