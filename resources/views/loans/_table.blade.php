<div class="overflow-x-auto rounded-lg border border-gray-200 bg-white">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left font-medium text-gray-500">Book</th>
                <th class="px-4 py-3 text-left font-medium text-gray-500">Reader</th>
                <th class="px-4 py-3 text-left font-medium text-gray-500">Checked out</th>
                <th class="px-4 py-3 text-left font-medium text-gray-500">Due</th>
                <th class="px-4 py-3 text-left font-medium text-gray-500">Status</th>
                <th class="px-4 py-3 text-right font-medium text-gray-500">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($loans as $loan)
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $loan->book->title }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $loan->reader->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $loan->checked_out_at->format('M j, Y') }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $loan->due_at->format('M j, Y') }}</td>
                    <td class="px-4 py-3">
                        @if ($loan->status() === 'overdue')
                            <span class="inline-flex rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-700">Overdue</span>
                        @else
                            <span class="inline-flex rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700">Active</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <button type="button"
                                data-return-loan="{{ $loan->id }}"
                                data-confirm="Mark &quot;{{ $loan->book->title }}&quot; as returned for {{ $loan->reader->name }}?"
                                class="font-medium text-red-600 hover:text-red-800">
                            Return
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">No loans match these filters.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $loans->links() }}
</div>
