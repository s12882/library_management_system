@php
    $book = $book ?? null;
@endphp

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $book?->title) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('title') border-red-400 @enderror">
        @error('title')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="author_id" class="block text-sm font-medium text-gray-700">Author</label>
        <select name="author_id" id="author_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('author_id') border-red-400 @enderror">
            <option value="">Select an author&hellip;</option>
            @foreach ($authors as $author)
                <option value="{{ $author->id }}" @selected((int) old('author_id', $book?->author_id) === $author->id)>
                    {{ $author->last_name }}, {{ $author->first_name }}
                </option>
            @endforeach
        </select>
        @error('author_id')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="year" class="block text-sm font-medium text-gray-700">Year of publication</label>
        <input type="number" name="year" id="year" value="{{ old('year', $book?->year) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('year') border-red-400 @enderror">
        @error('year')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
        <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book?->isbn) }}" placeholder="e.g. 978-3-16-148410-0"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('isbn') border-red-400 @enderror">
        @error('isbn')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="total_copies" class="block text-sm font-medium text-gray-700">Number of copies</label>
        <input type="number" name="total_copies" id="total_copies" min="1" value="{{ old('total_copies', $book?->total_copies) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('total_copies') border-red-400 @enderror">
        @error('total_copies')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex justify-end gap-3">
    <a href="{{ route('books.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
        Cancel
    </a>
    <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
        {{ $book ? 'Save changes' : 'Create book' }}
    </button>
</div>
