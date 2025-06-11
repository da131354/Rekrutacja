<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandydatura extends Model
{
    use HasFactory;

    protected $fillable = [
        'kandydat_id', 'kierunek_id', 'status', 'punkty_rekrutacyjne',
        'uwagi', 'data_zlozenia'
    ];

    protected $casts = [
        'punkty_rekrutacyjne' => 'decimal:2',
        'data_zlozenia' => 'datetime',
    ];

    public function kandydat()
    {
        return $this->belongsTo(Kandydat::class);
    }

    public function kierunek()
    {
        return $this->belongsTo(Kierunek::class);
    }

    public function dokuments()
    {
        return $this->hasMany(Dokument::class);
    }
}
