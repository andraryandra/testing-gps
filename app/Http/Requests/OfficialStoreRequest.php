<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class OfficialStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->can('official-store-create') || $this->user()->can('official-store-edit')) {
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
        $id = $this->route('id'); // Sesuaikan dengan nama parameter rute Anda

        return [
            'category_id' => 'required',
            'name' => 'required|max:255',
            'status' => 'required|in:ACTIVE,INACTIVE', // Sesuaikan dengan aturan validasi yang sesuai
            'phone' => 'required|numeric|digits_between:10,13',
            'email' => [
                'required',
                'email',
                Rule::unique('official_stores', 'email')->ignore($id),
            ],
            'city' => 'required|max:255',
            'province' => 'required|max:255',
            'address' => 'required|max:255',
            'postal_code' => 'required|max:10',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'slug' => 'nullable|unique:official_stores,slug',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Kategori wajib diisi.',
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'status.required' => 'Status wajib diisi.',
            'status.in' => 'Status harus berupa "ACTIVE" atau "INACTIVE".',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.numeric' => 'Nomor telepon harus berupa angka.',
            'phone.digits_between' => 'Nomor telepon harus antara 10 sampai 13 digit.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Alamat email harus valid.',
            'email.unique' => 'Alamat email sudah digunakan.',
            'city.required' => 'Kota wajib diisi.',
            'city.max' => 'Kota tidak boleh lebih dari 255 karakter.',
            'province.required' => 'Provinsi wajib diisi.',
            'province.max' => 'Provinsi tidak boleh lebih dari 255 karakter.',
            'address.required' => 'Alamat wajib diisi.',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter.',
            'postal_code.required' => 'Kode pos wajib diisi.',
            'postal_code.max' => 'Kode pos tidak boleh lebih dari 10 karakter.',
            'latitude.required' => 'Latitude wajib diisi.',
            'latitude.numeric' => 'Latitude harus berupa angka.',
            'longitude.required' => 'Longitude wajib diisi.',
            'longitude.numeric' => 'Longitude harus berupa angka.',
            'slug.unique' => 'Slug sudah digunakan.',
            'description.required' => 'Deskripsi wajib diisi.',
        ];
    }
}
