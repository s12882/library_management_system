@php
    $author = $author ?? null;
@endphp

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
        <label for="first_name" class="block text-sm font-medium text-gray-700">First name</label>
        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $author?->first_name) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('first_name') border-red-400 @enderror">
        @error('first_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="last_name" class="block text-sm font-medium text-gray-700">Last name</label>
        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $author?->last_name) }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500 @error('last_name') border-red-400 @enderror">
        @error('last_name')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex justify-end gap-3">
    <a href="{{ route('authors.index') }}" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
        Cancel
    </a>
    <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
        {{ $author ? 'Save changes' : 'Create author' }}
    </button>
</div>
