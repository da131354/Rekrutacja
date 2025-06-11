@extends('layouts.app')

@section('title', 'Kandydat: ' . $kandydat->full_name)
@section('header', 'Kandydat: ' . $kandydat->full_name)

@section('header-actions')
    <div class="btn-group">
        <a href="{{ route('kandydats.edit', $kandydat) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edytuj
        </a>
        <a href="{{ route('kandydats.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Powrót do listy
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <!-- Personal Information -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>Dane osobowe
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Zdjęcie kandydata -->
                        <div class="row mb-3">
                         <div class="col-12 text-center">
                           <img src="{{ $kandydat->zdjecie_url }}" 
                            alt="{{ $kandydat->full_name }}" 
                            class="img-thumbnail" 
                           style="max-width: 200px; max-height: 200px; object-fit: cover;">
                         @if($kandydat->hasCustomImage())
                         <br>
                        <small class="text-success mt-2">
                    <i class="fas fa-check-circle"></i> Zdjęcie kandydata
            <       /small>
                    @else
                     <br>
                         <small class="text-muted mt-2">
                       <i class="fas fa-info-circle"></i> Domyślne zdjęcie
                    </small>
                      @endif
                 </div>
                     </div>
                    <hr>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Imię:</dt>
                            <dd class="col-sm-8">{{ $kandydat->imie }}</dd>
                            
                            <dt class="col-sm-4">Nazwisko:</dt>
                            <dd class="col-sm-8">{{ $kandydat->nazwisko }}</dd>
                            
                            <dt class="col-sm-4">PESEL:</dt>
                            <dd class="col-sm-8">{{ $kandydat->pesel }}</dd>
                            
                            <dt class="col-sm-4">Data urodzenia:</dt>
                            <dd class="col-sm-8">{{ $kandydat->data_urodzenia->format('d.m.Y') }}</dd>
                            
                            <dt class="col-sm-4">Płeć:</dt>
                            <dd class="col-sm-8">{{ $kandydat->plec === 'M' ? 'Mężczyzna' : 'Kobieta' }}</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Email:</dt>
                            <dd class="col-sm-8">
                                <a href="mailto:{{ $kandydat->email }}">{{ $kandydat->email }}</a>
                            </dd>
                            
                            <dt class="col-sm-4">Telefon:</dt>
                            <dd class="col-sm-8">
                                <a href="tel:{{ $kandydat->telefon }}">{{ $kandydat->telefon }}</a>
                            </dd>
                            
                            <dt class="col-sm-4">Adres:</dt>
                            <dd class="col-sm-8">{{ $kandydat->adres }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Education Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-graduation-cap me-2"></i>Wykształcenie
                </h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Szkoła średnia:</dt>
                    <dd class="col-sm-9">{{ $kandydat->szkola_srednia }}</dd>
                    
                    <dt class="col-sm-3">Średnia ocen:</dt>
                    <dd class="col-sm-9">
                        <span class="badge bg-info fs-6">{{ number_format($kandydat->srednia_ocen, 2) }}</span>
                    </dd>
                </dl>
            </div>
        </div>

        <!-- Applications -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-alt me-2"></i>Kandydatury
                </h5>
                <a href="{{ route('kandydaturas.create') }}?kandydat_id={{ $kandydat->id }}" 
                   class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Dodaj kandydaturę
                </a>
            </div>
            <div class="card-body">
                @if($kandydat->kandydaturas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Kierunek</th>
                                    <th>Data złożenia</th>
                                    <th>Status</th>
                                    <th>Punkty</th>
                                    <th>Dokumenty</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kandydat->kandydaturas as $kandydatura)
                                    <tr>
                                        <td>{{ $kandydatura->kierunek->nazwa }}</td>
                                        <td>{{ $kandydatura->data_zlozenia->format('d.m.Y') }}</td>
                                        <td>
                                            @if($kandydatura->status === 'oczekujaca')
                                                <span class="badge bg-warning">Oczekująca</span>
                                            @elseif($kandydatura->status === 'zaakceptowana')
                                                <span class="badge bg-success">Zaakceptowana</span>
                                            @else
                                                <span class="badge bg-danger">Odrzucona</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $kandydatura->punkty_rekrutacyjne ? number_format($kandydatura->punkty_rekrutacyjne, 2) : '-' }}
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $kandydatura->dokuments->count() }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('kandydaturas.show', $kandydatura) }}" 
                                               class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-inbox fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Kandydat nie złożył jeszcze żadnych kandydatur.</p>
                        <a href="{{ route('kandydaturas.create') }}?kandydat_id={{ $kandydat->id }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Dodaj pierwszą kandydaturę
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics and Quick Actions -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Statystyki
                </h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Wszystkie kandydatury:</span>
                    <span class="badge bg-primary">{{ $kandydat->kandydaturas->count() }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Oczekujące:</span>
                    <span class="badge bg-warning">{{ $kandydat->kandydaturas->where('status', 'oczekujaca')->count() }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Zaakceptowane:</span>
                    <span class="badge bg-success">{{ $kandydat->kandydaturas->where('status', 'zaakceptowana')->count() }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Odrzucone:</span>
                    <span class="badge bg-danger">{{ $kandydat->kandydaturas->where('status', 'odrzucona')->count() }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-tools me-2"></i>Akcje
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('kandydats.edit', $kandydat) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edytuj dane
                    </a>
                    <a href="{{ route('kandydaturas.create') }}?kandydat_id={{ $kandydat->id }}" 
                       class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Dodaj kandydaturę
                    </a>
                    <form method="POST" action="{{ route('kandydats.destroy', $kandydat) }}" 
                          onsubmit="return confirm('Czy na pewno chcesz usunąć tego kandydata? Ta akcja jest nieodwracalna.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-2"></i>Usuń kandydata
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection