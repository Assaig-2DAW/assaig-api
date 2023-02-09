<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfesorRequest extends FormRequest
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
            'nombre' =>'required|min:4|max:50',
            'tipo' => 'required|string|in:cocina,sala'
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre és obligatorio',
            'nombre.min' => 'El nombre ha de tener como mínimo 4 letras',
            'nombre.max' => 'El nombre ha de tener como máximo 50 letras',
            'tipo.required' => 'El tipo es obligatorio',
            'tipo.in' => 'El tipo ha de ser cocina o sala',
        ];
    }
}
