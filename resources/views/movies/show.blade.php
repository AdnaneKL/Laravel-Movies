@extends('layouts.main')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ $movie->name }}
</h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <img src="{{ Storage::url($movie->cover) }}" alt="{{ $movie->name }}" class="w-full h-auto rounded-lg">
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-4">{{ $movie->name }}</h1>
                        
                        <div class="flex items-center mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= $movie->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>

                        <p class="text-lg mb-4">
                            <span class="font-semibold">Durée:</span> {{ $movie->duration }} minutes
                        </p>

                        <div class="mb-4">
                            <h3 class="font-semibold text-lg mb-2">Catégories:</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($movie->categories as $category)
                                    <span class="bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="font-semibold text-lg mb-2">Description:</h3>
                            <p class="text-gray-700">{{ $movie->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
