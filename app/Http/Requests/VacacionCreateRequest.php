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
            'precio_pp' => 'required|numeric|min:0|max:999999.99',
            'tipo_id' => 'required|exists:tipos,id',
            'fotos' => 'nullable|image|max:2048',
            'pais' => 'required|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max' => 'El título no puede tener más de 100 caracteres.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'precio_pp.required' => 'El precio es obligatorio.',
            'precio_pp.numeric' => 'El precio debe ser un número.',
            'precio_pp.min' => 'El precio no puede ser negativo.',
            'precio_pp.max' => 'El precio es demasiado alto (máximo 999,999.99).',
            'tipo_id.required' => 'Debes seleccionar un tipo de vacación.',
            'tipo_id.exists' => 'El tipo seleccionado no es válido.',
            'fotos.image' => 'El archivo debe ser una imagen válida (jpg, jpeg, png, bmp, gif, svg, o webp).',
            'fotos.max' => 'La imagen no puede pesar más de 2MB.',
            'pais.required' => 'El país o destino es obligatorio.',
            'pais.max' => 'El nombre del país no puede exceder los 100 caracteres.'
        ];
    }
}