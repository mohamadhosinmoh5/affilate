<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Contract extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }


    public function prepareForValidation()
    {
        $this->merge([
            'contract_date' => to_english_numbers($this->input('contract_date'))
        ]);
    }
}
