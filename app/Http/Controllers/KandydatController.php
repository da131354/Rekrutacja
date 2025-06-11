<?php

namespace App\Http\Controllers;

use App\Models\Kandydat;
use App\Http\Requests\StoreKandydatRequest;
use App\Http\Requests\UpdateKandydatRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KandydatController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Kandydat::query();
            
            if ($request->has('search')) {
                $search = $request->get('search');
                $query->where(function($q) use ($search) {
                    $q->where('imie', 'like', "%{$search}%")
                      ->orWhere('nazwisko', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('pesel', 'like', "%{$search}%");
                });
            }
            
            $kandydats = $query->paginate(10);
            
            return view('kandydats.index', compact('kandydats'));
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas pobierania listy kandydatów.');
        }
    }

    public function create()
    {
        return view('kandydats.create');
    }

   public function store(StoreKandydatRequest $request)
{
    try {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('zdjecie')) {
            $image = $request->file('zdjecie');
            $filename = time() . '_' . str_replace(' ', '_', $request->imie . '_' . $request->nazwisko) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('kandydaci', $filename, 'public');
            $data['zdjecie'] = $path;
        }
        
        $kandydat = Kandydat::create($data);
        
        return redirect()->route('kandydats.index')
                       ->with('success', 'Kandydat został pomyślnie dodany.');
    } catch (\Exception $e) {
        return back()->withInput()
                    ->with('error', 'Wystąpił błąd podczas dodawania kandydata.');
    }
}
    public function show(Kandydat $kandydat)
    {
        try {
            $kandydat->load('kandydaturas.kierunek', 'kandydaturas.dokuments');
            return view('kandydats.show', compact('kandydat'));
        } catch (\Exception $e) {
            return redirect()->route('kandydats.index')
                           ->with('error', 'Nie można wyświetlić danych kandydata.');
        }
    }

    public function edit(Kandydat $kandydat)
    {
        return view('kandydats.edit', compact('kandydat'));
    }

   public function update(UpdateKandydatRequest $request, Kandydat $kandydat)
{
    try {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('zdjecie')) {
            // Delete old image if exists
            if ($kandydat->zdjecie && Storage::disk('public')->exists($kandydat->zdjecie)) {
                Storage::disk('public')->delete($kandydat->zdjecie);
            }
            
            $image = $request->file('zdjecie');
            $filename = time() . '_' . str_replace(' ', '_', $request->imie . '_' . $request->nazwisko) . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('kandydaci', $filename, 'public');
            $data['zdjecie'] = $path;
        }
        
        $kandydat->update($data);
        
        return redirect()->route('kandydats.show', $kandydat)
                       ->with('success', 'Dane kandydata zostały zaktualizowane.');
    } catch (\Exception $e) {
        return back()->withInput()
                    ->with('error', 'Wystąpił błąd podczas aktualizacji danych.');
    }
}

    public function destroy(Kandydat $kandydat)
    {
        try {
            $kandydat->delete();
            
            return redirect()->route('kandydats.index')
                           ->with('success', 'Kandydat został usunięty.');
        } catch (\Exception $e) {
            return back()->with('error', 'Nie można usunąć kandydata. Sprawdź czy nie ma powiązanych kandydatur.');
        }
    }
}