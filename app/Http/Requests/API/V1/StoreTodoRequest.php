<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'max:100'],
            'description' => ['nullable', 'max:300'],
            'dueDate' => ['nullable'],
        ];
    }

    protected function prepareForValidation() {
        if ($this->dueDate) {
            $this->merge([
                'due_date' => $this->dueDate
            ]);
        }
    }
}
