@extends('layouts.app')

@section('title', 'Edit Book')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-900">Edit book</h1>

    <form method="POST" action="{{ route('books.update', $book) }}" class="mt-6 max-w-2xl">
        @csrf
        @method('PUT')
        @include('books._form', ['authors' => $authors, 'book' => $book])
    </form>
@endsection
