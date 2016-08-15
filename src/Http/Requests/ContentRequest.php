<?php

namespace designpond\newsletter\Http\Requests;

use App\Http\Requests\Request;

class ContentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::check())
        {
            return true;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'arret_id' => 'required_if:type_id,5'
        ];
    }
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'arret_id.required_if' => 'Il manque l\'identifiant de l\'arrêt, attendez que l\'arrêt s\'affiche avant d\'envoyer'
        ];
    }
}
