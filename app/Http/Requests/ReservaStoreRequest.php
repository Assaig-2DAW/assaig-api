<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaStoreRequest extends FormRequest
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
            'nombre' => 'required|string|min:3|max:50',
            'email' => 'required|email|max:125',
            'telefono' => 'required|numeric|digits:9',
            'comensales' => 'required|integer|min:1',
            'observaciones' => 'nullable|string',
            'alergenos' => 'distinct:strict|exists:alergenos,id',
            'fecha_id' => 'required|integer|exists:fechas,id'
        ];
    }
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.max' => 'El correo electrónico no puede tener más de 125 caracteres.',
            'telefono.required' => 'El número de teléfono es requerido.',
            'telefono.numeric' => 'El número de teléfono debe ser numérico.',
            'telefono.digits' => 'El número de teléfono debe tener 9 dígitos.',
            'comensales.required' => 'El número de comensales es requerido.',
            'comensales.integer' => 'El número de comensales debe ser un número entero.',
            'comensales.min' => 'El número de comensales debe ser al menos 1.',
            'observaciones.string' => 'Las observaciones deben ser una cadena de texto.',
            'alergenos.distinct' => 'No puedes seleccionar más de una vez un alérgeno',
            'alergenos.exists' => 'El alergeno seleccionado no se puede encontrar',
            'fecha_id.required' => 'Debes seleccionar una fecha para hacer una reserva',
            'fecha_id.integer' => 'fecha_id debe ser tipo integer',
            'fecha_id.exists' => 'La fecha seleccionada no existe',
        ];
    }
}
