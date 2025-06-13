<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class AlamatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'desa_id' => 'required|exists:desas,id',
            'detail' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'default' => 'nullable|boolean',
            'no_hp' => 'required|string|max:20',
            'nama_penerima' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'desa_id.required' => 'Desa wajib dipilih.',
            'desa_id.exists' => 'Desa yang dipilih tidak ditemukan.',
            'no_hp.required' => 'Nomor HP penerima wajib diisi.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
            'nama_penerima.required' => 'Nama penerima wajib diisi.',
            'nama_penerima.max' => 'Nama penerima maksimal 100 karakter.',
        ];
    }
}
