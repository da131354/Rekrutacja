@extends('layouts.app')

@section('title', 'Dodaj dokument')
@section('header', 'Dodaj dokument do kandydatury')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Dodaj dokument - {{ $kandydatura->kandydat->full_name }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('dokuments.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kandydatura_id" value="{{ $kandydatura->id }}">
                    
                    <div class="mb-3">
                        <label for="nazwa_dokumentu" class="form-label">Nazwa dokumentu *</label>
                        <input type="text" class="form-control" id="nazwa_dokumentu" name="nazwa_dokumentu" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="plik" class="form-label">Plik *</label>
                        <input type="file" class="form-control" id="plik" name="plik" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                        <div class="form-text">Dozwolone: PDF, DOC, DOCX, JPG, PNG (max 5MB)</div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Dodaj dokument</button>
                        <a href="{{ route('kandydaturas.show', $kandydatura) }}" class="btn btn-secondary">Anuluj</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection