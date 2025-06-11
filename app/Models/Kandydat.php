<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kandydat extends Model
{
    use HasFactory;

    protected $fillable = [
    'imie', 'nazwisko', 'pesel', 'email', 'telefon',
    'adres', 'data_urodzenia', 'plec', 'szkola_srednia', 'srednia_ocen', 'zdjecie', 'user_id'
];

    protected $casts = [
        'data_urodzenia' => 'date',
        'srednia_ocen' => 'decimal:2',
    ];

    public function kandydaturas()
    {
        return $this->hasMany(Kandydatura::class);
    }

    public function kieruneks()
    {
        return $this->belongsToMany(Kierunek::class, 'kandydaturas');
    }

    public function getFullNameAttribute()
    {
        return $this->imie . ' ' . $this->nazwisko;
    }
    // Accessor for image URL
public function getZdjecieUrlAttribute()
{
    if ($this->zdjecie && \Storage::disk('public')->exists($this->zdjecie)) {
        return \Storage::url($this->zdjecie);
    }
    
    // Default placeholder image
    return 'https://via.placeholder.com/200x200/28a745/ffffff?text=Kandydat';
}

// Check if has custom image
public function hasCustomImage()
{
    return $this->zdjecie && \Storage::disk('public')->exists($this->zdjecie);
}

public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}
