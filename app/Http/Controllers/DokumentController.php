<?php

namespace App\Http\Controllers;

use App\Models\Dokument;
use App\Models\Kandydatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumentController extends Controller
{
    public function index(Kandydatura $kandydatura)
    {
        try {
            $kandydatura->load(['kandydat', 'kierunek', 'dokuments']);
            return view('dokuments.index', compact('kandydatura'));
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas pobierania dokumentów.');
        }
    }

    public function create(Kandydatura $kandydatura)
    {
        $kandydatura->load(['kandydat', 'kierunek']);
        return view('dokuments.create', compact('kandydatura'));
    }

    public function store(Request $request)
{
    $request->validate([
        'kandydatura_id' => 'required|exists:kandydaturas,id',
        'nazwa_dokumentu' => 'required|string|max:200',
        'plik' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
    ]);

    try {
        $file = $request->file('plik');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('documents', $filename, 'public');

        Dokument::create([
            'kandydatura_id' => $request->kandydatura_id,
            'nazwa_dokumentu' => $request->nazwa_dokumentu,
            'sciezka_pliku' => $path,
            'typ_pliku' => $file->getClientOriginalExtension(),
            'rozmiar_pliku' => $file->getSize(),
            'zweryfikowany' => false
        ]);

        return redirect()->route('kandydaturas.show', $request->kandydatura_id)
                       ->with('success', 'Dokument został dodany.');
    } catch (\Exception $e) {
        return back()->with('error', 'Błąd dodawania dokumentu.');
    }
}

    public function show(Dokument $dokument)
    {
        try {
            $dokument->load(['kandydatura.kandydat', 'kandydatura.kierunek']);
            return view('dokuments.show', compact('dokument'));
        } catch (\Exception $e) {
            return back()->with('error', 'Nie można wyświetlić dokumentu.');
        }
    }

    public function update(Request $request, Dokument $dokument)
    {
        $request->validate([
            'zweryfikowany' => 'boolean',
            'uwagi' => 'nullable|string|max:500'
        ]);

        try {
            $dokument->update([
                'zweryfikowany' => $request->has('zweryfikowany'),
            ]);

            return back()->with('success', 'Status dokumentu został zaktualizowany.');
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas aktualizacji dokumentu.');
        }
    }

    public function destroy(Dokument $dokument)
    {
        try {
            // Delete file from storage
            if (Storage::disk('public')->exists($dokument->sciezka_pliku)) {
                Storage::disk('public')->delete($dokument->sciezka_pliku);
            }

            $kandydatura_id = $dokument->kandydatura_id;
            $dokument->delete();

            return redirect()->route('dokuments.index', $kandydatura_id)
                           ->with('success', 'Dokument został usunięty.');
        } catch (\Exception $e) {
            return back()->with('error', 'Nie można usunąć dokumentu.');
        }
    }

    public function download(Dokument $dokument)
    {
        try {
            if (!Storage::disk('public')->exists($dokument->sciezka_pliku)) {
                return back()->with('error', 'Plik nie został znaleziony.');
            }

            $filename = $dokument->nazwa_dokumentu . '.' . $dokument->typ_pliku;
            return Storage::disk('public')->download($dokument->sciezka_pliku, $filename);
        } catch (\Exception $e) {
            return back()->with('error', 'Wystąpił błąd podczas pobierania pliku.');
        }
    }
}