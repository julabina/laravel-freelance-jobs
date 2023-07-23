<?php

namespace App\Http\Requests\Mission;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<string>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'city' => [
                'string',
                'max:255',
                'nullable',
            ],
            'postalcode' => [
                'string',
                'regex:/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/i',
                'nullable',
            ],
            'description' => [
                'required',
                'string',
            ],
            'remuneration' => [
                'required',
                'numeric',
                'min:1',
            ],
            'remote' => [
                'boolean',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'remote' => $this->boolean('remote'),
        ]);
    }
}
