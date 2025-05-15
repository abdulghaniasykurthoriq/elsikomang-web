<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKeranjangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'member_id' => 'required|exists:member_umkm,id',
            'produk_umkm_id' => 'required|exists:produk_umkm,id',
            'produk_variant_id' => 'required|exists:produk_variants,id'
        ];
    }
}
