<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokument extends Model
{
    use HasFactory;

    protected $fillable = [
        'kandydatura_id', 'nazwa_dokumentu', 'sciezka_pliku',
        'typ_pliku', 'rozmiar_pliku', 'zweryfikowany'
    ];

    protected $casts = [
        'zweryfikowany' => 'boolean',
    ];

    public function kandydatura()
    {
        return $this->belongsTo(Kandydatura::class);
    }
}