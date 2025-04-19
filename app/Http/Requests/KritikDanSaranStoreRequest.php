<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KritikDanSaranStoreRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|max:255',
            'kritik' => 'nullable|string|required_without:saran',
            'saran'  => 'nullable|string|required_without:kritik',
            'jenis_kelamin' => 'required|in:l,p'
        ];
    }
}
