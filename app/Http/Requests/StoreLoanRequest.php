<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * request validation rules
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'book_id' => [
                'required',
                'integer',
                Rule::exists('books', 'id'),
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $book = Book::withCount('loans')->find($value);

                    if ($book && ! $book->isAvailable()) {
                        $fail('This book has no copies available to check out right now.');
                    }
                }
            ],
            'reader_name' => ['required', 'string', 'max:255'],
            'due_at' => ['required', 'date', 'after:today']
        ];
    }

    public function attributes(): array
    {
        return [
            'book_id' => 'book',
            'due_at' => 'due date'
        ];
    }
}
