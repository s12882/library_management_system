<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'year',
        'isbn',
        'author_id',
        'total_copies',
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'total_copies' => 'integer',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function availableCopies(): int
    {
        $loanCount = $this->loans_count ?? $this->loans()->count();

        return $this->total_copies - $loanCount;
    }

    public function isAvailable(): bool
    {
        return $this->availableCopies() > 0;
    }
}
