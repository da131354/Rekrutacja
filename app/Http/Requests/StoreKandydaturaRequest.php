<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKandydaturaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'kandydat_id' => 'required|exists:kandydats,id',
            'kierunek_id' => 'required|exists:kieruneks,id',
            'status' => 'in:oczekujaca,zaakceptowana,odrzucona',
            'punkty_rekrutacyjne' => 'nullable|numeric|between:0,100',
            'uwagi' => 'nullable|string|max:1000',
            'data_zlozenia' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'kandydat_id.required' => 'Kandydat jest wymagany.',
            'kandydat_id.exists' => 'Wybrany kandydat nie istnieje.',
            'kierunek_id.required' => 'Kierunek studiów jest wymagany.',
            'kierunek_id.exists' => 'Wybrany kierunek nie istnieje.',
            'punkty_rekrutacyjne.between' => 'Punkty rekrutacyjne muszą być między 0 a 100.',
            'data_zlozenia.required' => 'Data złożenia jest wymagana.',
        ];
    }
}