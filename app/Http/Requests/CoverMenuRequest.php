<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoverMenuRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255|unique:cover_menus,nama',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
