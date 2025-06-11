@extends('layouts.app')

@section('title', 'Lista kandydatów')
@section('header', 'Kandydaci')

@section('header-actions')
    <a href="{{ route('kandydats.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Dodaj kandydata
    </a>
@endsection

@section('content')
<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('kandydats.index') }}" class="row g-3">
            <div class="col-md-6">
                <label for="search" class="form-label">Wyszukaj kandydata</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Imię, nazwisko, email lub PESEL...">
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i>Szukaj
                </button>
                <a href="{{ route('kandydats.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>Wyczyść
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Candidates List -->
<div class="card">
    <div class="card-body">
        @if($kandydats->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Zdjęcie</th>
                            <th>Imię i nazwisko</th>
                            <th>Email</th>
                            <th>PESEL</th>
                            <th>Telefon</th>
                            <th>Średnia ocen</th>
                            <th>Kandydatury</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kandydats as $kandydat)
                            <tr>
                                <td>{{ $kandydat->id }}</td>

                                <td>
                                <img src="{{ $kandydat->zdjecie_url }}" 
                                  alt="{{ $kandydat->full_name }}" 
                                  class="img-thumbnail" 
                                style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $kandydat->full_name }}</strong><br>
                                    <small class="text-muted">{{ $kandydat->szkola_srednia }}</small>
                                </td>
                                <td>{{ $kandydat->email }}</td>
                                <td>{{ $kandydat->pesel }}</td>
                                <td>{{ $kandydat->telefon }}</td>
                                <td>
                                    <span class="badge bg-info">{{ number_format($kandydat->srednia_ocen, 2) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $kandydat->kandydaturas->count() }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('kandydats.show', $kandydat) }}" 
                                           class="btn btn-sm btn-outline-info" title="Zobacz">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('kandydats.edit', $kandydat) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edytuj">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('kandydats.destroy', $kandydat) }}" 
                                              style="display: inline-block;" 
                                              onsubmit="return confirm('Czy na pewno chcesz usunąć tego kandydata?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Usuń">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $kandydats->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Brak kandydatów</h5>
                <p class="text-muted">Nie znaleziono kandydatów spełniających kryteria wyszukiwania.</p>
                <a href="{{ route('kandydats.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Dodaj pierwszego kandydata
                </a>
            </div>
        @endif
    </div>
</div>
@endsection