@extends('layouts.app')

@section('title', 'Kandydatura: ' . $kandydatura->kandydat->full_name)
@section('header', 'Szczegóły kandydatury')

@section('header-actions')
    <div class="btn-group">
        @if($kandydatura->status === 'oczekujaca')
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#statusModal">
                <i class="fas fa-edit me-2"></i>Zmień status
            </button>
        @endif
        <a href="{{ route('kandydaturas.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Powrót do listy
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <!-- Application Details -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-alt me-2"></i>Informacje o kandydaturze
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-5">ID kandydatury:</dt>
                            <dd class="col-sm-7">{{ $kandydatura->id }}</dd>
                            
                            <dt class="col-sm-5">Kandydat:</dt>
                            <dd class="col-sm-7">
                                <a href="{{ route('kandydats.show', $kandydatura->kandydat) }}">
                                    {{ $kandydatura->kandydat->full_name }}
                                </a>
                            </dd>
                            
                            <dt class="col-sm-5">Email:</dt>
                            <dd class="col-sm-7">{{ $kandydatura->kandydat->email }}</dd>
                            
                            <dt class="col-sm-5">Kierunek:</dt>
                            <dd class="col-sm-7">
                                <a href="{{ route('kieruneks.show', $kandydatura->kierunek) }}">
                                    {{ $kandydatura->kierunek->nazwa }}
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-5">Data złożenia:</dt>
                            <dd class="col-sm-7">{{ $kandydatura->data_zlozenia->format('d.m.Y H:i') }}</dd>
                            
                            <dt class="col-sm-5">Status:</dt>
                            <dd class="col-sm-7">
                                @if($kandydatura->status === 'oczekujaca')
                                    <span class="badge bg-warning fs-6">Oczekująca</span>
                                @elseif($kandydatura->status === 'zaakceptowana')
                                    <span class="badge bg-success fs-6">Zaakceptowana</span>
                                @else
                                    <span class="badge bg-danger fs-6">Odrzucona</span>
                                @endif
                            </dd>
                            
                            <dt class="col-sm-5">Punkty:</dt>
                            <dd class="col-sm-7">
                                @if($kandydatura->punkty_rekrutacyjne)
                                    <span class="badge bg-info fs-6">{{ number_format($kandydatura->punkty_rekrutacyjne, 2) }}</span>
                                @else
                                    <span class="text-muted">Nie przyznano</span>
                                @endif
                            </dd>
                        </dl>
                    </div>
                </div>
                
                @if($kandydatura->uwagi)
                    <hr>
                    <h6>Uwagi:</h6>
                    <p class="text-muted">{{ $kandydatura->uwagi }}</p>
                @endif
            </div>
        </div>

        <!-- Documents -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-paperclip me-2"></i>Dokumenty
                </h5>
                <a href="{{ route('dokuments.create', $kandydatura) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Dodaj dokument
                </a>
            </div>
            <div class="card-body">
                @if($kandydatura->dokuments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nazwa dokumentu</th>
                                    <th>Typ</th>
                                    <th>Rozmiar</th>
                                    <th>Status</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kandydatura->dokuments as $dokument)
                                    <tr>
                                        <td>{{ $dokument->nazwa_dokumentu }}</td>
                                        <td>
                                            <span class="badge bg-secondary">{{ strtoupper($dokument->typ_pliku) }}</span>
                                        </td>
                                        <td>{{ number_format($dokument->rozmiar_pliku / 1024, 1) }} KB</td>
                                        <td>
                                            @if($dokument->zweryfikowany)
                                                <span class="badge bg-success">Zweryfikowany</span>
                                            @else
                                                <span class="badge bg-warning">Oczekuje</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('dokuments.download', $dokument) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-file fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Brak załączonych dokumentów.</p>
                        <a href="{{ route('dokuments.create', $kandydatura) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Dodaj pierwszy dokument
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>Kandydat
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-user-circle fa-4x text-muted"></i>
                    <h6 class="mt-2">{{ $kandydatura->kandydat->full_name }}</h6>
                    <p class="text-muted small">{{ $kandydatura->kandydat->email }}</p>
                </div>
                <dl class="row small">
                    <dt class="col-6">Średnia ocen:</dt>
                    <dd class="col-6">{{ number_format($kandydatura->kandydat->srednia_ocen, 2) }}</dd>
                    
                    <dt class="col-6">Telefon:</dt>
                    <dd class="col-6">{{ $kandydatura->kandydat->telefon }}</dd>
                    
                    <dt class="col-6">Wiek:</dt>
                    <dd class="col-6">{{ $kandydatura->kandydat->data_urodzenia->age }} lat</dd>
                </dl>
                <a href="{{ route('kandydats.show', $kandydatura->kandydat) }}" class="btn btn-outline-primary btn-sm w-100">
                    Zobacz profil kandydata
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-book me-2"></i>Kierunek
                </h6>
            </div>
            <div class="card-body">
                <h6>{{ $kandydatura->kierunek->nazwa }}</h6>
                <p class="text-muted small">{{ Str::limit($kandydatura->kierunek->opis, 100) }}</p>
                <dl class="row small">
                    <dt class="col-6">Liczba miejsc:</dt>
                    <dd class="col-6">{{ $kandydatura->kierunek->liczba_miejsc }}</dd>
                    
                    <dt class="col-6">Próg punktowy:</dt>
                    <dd class="col-6">{{ $kandydatura->kierunek->prog_punktowy ?? 'Brak' }}</dd>
                </dl>
                <a href="{{ route('kieruneks.show', $kandydatura->kierunek) }}" class="btn btn-outline-primary btn-sm w-100">
                    Zobacz kierunek
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
@if($kandydatura->status === 'oczekujaca')
<div class="modal fade" id="statusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('kandydaturas.update-status', $kandydatura) }}">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Aktualizacja statusu kandydatury</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="oczekujaca" {{ $kandydatura->status === 'oczekujaca' ? 'selected' : '' }}>Oczekująca</option>
                            <option value="zaakceptowana">Zaakceptowana</option>
                            <option value="odrzucona">Odrzucona</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="punkty_rekrutacyjne" class="form-label">Punkty rekrutacyjne</label>
                        <input type="number" class="form-control" 
                               id="punkty_rekrutacyjne" 
                               name="punkty_rekrutacyjne" 
                               min="0" max="100" step="0.01"
                               value="{{ $kandydatura->punkty_rekrutacyjne }}">
                    </div>
                    <div class="mb-3">
                        <label for="uwagi" class="form-label">Uwagi</label>
                        <textarea class="form-control" 
                                  id="uwagi" 
                                  name="uwagi" 
                                  rows="3">{{ $kandydatura->uwagi }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz zmiany</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection