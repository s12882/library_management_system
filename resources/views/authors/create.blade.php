@extends('layouts.app')

@section('title', 'New Author')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-900">New author</h1>

    <form method="POST" action="{{ route('authors.store') }}" class="mt-6 max-w-xl">
        @csrf
        @include('authors._form')
    </form>
@endsection
