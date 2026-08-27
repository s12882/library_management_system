<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Models\Book;
use App\Models\Loan;
use App\Models\Reader;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class LoanController extends Controller
{
    public function index(Request $request): View
    {
        return view('loans.index', [
            'loans' => $this->filteredLoans($request),
            'books' => Book::withCount('loans')->orderBy('title')->get(),
            'readerNames' => Reader::orderBy('name')->pluck('name'),
        ]);
    }

    public function data(Request $request): View
    {
        return view('loans._table', ['loans' => $this->filteredLoans($request)]);
    }

    public function store(StoreLoanRequest $request): JsonResponse
    {
        $reader = Reader::firstOrCreate(['name' => trim($request->validated('reader_name'))]);

        Loan::create([
            'book_id' => $request->validated('book_id'),
            'reader_id' => $reader->id,
            'checked_out_at' => now(),
            'due_at' => $request->validated('due_at'),
        ]);

        return response()->json(['message' => 'Book checked out'], 201);
    }

    public function destroy(Loan $loan): JsonResponse
    {
        $loan->delete();

        return response()->json(['message' => 'Book returned']);
    }

    private function filteredLoans(Request $request): LengthAwarePaginator
    {
        return Loan::query()->with(['book', 'reader'])->when($request->filled('reader'), function ($query) use ($request) {
                $query->whereHas('reader', fn ($q) => $q->where('name', 'LIKE', '%'.$request->input('reader').'%'));
            })->when($request->filled('book'), function ($query) use ($request) {
                $query->whereHas('book', fn ($q) => $q->where('title', 'LIKE', '%'.$request->input('book').'%'));
            })->when($request->filled('checked_out_at'), function ($query) use ($request) {
                $query->whereDate('checked_out_at', $request->input('checked_out_at'));
            })->when($request->input('status') === 'active', fn ($query) => $query->active())
            ->when($request->input('status') === 'overdue', fn ($query) => $query->overdue())
            ->orderByDesc('checked_out_at')
            ->paginate(10)
            ->withQueryString();
    }
}
