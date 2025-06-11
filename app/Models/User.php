<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // DODAJ TO
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string', // DODAJ TO
        ];
    }

    // DODAJ METODY POMOCNICZE
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isKandydat()
    {
        return $this->role === 'kandydat';
    }

    
  public function kandydat()
{
    return $this->hasOne(\App\Models\Kandydat::class);
}
}