<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitSalesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->can('visit-sales-create') || $this->user()->can('visit-sales-edit')) {
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
            'user_id' => 'required|exists:users,id',
            'official_store_id' => 'required|exists:official_stores,id',
            'ip_address' => 'nullable|ip',
            'check_in' => 'required|date',
            'check_out' => 'nullable|date',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'User ID is not exists.',
            'official_store_id.required' => 'Official Store ID is required.',
            'official_store_id.exists' => 'Official Store ID is not exists.',
            'ip_address.ip' => 'IP Address is not valid.',
            'check_in.required' => 'Check In is required.',
            'check_in.date' => 'Check In is not valid.',
            'check_out.required' => 'Check Out is required.',
            'check_out.date' => 'Check Out is not valid.',
            'latitude.numeric' => 'Latitude is not valid.',
            'longitude.numeric' => 'Longitude is not valid.',
        ];
    }
}
