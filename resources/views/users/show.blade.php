@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Informations</h1>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Retour</a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <strong>Name:</strong>
                <p>{{ $user->name }}</p>
            </div>

            <div class="mb-3">
                <strong>Email:</strong>
                <p>{{ $user->email }}</p>
            </div>

            <div class="mb-3">
                <strong>Created At:</strong>
                <p>{{ $user->created_at->format('Y-m-d H:i:s') }}</p>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('users.edit', $user) }}" class="btn btn-success">Modifier</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
@endsection
