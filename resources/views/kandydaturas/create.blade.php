@extends('layouts.app')

@section('title', 'Dodaj kandydaturę')
@section('header', 'Dodaj nową kandydaturę')

@section('header-actions')
    <a href="{{ route('kandydaturas.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Powrót do listy
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus me-2"></i>
                    Formularz kandydatury
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kandydaturas.store') }}" class="needs-validation" novalidate>
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kandydat_id" class="form-label">Kandydat <span class="text-danger">*</span></label>
                            <select class="form-select @error('kandydat_id') is-invalid @enderror" 
                                    id="kandydat_id" 
                                    name="kandydat_id" 
                                    required>
                                <option value="">Wybierz kandydata</option>
                                @foreach($kandydats as $kandydat)
                                    <option value="{{ $kandydat->id }}" 
                                            {{ old('kandydat_id', request('kandydat_id')) == $kandydat->id ? 'selected' : '' }}>
                                        {{ $kandydat->full_name }} ({{ $kandydat->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('kandydat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Wybierz kandydata.</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="kierunek_id" class="form-label">Kierunek studiów <span class="text-danger">*</span></label>
                            <select class="form-select @error('kierunek_id') is-invalid @enderror" 
                                    id="kierunek_id" 
                                    name="kierunek_id" 
                                    required>
                                <option value="">Wybierz kierunek</option>
                                @foreach($kieruneks as $kierunek)
                                    <option value="{{ $kierunek->id }}" 
                                            {{ old('kierunek_id') == $kierunek->id ? 'selected' : '' }}>
                                        {{ $kierunek->nazwa }} ({{ $kierunek->liczba_miejsc }} miejsc)
                                    </option>
                                @endforeach
                            </select>
                            @error('kierunek_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Wybierz kierunek studiów.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_zlozenia" class="form-label">Data złożenia <span class="text-danger">*</span></label>
                            <input type="datetime-local" 
                                   class="form-control @error('data_zlozenia') is-invalid @enderror" 
                                   id="data_zlozenia" 
                                   name="data_zlozenia" 
                                   value="{{ old('data_zlozenia', now()->format('Y-m-d\TH:i')) }}" 
                                   required>
                            @error('data_zlozenia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Podaj datę złożenia kandydatury.</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status">
                                <option value="oczekujaca" {{ old('status', 'oczekujaca') === 'oczekujaca' ? 'selected' : '' }}>Oczekująca</option>
                                <option value="zaakceptowana" {{ old('status') === 'zaakceptowana' ? 'selected' : '' }}>Zaakceptowana</option>
                                <option value="odrzucona" {{ old('status') === 'odrzucona' ? 'selected' : '' }}>Odrzucona</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="punkty_rekrutacyjne" class="form-label">Punkty rekrutacyjne</label>
                            <input type="number" 
                                   class="form-control @error('punkty_rekrutacyjne') is-invalid @enderror" 
                                   id="punkty_rekrutacyjne" 
                                   name="punkty_rekrutacyjne" 
                                   value="{{ old('punkty_rekrutacyjne') }}" 
                                   min="0" 
                                   max="100" 
                                   step="0.01"
                                   placeholder="np. 85.50">
                            @error('punkty_rekrutacyjne')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Punkty między 0 a 100 (opcjonalnie)</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="uwagi" class="form-label">Uwagi</label>
                        <textarea class="form-control @error('uwagi') is-invalid @enderror" 
                                  id="uwagi" 
                                  name="uwagi" 
                                  rows="3" 
                                  maxlength="1000"
                                  placeholder="Dodatkowe uwagi dotyczące kandydatury...">{{ old('uwagi') }}</textarea>
                        @error('uwagi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('kandydaturas.index') }}" class="btn btn-secondary">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Złóż kandydaturę
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection