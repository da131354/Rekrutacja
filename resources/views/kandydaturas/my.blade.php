@extends('layouts.app')

@section('title', 'Moje Kandydatury - System Rekrutacji')
@section('header', 'Moje Kandydatury')

@section('header-actions')
    <a href="{{ route('kandydaturas.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Dodaj nową kandydaturę
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Informacje o profilu kandydata -->
        @if(isset($kandydat))
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Mój profil
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Imię i nazwisko:</strong> {{ $kandydat->imie }} {{ $kandydat->nazwisko }}</p>
                            <p><strong>Email:</strong> {{ $kandydat->email }}</p>
                            <p><strong>Telefon:</strong> {{ $kandydat->telefon ?? 'Nie podano' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Średnia ocen:</strong> {{ $kandydat->srednia_ocen ?? 'Nie podano' }}</p>
                            <p><strong>Szkoła średnia:</strong> {{ $kandydat->szkola_srednia ?? 'Nie podano' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Lista kandydatur -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-file-alt me-2"></i>Moje kandydatury
                </h5>
            </div>
            <div class="card-body">
                @if($kandydaturas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kierunek</th>
                                    <th>Data złożenia</th>
                                    <th>Status</th>
                                    <th>Punkty rekrutacyjne</th>
                                    <th class="text-center">Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kandydaturas as $kandydatura)
                                    <tr>
                                        <td>
                                            <strong>{{ $kandydatura->kierunek->nazwa }}</strong>
                                            @if($kandydatura->kierunek->opis)
                                                <br><small class="text-muted">{{ Str::limit($kandydatura->kierunek->opis, 100) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $kandydatura->data_zlozenia->format('d.m.Y H:i') }}</td>
                                        <td>
                                            @if($kandydatura->status === 'oczekujaca')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>Oczekująca
                                                </span>
                                            @elseif($kandydatura->status === 'zaakceptowana')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Zaakceptowana
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>Odrzucona
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($kandydatura->punkty_rekrutacyjne)
                                                <span class="badge bg-info">
                                                    {{ number_format($kandydatura->punkty_rekrutacyjne, 2) }} pkt
                                                </span>
                                            @else
                                                <span class="text-muted">Nie oceniono</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('kandydaturas.show', $kandydatura) }}" 
                                                   class="btn btn-outline-primary" 
                                                   title="Zobacz szczegóły">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('dokuments.index', $kandydatura) }}" 
                                                   class="btn btn-outline-info" 
                                                   title="Dokumenty">
                                                    <i class="fas fa-file"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginacja -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $kandydaturas->links() }}
                    </div>
                @else
                    <!-- Brak kandydatur -->
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Nie masz jeszcze żadnych kandydatur</h4>
                        <p class="text-muted mb-4">Złóż pierwszą kandydaturę na wybrany kierunek studiów</p>
                        <a href="{{ route('kieruneks.index') }}" class="btn btn-primary me-2">
                            <i class="fas fa-book me-2"></i>Przeglądaj kierunki
                        </a>
                        <a href="{{ route('kandydaturas.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Dodaj kandydaturę
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informacje pomocne -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Informacje o statusach
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <span class="badge bg-warning me-2">Oczekująca</span>
                                Kandydatura oczekuje na rozpatrzenie
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-success me-2">Zaakceptowana</span>
                                Kandydatura została przyjęta
                            </li>
                            <li>
                                <span class="badge bg-danger me-2">Odrzucona</span>
                                Kandydatura została odrzucona
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-lightbulb me-2"></i>Wskazówki
                        </h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Dodaj dokumenty do swoich kandydatur
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-check text-success me-2"></i>
                                Sprawdzaj regularnie status kandydatur
                            </li>
                            <li>
                                <i class="fas fa-check text-success me-2"></i>
                                Skontaktuj się z administratorem w razie pytań
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection