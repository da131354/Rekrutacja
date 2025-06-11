<?php

namespace App\Http\Controllers;

use App\Models\Kandydat;
use App\Models\Kandydatura;
use App\Models\Kierunek;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $stats = [
                'total_kandydats' => Kandydat::count(),
                'total_kandydaturas' => Kandydatura::count(),
                'pending_kandydaturas' => Kandydatura::where('status', 'oczekujaca')->count(),
                'accepted_kandydaturas' => Kandydatura::where('status', 'zaakceptowana')->count(),
                'rejected_kandydaturas' => Kandydatura::where('status', 'odrzucona')->count(),
                'active_kieruneks' => Kierunek::where('aktywny', true)->count(),
            ];
            
            $recent_kandydaturas = Kandydatura::with(['kandydat', 'kierunek'])
                                              ->orderBy('data_zlozenia', 'desc')
                                              ->take(10)
                                              ->get();
            
            return view('dashboard', compact('stats', 'recent_kandydaturas'));
        } catch (\Exception $e) {
            return view('dashboard')->with('error', 'Wystąpił błąd podczas ładowania dashboardu.');
        }
    }
}
