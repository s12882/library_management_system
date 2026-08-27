@extends('layouts.app')

@section('title', 'Authors')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h1 class="text-2xl font-semibold text-gray-900">Authors</h1>
        <a href="{{ route('authors.create') }}"
           class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
            + New author
        </a>
    </div>

    <div class="mt-6 overflow-x-auto rounded-lg border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="w-10 px-4 py-3"></th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Last name</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">First name</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-500">Books</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($authors as $author)
                    <tr class="cursor-pointer hover:bg-gray-50" data-author-toggle="{{ $author->id }}">
                        <td class="px-4 py-3 text-gray-400">
                            <svg data-chevron="{{ $author->id }}" class="h-4 w-4 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-900">{{ $author->last_name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $author->first_name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $author->books_count }}</td>
                        <td class="px-4 py-3" onclick="event.stopPropagation()">
                            <div class="flex justify-end gap-3">
                                <a href="{{ route('authors.edit', $author) }}" class="font-medium text-gray-700 hover:text-gray-900">Edit</a>
                                <form method="POST" action="{{ route('authors.destroy', $author) }}"
                                      data-confirm="Delete {{ $author->first_name }} {{ $author->last_name }}? This can't be undone.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr id="author-books-{{ $author->id }}" class="hidden bg-gray-50">
                        <td colspan="5" class="px-4 py-3">
                            @if ($author->books->isEmpty())
                                <p class="text-sm text-gray-500">No books yet.</p>
                            @else
                                <ul class="grid grid-cols-1 gap-x-6 gap-y-1 text-sm text-gray-700 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($author->books as $book)
                                        <li>{{ $book->title }} <span class="text-gray-400">({{ $book->year }})</span></li>
                                    @endforeach
                                </ul>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">No authors yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $authors->links() }}
    </div>
@endsection
