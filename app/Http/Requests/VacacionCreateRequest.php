<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VacacionCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:100',
            'descripcion' => 'required|string',
            'precio_pp' => 'required|numeric|min:0',
            'tipo_id' => 'required|exists:tipos,id',
            'fotos' => 'nullable|image|max:2048',
            'pais' => 'required|string|max:100',
        ];
    }
}