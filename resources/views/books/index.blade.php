@extends('layouts.app')

@section('title', 'Books')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h1 class="text-2xl font-semibold text-gray-900">Books</h1>
        <a href="{{ route('books.create') }}"
           class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
            + New book
        </a>
    </div>

    <div class="mt-6 overflow-x-auto rounded-lg border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Title</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Author</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Year</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">ISBN</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Copies</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($books as $book)
                    <tr>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $book->title }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $book->author->first_name }} {{ $book->author->last_name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $book->year }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $book->isbn }}</td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $book->availableCopies() }} / {{ $book->total_copies }} available
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('books.edit', $book) }}" class="font-medium text-gray-700 hover:text-gray-900">Edit</a>
                                <form method="POST" action="{{ route('books.destroy', $book) }}" data-confirm="Delete &quot;{{ $book->title }}&quot;?">
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">No books yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $books->links() }}
    </div>
@endsection
