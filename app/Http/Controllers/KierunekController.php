<?php

namespace App\Http\Controllers;

use App\Models\Kierunek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KierunekController extends Controller
{
    public function index()
    {
        try {
            $kieruneks = Kierunek::withCount('kandydaturas')->orderBy('nazwa')->paginate(10);
            return view('kieruneks.index', compact('kieruneks'));
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas pobierania kierunków.');
        }
    }

    public function create()
    {
        return view('kieruneks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nazwa' => 'required|string|max:200|unique:kieruneks,nazwa',
            'opis' => 'required|string|max:1000',
            'liczba_miejsc' => 'required|integer|min:1|max:500',
            'prog_punktowy' => 'nullable|numeric|between:0,100',
            'aktywny' => 'boolean',
            'zdjecie' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048', // 2MB max
        ], [
            'nazwa.required' => 'Nazwa kierunku jest wymagana.',
            'nazwa.unique' => 'Kierunek o tej nazwie już istnieje.',
            'opis.required' => 'Opis kierunku jest wymagany.',
            'liczba_miejsc.required' => 'Liczba miejsc jest wymagana.',
            'liczba_miejsc.min' => 'Liczba miejsc musi być większa od 0.',
            'prog_punktowy.between' => 'Próg punktowy musi być między 0 a 100.',
            'zdjecie.image' => 'Plik musi być obrazem.',
            'zdjecie.mimes' => 'Dozwolone formaty: JPEG, JPG, PNG, WEBP.',
            'zdjecie.max' => 'Maksymalny rozmiar zdjęcia to 2MB.',
        ]);

        try {
            $data = $request->except('zdjecie');
            
            // Handle image upload
            if ($request->hasFile('zdjecie')) {
                $image = $request->file('zdjecie');
                $filename = time() . '_' . str_replace(' ', '_', $request->nazwa) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('kierunki', $filename, 'public');
                $data['zdjecie'] = $path;
            }

            Kierunek::create($data);
            return redirect()->route('kieruneks.index')
                           ->with('success', 'Kierunek został pomyślnie dodany.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Wystąpił błąd podczas dodawania kierunku.');
        }
    }

    public function show(Kierunek $kierunek)
    {
        try {
            $kierunek->load(['kandydaturas.kandydat']);
            $stats = [
                'total_applications' => $kierunek->kandydaturas->count(),
                'pending_applications' => $kierunek->kandydaturas->where('status', 'oczekujaca')->count(),
                'accepted_applications' => $kierunek->kandydaturas->where('status', 'zaakceptowana')->count(),
                'rejected_applications' => $kierunek->kandydaturas->where('status', 'odrzucona')->count(),
            ];
            
            return view('kieruneks.show', compact('kierunek', 'stats'));
        } catch (\Exception $e) {
            return redirect()->route('kieruneks.index')
                           ->with('error', 'Nie można wyświetlić kierunku.');
        }
    }

    public function edit(Kierunek $kierunek)
    {
        return view('kieruneks.edit', compact('kierunek'));
    }

    public function update(Request $request, Kierunek $kierunek)
    {
        $request->validate([
            'nazwa' => 'required|string|max:200|unique:kieruneks,nazwa,' . $kierunek->id,
            'opis' => 'required|string|max:1000',
            'liczba_miejsc' => 'required|integer|min:1|max:500',
            'prog_punktowy' => 'nullable|numeric|between:0,100',
            'aktywny' => 'boolean',
            'zdjecie' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        try {
            $data = $request->except('zdjecie');
            
            // Handle image upload
            if ($request->hasFile('zdjecie')) {
                // Delete old image if exists
                if ($kierunek->zdjecie && Storage::disk('public')->exists($kierunek->zdjecie)) {
                    Storage::disk('public')->delete($kierunek->zdjecie);
                }
                
                $image = $request->file('zdjecie');
                $filename = time() . '_' . str_replace(' ', '_', $request->nazwa) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('kierunki', $filename, 'public');
                $data['zdjecie'] = $path;
            }

            $kierunek->update($data);
            return redirect()->route('kieruneks.show', $kierunek)
                           ->with('success', 'Kierunek został zaktualizowany.');
        } catch (\Exception $e) {
            return back()->withInput()
                        ->with('error', 'Wystąpił błąd podczas aktualizacji kierunku.');
        }
    }

    public function destroy(Kierunek $kierunek)
    {
        try {
            // Delete image if exists
            if ($kierunek->zdjecie && Storage::disk('public')->exists($kierunek->zdjecie)) {
                Storage::disk('public')->delete($kierunek->zdjecie);
            }
            
            $kierunek->delete();
            return redirect()->route('kieruneks.index')
                           ->with('success', 'Kierunek został usunięty.');
        } catch (\Exception $e) {
            return back()->with('error', 'Nie można usunąć kierunku.');
        }
    }

    // API endpoint for active kieruneks
    public function getActive()
    {
        try {
            $kieruneks = Kierunek::where('aktywny', true)
                                ->select('id', 'nazwa', 'liczba_miejsc')
                                ->get();
            return response()->json($kieruneks);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Błąd podczas pobierania kierunków'], 500);
        }
    }
}