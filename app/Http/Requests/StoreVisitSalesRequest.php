<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisitSalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->can('category-create') || $this->user()->can('category-edit')) {
            return true;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable',
            'official_store_id' => 'required',
            'check_in' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User is required',
            'official_store_id.required' => 'Official Store is required',
            'check_in.required' => 'Check In is required',
        ];
    }
}
