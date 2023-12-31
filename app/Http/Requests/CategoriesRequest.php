<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'name' => 'required|max:75',
            'detail' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama Kategori tidak boleh kosong',
            'name.max' => 'Nama Kategori tidak boleh lebih dari 75 karakter',
            'detail.required' => 'Detail Kategori tidak boleh kosong',
            'detail.max' => 'Detail Kategori tidak boleh lebih dari 255 karakter',
        ];
    }
}
