<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Rediriger la page d'accueil vers la liste des produits
//Route::get('/', function () {
  //  return redirect()->route('product.index');
//});

// Routes CRUD pour les utilisateurs
//Route::resource('users', UserController::class);

Route::get('/dashboard', [MovieController::class, 'dashboard'])->name('dashboard');
Route::resource('movies', MovieController::class);
Route::resource('categories', CategoryController::class);

//Route::resource('product',ProductController::class);