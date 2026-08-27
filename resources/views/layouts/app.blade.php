<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Library') &middot; Library Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('scripts')
</head>
<body class="min-h-screen bg-gray-50 text-gray-900 antialiased">
    <nav class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6">
            <a href="{{ route('books.index') }}" class="text-lg font-semibold text-gray-900">Library</a>
            <div class="flex gap-1 text-sm font-medium">
                <a href="{{ route('books.index') }}"
                   class="rounded-md px-3 py-2 {{ request()->routeIs('books.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    Books
                </a>
                @if (Route::has('authors.index'))
                    <a href="{{ route('authors.index') }}"
                       class="rounded-md px-3 py-2 {{ request()->routeIs('authors.*') ? 'bg-gray-900 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                        Authors
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
        @if (session('success'))
            <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <div id="confirm-modal" class="fixed inset-0 z-50 hidden bg-gray-900/50 p-4">
        <div class="w-full max-w-sm rounded-lg bg-white p-6 shadow-xl">
            <p id="confirm-modal-message" class="text-sm text-gray-700"></p>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="confirm-modal-cancel"
                        class="rounded-md border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </button>
                <button type="button" id="confirm-modal-confirm"
                        class="rounded-md bg-red-600 px-3 py-2 text-sm font-medium text-white hover:bg-red-700">
                    Confirm
                </button>
            </div>
        </div>
    </div>

    @stack('modals')
</body>
</html>
