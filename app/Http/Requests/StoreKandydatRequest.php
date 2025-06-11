<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKandydatRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'imie' => 'required|string|max:100|min:2',
            'nazwisko' => 'required|string|max:100|min:2',
            'pesel' => 'required|string|size:11|unique:kandydats,pesel|regex:/^[0-9]{11}$/',
            'email' => 'required|email|unique:kandydats,email|max:255',
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
            'imie.min' => 'Imię musi mieć co najmniej 2 znaki.',
            'nazwisko.required' => 'Nazwisko jest wymagane.',
            'pesel.required' => 'Numer PESEL jest wymagany.',
            'pesel.size' => 'PESEL musi mieć dokładnie 11 cyfr.',
            'pesel.unique' => 'Kandydat z tym numerem PESEL już istnieje.',
            'pesel.regex' => 'PESEL może zawierać tylko cyfry.',
            'email.required' => 'Adres email jest wymagany.',
            'email.unique' => 'Ten adres email jest już zajęty.',
            'telefon.required' => 'Numer telefonu jest wymagany.',
            'telefon.regex' => 'Nieprawidłowy format numeru telefonu.',
            'data_urodzenia.required' => 'Data urodzenia jest wymagana.',
            'data_urodzenia.before' => 'Data urodzenia musi być wcześniejsza niż dzisiejsza.',
            'plec.required' => 'Płeć jest wymagana.',
            'plec.in' => 'Płeć musi być M (mężczyzna) lub K (kobieta).',
            'srednia_ocen.required' => 'Średnia ocen jest wymagana.',
            'srednia_ocen.between' => 'Średnia ocen musi być między 1.00 a 6.00.',
            'zdjecie.image' => 'Plik musi być obrazem.',
            'zdjecie.mimes' => 'Dozwolone formaty: JPEG, JPG, PNG, WEBP.',
            'zdjecie.max' => 'Maksymalny rozmiar zdjęcia to 2MB.',
        ];
    }
}