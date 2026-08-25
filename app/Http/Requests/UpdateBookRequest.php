<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'isbn' => strtoupper(preg_replace('/[^0-9Xx]/', '', (string) $this->input('isbn')))
        ]);
    }

    /**
     * Request validation rules
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $book = $this->route('book');

        return [
            'title' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'between:1450,'.date('Y')],
            'isbn' => ['required', 'string', 'regex:/^(?:\d{9}[\dX]|\d{13})$/', Rule::unique('books', 'isbn')->ignore($book)],
            'author_id' => ['required', 'integer', Rule::exists('authors', 'id')],
            'total_copies' => [
                'required',
                'integer',
                'min:1',
                function (string $attribute, mixed $value, \Closure $fail) use ($book): void {
                    $loansCount = $book->loans()->count();

                    if ($value < $loansCount) {
                        $fail("Book currently has {$loansCount} copy(ies) checked out, so total copies can't be reduced anymore");
                    }
                }
            ],
        ];
    }

    /**
     * Validator errors ccustom messages
 *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'isbn.regex' => 'Field must be a valid ISBN'
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'author_id' => 'author',
            'isbn' => 'ISBN',
            'total_copies' => 'number of copies',
        ];
    }
}
