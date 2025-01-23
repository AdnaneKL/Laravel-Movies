@extends('layouts.main')

@section('header')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Catégories') }}
    </h2>
    <a href="{{ route('categories.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Ajouter une catégorie
    </a>
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                    <a href="{{ route('categories.show', $category) }}" class="block p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-2xl font-bold text-gray-800">{{ $category->name }}</h3>
                            <span class="bg-blue-100 text-blue-800 text-sm font-semibold px-3 py-1 rounded-full">
                                {{ $category->movies->count() }} films
                            </span>
                        </div>
                        @if($category->movies->count() > 4)
                            <div class="mt-4 text-blue-600 font-semibold">
                                + {{ $category->movies->count() - 4 }} autres films
                            </div>
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
