<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function show(int $id): View
    {
        $category = Category::findOrFail($id);
        $masterClasses = $category->masterClasses()->with('instructor', 'registrations')->get();
        $user = Auth::user();

        return view('categories.show', compact('category', 'masterClasses', 'user'));
    }
}
