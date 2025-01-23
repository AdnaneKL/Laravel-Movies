<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('movies')->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'cover' => 'required|image'
        ]);

        $coverPath = $request->file('cover')->store('category-covers', 'public');

        Category::create([
            'name' => $validatedData['name'],
            'cover' => $coverPath
        ]);

        return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès!');
    }

    public function show(Category $category)
    {
        $movies = $category->movies;
        return view('categories.show', compact('category', 'movies'));
    }
}
