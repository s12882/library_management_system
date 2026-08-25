<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'isbn' => strtoupper(preg_replace('/[^0-9Xx]/', '', (string) $this->input('isbn'))),
        ]);
    }

    /**
     * Request validation rules
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'year' => ['required', 'integer', 'between:1450,'.date('Y')],
            'author_id' => ['required', 'integer', Rule::exists('authors', 'id')],
            'isbn' => ['required', 'string', 'regex:/^(?:\d{9}[\dX]|\d{13})$/', Rule::unique('books', 'isbn')],
            'total_copies' => ['required', 'integer', 'min:1']
        ];
    }

    /**
     * Validator errors custom messages
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'isbn.regex' => 'Field must be a valid ISBN'
        ];
    }
}
