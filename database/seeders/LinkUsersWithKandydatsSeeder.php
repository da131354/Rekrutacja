<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kandydat;

class LinkUsersWithKandydatsSeeder extends Seeder
{
    public function run(): void
    {
        // Znajdź użytkownika kandydata
        $kandydatUser = User::where('email', 'kandydat@test.pl')->first();
        
        if ($kandydatUser) {
            // Najpierw szukaj kandydata po tym samym emailu
            $kandydat = Kandydat::where('email', 'kandydat@test.pl')->first();
            
            if ($kandydat) {
                // Kandydat o tym emailu już istnieje - połącz go z userem
                $kandydat->update(['user_id' => $kandydatUser->id]);
                echo "✅ Połączono użytkownika kandydat@test.pl z istniejącym kandydatem: {$kandydat->imie} {$kandydat->nazwisko}\n";
            } else {
                // Nie ma kandydata o tym emailu - znajdź pierwszego bez user_id
                $kandydat = Kandydat::whereNull('user_id')->first();
                
                if ($kandydat) {
                    // Zaktualizuj dane kandydata żeby pasowały do usera
                    $kandydat->update([
                        'imie' => 'Jan',
                        'nazwisko' => 'Kowalski',
                        'email' => 'kandydat@test.pl',
                        'user_id' => $kandydatUser->id
                    ]);
                    echo "✅ Zaktualizowano kandydata i połączono z użytkownikiem: Jan Kowalski\n";
                } else {
                    // Utwórz nowego kandydata
                    $kandydat = Kandydat::create([
                        'imie' => 'Jan',
                        'nazwisko' => 'Kowalski',
                        'email' => 'kandydat@test.pl',
                        'telefon' => '123456789',
                        'adres' => 'ul. Testowa 1',
                        'data_urodzenia' => '1999-01-01',
                        'plec' => 'M',
                        'szkola_srednia' => 'Liceum Testowe',
                        'srednia_ocen' => 4.5,
                        'user_id' => $kandydatUser->id
                    ]);
                    echo "✅ Utworzono nowego kandydata: Jan Kowalski\n";
                }
            }
        } else {
            echo "❌ Nie znaleziono użytkownika kandydat@test.pl\n";
        }
        
        // Dodatkowo: usuń powiązanie z Anną Kowalską jeśli zostało
        $oldKandydat = Kandydat::where('imie', 'Anna')
                              ->where('nazwisko', 'Kowalska')
                              ->where('user_id', $kandydatUser->id ?? null)
                              ->first();
        
        if ($oldKandydat) {
            $oldKandydat->update(['user_id' => null]);
            echo "✅ Usunięto powiązanie z Anna Kowalska\n";
        }
    }
}