<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('categories')->get();
        return view('movies.index', compact('movies'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('movies.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'duration' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'cover' => 'required|image',
            'description' => 'required',
            'categories' => 'required|array'
        ]);

        $coverPath = $request->file('cover')->store('covers', 'public');

        $movie = Movie::create([
            'name' => $validatedData['name'],
            'duration' => $validatedData['duration'],
            'rating' => $validatedData['rating'],
            'cover' => $coverPath,
            'description' => $validatedData['description']
        ]);

        $movie->categories()->attach($validatedData['categories']);

        return redirect()->route('movies.index')->with('success', 'Film ajouté avec succès!');
    }

    public function show(Movie $movie)
    {
        return view('movies.show', compact('movie'));
    }

    public function dashboard()
    {
        $movies = Movie::with('categories')->get();
        return view('dashboard', compact('movies'));
    }
}
