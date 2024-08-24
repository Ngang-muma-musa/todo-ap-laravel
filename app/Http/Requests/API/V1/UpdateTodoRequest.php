<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest  extends FormRequest
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
        $method = $this->method();
        if($method == 'PUT') {
            return [
                'title' => ['required', 'max:100'],
                'descrition' => ['nullable', 'max:300'],
                'dueDate' => ['nullable'],
    
            ];
        }else {
            return [
                'title' => ['sometimes','required', 'max:100'],
                'descrition' => ['sometimes','nullable', 'max:300'],
                'dueDate' => ['sometimes','nullable'],
    
            ];
        }
    }

    protected function prepareForValidation() {
        if($this->dueDate) {
            $this->merge([
                'due_date' => $this->dueDate
            ]);
        }
    }
}
