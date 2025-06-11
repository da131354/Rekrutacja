@extends('layouts.app')

@section('title', 'Lista kandydatur')
@section('header', 'Kandydatury')

@section('header-actions')
    <a href="{{ route('kandydaturas.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Dodaj kandydaturę
    </a>
@endsection

@section('content')
<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('kandydaturas.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">Wszystkie statusy</option>
                    <option value="oczekujaca" {{ request('status') === 'oczekujaca' ? 'selected' : '' }}>Oczekująca</option>
                    <option value="zaakceptowana" {{ request('status') === 'zaakceptowana' ? 'selected' : '' }}>Zaakceptowana</option>
                    <option value="odrzucona" {{ request('status') === 'odrzucona' ? 'selected' : '' }}>Odrzucona</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="kierunek_id" class="form-label">Kierunek</label>
                <select class="form-select" id="kierunek_id" name="kierunek_id">
                    <option value="">Wszystkie kierunki</option>
                    @foreach($kieruneks as $kierunek)
                        <option value="{{ $kierunek->id }}" 
                                {{ request('kierunek_id') == $kierunek->id ? 'selected' : '' }}>
                            {{ $kierunek->nazwa }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-filter me-1"></i>Filtruj
                </button>
                <a href="{{ route('kandydaturas.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Wyczyść
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Applications List -->
<div class="card">
    <div class="card-body">
        @if($kandydaturas->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Kandydat</th>
                            <th>Kierunek</th>
                            <th>Data złożenia</th>
                            <th>Status</th>
                            <th>Punkty</th>
                            <th>Dokumenty</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kandydaturas as $kandydatura)
                            <tr>
                                <td>{{ $kandydatura->id }}</td>
                                <td>
                                    <strong>{{ $kandydatura->kandydat->full_name }}</strong><br>
                                    <small class="text-muted">{{ $kandydatura->kandydat->email }}</small>
                                </td>
                                <td>{{ $kandydatura->kierunek->nazwa }}</td>
                                <td>{{ $kandydatura->data_zlozenia->format('d.m.Y H:i') }}</td>
                                <td>
                                    @if($kandydatura->status === 'oczekujaca')
                                        <span class="badge bg-warning badge-status">Oczekująca</span>
                                    @elseif($kandydatura->status === 'zaakceptowana')
                                        <span class="badge bg-success badge-status">Zaakceptowana</span>
                                    @else
                                        <span class="badge bg-danger badge-status">Odrzucona</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $kandydatura->punkty_rekrutacyjne ? number_format($kandydatura->punkty_rekrutacyjne, 2) : '-' }}
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $kandydatura->dokuments_count ?? 0 }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('kandydaturas.show', $kandydatura) }}" 
                                           class="btn btn-sm btn-outline-info" title="Zobacz">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($kandydatura->status === 'oczekujaca')
                                            <button type="button" class="btn btn-sm btn-outline-warning" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#statusModal{{ $kandydatura->id }}" 
                                                    title="Zmień status">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        @endif
                                        <form method="POST" action="{{ route('kandydaturas.destroy', $kandydatura) }}" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Czy na pewno chcesz usunąć tę kandydaturę?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Usuń">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Status Update Modal -->
                            @if($kandydatura->status === 'oczekujaca')
                                <div class="modal fade" id="statusModal{{ $kandydatura->id }}" tabindex="-1">
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
                                                        <label for="status{{ $kandydatura->id }}" class="form-label">Status</label>
                                                        <select class="form-select" id="status{{ $kandydatura->id }}" name="status" required>
                                                            <option value="oczekujaca">Oczekująca</option>
                                                            <option value="zaakceptowana">Zaakceptowana</option>
                                                            <option value="odrzucona">Odrzucona</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="punkty{{ $kandydatura->id }}" class="form-label">Punkty rekrutacyjne</label>
                                                        <input type="number" class="form-control" 
                                                               id="punkty{{ $kandydatura->id }}" 
                                                               name="punkty_rekrutacyjne" 
                                                               min="0" max="100" step="0.01"
                                                               value="{{ $kandydatura->punkty_rekrutacyjne }}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="uwagi{{ $kandydatura->id }}" class="form-label">Uwagi</label>
                                                        <textarea class="form-control" 
                                                                  id="uwagi{{ $kandydatura->id }}" 
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
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $kandydaturas->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-file-slash fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Brak kandydatur</h5>
                <p class="text-muted">Nie znaleziono kandydatur spełniających kryteria.</p>
                <a href="{{ route('kandydaturas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Dodaj pierwszą kandydaturę
                </a>
            </div>
        @endif
    </div>
</div>
@endsection