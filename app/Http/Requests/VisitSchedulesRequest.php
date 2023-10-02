<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitSchedulesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->user()->can('visit-schedules-create') || $this->user()->can('visit-schedules-edit')) {
            return true;
        }
        return false; // Tambahkan ini untuk mengembalikan false secara default
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
            'id' => 'nullable',
            'user_id' => 'required',
            'official_store_id' => 'required',
            'custom_visit_day' => 'required',
            'custom_visit_note' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'User harus dipilih.',
            'official_store_id.required' => 'Official Store harus dipilih.',
            'custom_visit_day.required' => 'Tanggal kunjungan harus diisi.',
            'custom_visit_day.date' => 'Tanggal kunjungan harus berupa tanggal.',
            'custom_visit_day.date_format' => 'Tanggal kunjungan harus berformat dd-mm-yyyy.',
            'custom_visit_note.required' => 'Catatan kunjungan harus diisi.',
            'custom_visit_note.string' => 'Catatan kunjungan harus berupa string.',
            'custom_visit_note.max' => 'Catatan kunjungan maksimal 255 karakter.',
        ];
    }
}
