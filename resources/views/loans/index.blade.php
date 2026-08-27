@extends('layouts.app')

@section('title', 'Loans')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <h1 class="text-2xl font-semibold text-gray-900">Loans</h1>
        <button type="button" id="open-checkout-modal"
                class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
            + Check Out Book
        </button>
    </div>

    <form id="loan-filter-form" class="mt-6 grid grid-cols-1 gap-4 rounded-lg border border-gray-200 bg-white p-4 sm:grid-cols-2 lg:grid-cols-5">
        <div>
            <label for="filter-reader" class="block text-sm font-medium text-gray-700">Reader</label>
            <input type="text" name="reader" id="filter-reader" placeholder="Reader name&hellip;"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
        </div>
        <div>
            <label for="filter-book" class="block text-sm font-medium text-gray-700">Book</label>
            <input type="text" name="book" id="filter-book" placeholder="Book title&hellip;"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
        </div>
        <div>
            <label for="filter-checked-out-at" class="block text-sm font-medium text-gray-700">Checkout date</label>
            <input type="date" name="checked_out_at" id="filter-checked-out-at"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
        </div>
        <div>
            <label for="filter-status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="filter-status"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                <option value="">Any</option>
                <option value="active">Active</option>
                <option value="overdue">Overdue</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
                Filter
            </button>
            <button type="button" id="reset-filters" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                Reset
            </button>
        </div>
    </form>

    <div id="loans-table-container" class="mt-6">
        @include('loans._table', ['loans' => $loans])
    </div>

    <datalist id="reader-names-list">
        @foreach ($readerNames as $name)
            <option value="{{ $name }}"></option>
        @endforeach
    </datalist>
@endsection

@push('modals')
    <div id="checkout-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 p-4">
        <div class="mx-auto mt-24 w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
            <h2 class="text-lg font-semibold text-gray-900">Check out a book</h2>

            <form id="checkout-form" class="mt-4 space-y-4">
                @csrf

                <div>
                    <label for="checkout-book" class="block text-sm font-medium text-gray-700">Book</label>
                    <select name="book_id" id="checkout-book"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                        <option value="">Select a book&hellip;</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}" @disabled(! $book->isAvailable())>
                                {{ $book->title }} ({{ $book->availableCopies() }} available)
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 hidden text-sm text-red-600" data-error-for="book_id"></p>
                </div>

                <div>
                    <label for="checkout-reader" class="block text-sm font-medium text-gray-700">Reader's name</label>
                    <input type="text" name="reader_name" id="checkout-reader" list="reader-names-list" autocomplete="off"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                    <p class="mt-1 hidden text-sm text-red-600" data-error-for="reader_name"></p>
                </div>

                <div>
                    <label for="checkout-due-at" class="block text-sm font-medium text-gray-700">Due date</label>
                    <input type="date" name="due_at" id="checkout-due-at"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                    <p class="mt-1 hidden text-sm text-red-600" data-error-for="due_at"></p>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" id="close-checkout-modal" class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-700">
                        Check out
                    </button>
                </div>
            </form>
        </div>
    </div>
@endpush
