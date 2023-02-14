<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlergenoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre' =>'required|min:3|max:30',
            'icono' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El nombre és obligatorio',
            'nombre.min' => 'El nombre ha de tener como mínimo 3 letras',
            'nombre.max' => 'El nombre ha de tener como máximo 30 letras',
            'icono.required' => 'El tipo es obligatorio'
        ];
    }
}
