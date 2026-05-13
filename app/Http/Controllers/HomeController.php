<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index(): \Illuminate\Contracts\View\View
	{
		$categories = \App\Models\Category::all();
		return view('home', compact('categories'));
	}
}
