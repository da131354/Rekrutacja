<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Kierunek extends Model
{
    use HasFactory;

    protected $fillable = [
        'nazwa', 'opis', 'liczba_miejsc', 'prog_punktowy', 'aktywny', 'zdjecie'
    ];

    protected $casts = [
        'aktywny' => 'boolean',
        'prog_punktowy' => 'decimal:2',
    ];

    public function kandydaturas()
    {
        return $this->hasMany(Kandydatura::class);
    }

    public function kandydats()
    {
        return $this->belongsToMany(Kandydat::class, 'kandydaturas');
    }

    // Accessor for image URL
    public function getZdjecieUrlAttribute()
    {
        if ($this->zdjecie && Storage::disk('public')->exists($this->zdjecie)) {
            return Storage::url($this->zdjecie);
        }
        
        // Default placeholder image
        return asset('images/default-course.jpg');
    }

    // Check if has custom image
    public function hasCustomImage()
    {
        return $this->zdjecie && Storage::disk('public')->exists($this->zdjecie);
    }
}