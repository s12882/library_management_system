@extends('layouts.app')

@section('title', 'New Book')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-900">New book</h1>

    <form method="POST" action="{{ route('books.store') }}" class="mt-6 max-w-2xl">
        @csrf
        @include('books._form', ['authors' => $authors])
    </form>
@endsection
