<?php

namespace App\Http\Controllers;

use App\Models\Kandydatura;
use App\Models\Kandydat;
use App\Models\Kierunek;
use App\Http\Requests\StoreKandydaturaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class KandydaturaController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Kandydatura::with(['kandydat', 'kierunek']);
            
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            
            if ($request->has('kierunek_id') && $request->kierunek_id != '') {
                $query->where('kierunek_id', $request->kierunek_id);
            }
            
            $kandydaturas = $query->orderBy('data_zlozenia', 'desc')->paginate(15);
            $kieruneks = Kierunek::where('aktywny', true)->get();
            
            return view('kandydaturas.index', compact('kandydaturas', 'kieruneks'));
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas pobierania kandydatur.');
        }
    }

    public function create()
    {
        $kandydats = Kandydat::all();
        $kieruneks = Kierunek::where('aktywny', true)->get();
        
        return view('kandydaturas.create', compact('kandydats', 'kieruneks'));
    }

    public function store(StoreKandydaturaRequest $request)
    {
        try {
            // Sprawdź czy kandydat już aplikował na ten kierunek
            $existingApplication = Kandydatura::where('kandydat_id', $request->kandydat_id)
                                             ->where('kierunek_id', $request->kierunek_id)
                                             ->exists();
            
            if ($existingApplication) {
                return back()->withInput()
                            ->with('error', 'Kandydat już aplikował na ten kierunek studiów.');
            }
            
            $kandydatura = Kandydatura::create($request->validated());
            
            return redirect()->route('kandydaturas.index')
                           ->with('success', 'Kandydatura została pomyślnie złożona.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Wystąpił błąd podczas składania kandydatury.');
        }
    }

    public function show(Kandydatura $kandydatura)
    {
        try {
            $kandydatura->load(['kandydat', 'kierunek', 'dokuments']);
            return view('kandydaturas.show', compact('kandydatura'));
        } catch (\Exception $e) {
            return redirect()->route('kandydaturas.index')
                           ->with('error', 'Nie można wyświetlić kandydatury.');
        }
    }

    public function updateStatus(Request $request, Kandydatura $kandydatura)
    {
        $request->validate([
            'status' => 'required|in:oczekujaca,zaakceptowana,odrzucona',
            'punkty_rekrutacyjne' => 'nullable|numeric|between:0,100',
            'uwagi' => 'nullable|string|max:1000'
        ]);

        try {
            $kandydatura->update([
                'status' => $request->status,
                'punkty_rekrutacyjne' => $request->punkty_rekrutacyjne,
                'uwagi' => $request->uwagi
            ]);

            return back()->with('success', 'Status kandydatury został zaktualizowany.');
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas aktualizacji statusu.');
        }
    }

    public function destroy(Kandydatura $kandydatura)
    {
        try {
            $kandydatura->delete();
            
            return redirect()->route('kandydaturas.index')
                           ->with('success', 'Kandydatura została usunięta.');
        } catch (\Exception $e) {
            return back()->with('error', 'Nie można usunąć kandydatury.');
        }
    }

    public function myApplications()
{
    try {
        // Sprawdź czy użytkownik ma powiązanego kandydata
        $kandydat = Auth::user()->kandydat;
        
        if (!$kandydat) {
            return redirect()->route('dashboard')
                ->with('error', 'Nie masz jeszcze profilu kandydata. Skontaktuj się z administratorem.');
        }
        
        // Pobierz kandydatury tego kandydata
        $kandydaturas = Kandydatura::with(['kierunek'])
            ->where('kandydat_id', $kandydat->id)
            ->orderBy('data_zlozenia', 'desc')
            ->paginate(10);
            
        $kieruneks = Kierunek::where('aktywny', true)->get();
        
        return view('kandydaturas.my', compact('kandydaturas', 'kieruneks', 'kandydat'));
    } catch (\Exception $e) {
        return back()->with('error', 'Wystąpił błąd podczas pobierania kandydatur.');
    }
}
}