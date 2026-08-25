<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    /** @use HasFactory<\Database\Factories\LoanFactory> */
    use HasFactory;

    protected $fillable = [
        'book_id',
        'reader_id',
        'checked_out_at',
        'due_at',
    ];

    protected function casts(): array
    {
        return [
            'checked_out_at' => 'date',
            'due_at' => 'date',
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function reader(): BelongsTo
    {
        return $this->belongsTo(Reader::class);
    }

    public function status(): string
    {
        return $this->due_at->isPast() ? 'overdue' : 'active';
    }

    #[Scope]
    protected function overdue(Builder $query): void
    {
        $query->whereDate('due_at', '<', now());
    }

    #[Scope]
    protected function active(Builder $query): void
    {
        $query->whereDate('due_at', '>=', now());
    }
}
