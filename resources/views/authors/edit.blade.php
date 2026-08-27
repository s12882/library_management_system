@extends('layouts.app')

@section('title', 'Edit Author')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-900">Edit author</h1>

    <form method="POST" action="{{ route('authors.update', $author) }}" class="mt-6 max-w-xl">
        @csrf
        @method('PUT')
        @include('authors._form', ['author' => $author])
    </form>
@endsection
