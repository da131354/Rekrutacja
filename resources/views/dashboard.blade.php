@extends('layouts.app')

@section('title', 'Dashboard - System Rekrutacji')
@section('header', 'Dashboard')

@section('content')
<div class="row mb-4">
    <!-- Statistics Cards -->
    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stats-card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle text-muted">Kandydaci</h6>
                        <h3 class="card-title mb-0">{{ $stats['total_kandydats'] ?? 0 }}</h3>
                    </div>
                    <div class="text-primary">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stats-card h-100" style="border-left-color: #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle text-muted">Kandydatury</h6>
                        <h3 class="card-title mb-0">{{ $stats['total_kandydaturas'] ?? 0 }}</h3>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-file-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stats-card h-100" style="border-left-color: #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle text-muted">Oczekujących</h6>
                        <h3 class="card-title mb-0">{{ $stats['pending_kandydaturas'] ?? 0 }}</h3>
                    </div>
                    <div class="text-warning">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3 mb-3">
        <div class="card stats-card h-100" style="border-left-color: #dc3545;">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-subtitle text-muted">Zaakceptowanych</h6>
                        <h3 class="card-title mb-0">{{ $stats['accepted_kandydaturas'] ?? 0 }}</h3>
                    </div>
                    <div class="text-danger">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@auth
    @if(Auth::user()->isAdmin())
        <!-- Recent Applications - TYLKO DLA ADMINÓW -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Ostatnie kandydatury
                        </h5>
                        <a href="{{ route('kandydaturas.index') }}" class="btn btn-sm btn-outline-primary">
                            Zobacz wszystkie
                        </a>
                    </div>
                    <div class="card-body">
                        @if(isset($recent_kandydaturas) && $recent_kandydaturas->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Kandydat</th>
                                            <th>Kierunek</th>
                                            <th>Data złożenia</th>
                                            <th>Status</th>
                                            <th>Punkty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_kandydaturas as $kandydatura)
                                            <tr>
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
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Brak ostatnich kandydatur</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Sekcja dla kandydatów -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-graduation-cap fa-4x text-primary mb-3"></i>
                        <h4>Witaj w systemie rekrutacji!</h4>
                        <p class="text-muted mb-4">Przeglądaj dostępne kierunki studiów i składaj kandydatury.</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('kieruneks.index') }}" class="btn btn-primary">
                                <i class="fas fa-book me-2"></i>Zobacz kierunki
                            </a>
                            <a href="{{ route('kandydaturas.my') }}" class="btn btn-outline-primary">
                                <i class="fas fa-file-alt me-2"></i>Moje kandydatury
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endauth
@endsection