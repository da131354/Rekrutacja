<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateKandydatRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $kandydatId = $this->route('kandydat');
        
        return [
            'imie' => 'required|string|max:100|min:2',
            'nazwisko' => 'required|string|max:100|min:2',
            'pesel' => [
                'required',
                'string',
                'size:11',
                'regex:/^[0-9]{11}$/',
                Rule::unique('kandydats', 'pesel')->ignore($kandydatId),
                
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('kandydats', 'email')->ignore($kandydatId)
            ],
            'telefon' => 'required|string|max:15|regex:/^[+]?[0-9\s\-()]{7,15}$/',
            'adres' => 'required|string|max:500',
            'data_urodzenia' => 'required|date|before:today|after:1950-01-01',
            'plec' => 'required|in:M,K',
            'szkola_srednia' => 'required|string|max:200',
            'srednia_ocen' => 'required|numeric|between:1.00,6.00',
            'zdjecie' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'imie.required' => 'Imię jest wymagane.',
            'nazwisko.required' => 'Nazwisko jest wymagane.',
            'pesel.required' => 'Numer PESEL jest wymagany.',
            'pesel.unique' => 'Kandydat z tym numerem PESEL już istnieje.',
            'email.required' => 'Adres email jest wymagany.',
            'email.unique' => 'Ten adres email jest już zajęty.',
            'srednia_ocen.between' => 'Średnia ocen musi być między 1.00 a 6.00.',
            'zdjecie.image' => 'Plik musi być obrazem.',
            'zdjecie.mimes' => 'Dozwolone formaty: JPEG, JPG, PNG, WEBP.',
            'zdjecie.max' => 'Maksymalny rozmiar zdjęcia to 2MB.',
        ];
    }
}