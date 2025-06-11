@extends('layouts.app')

@section('title', 'Kierunek: ' . $kierunek->nazwa)
@section('header', 'Kierunek: ' . $kierunek->nazwa)

@section('header-actions')
    <div class="btn-group">
        <a href="{{ route('kieruneks.edit', $kierunek) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>Edytuj
        </a>
        <a href="{{ route('kieruneks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Powrót do listy
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <!-- Course Details -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book me-2"></i>Informacje o kierunku
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-4">Nazwa:</dt>
                            <dd class="col-sm-8">{{ $kierunek->nazwa }}</dd>
                            
                            <dt class="col-sm-4">Status:</dt>
                            <dd class="col-sm-8">
                                @if($kierunek->aktywny)
                                    <span class="badge bg-success">Aktywny</span>
                                @else
                                    <span class="badge bg-danger">Nieaktywny</span>
                                @endif
                            </dd>
                            
                            <dt class="col-sm-4">Liczba miejsc:</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-info fs-6">{{ $kierunek->liczba_miejsc }}</span>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl class="row">
                            <dt class="col-sm-5">Próg punktowy:</dt>
                            <dd class="col-sm-7">
                                @if($kierunek->prog_punktowy)
                                    <span class="badge bg-warning fs-6">{{ number_format($kierunek->prog_punktowy, 2) }}</span>
                                @else
                                    <span class="text-muted">Nie ustalono</span>
                                @endif
                            </dd>
                            
                            <dt class="col-sm-5">Utworzony:</dt>
                            <dd class="col-sm-7">{{ $kierunek->created_at->format('d.m.Y') }}</dd>
                            
                            <dt class="col-sm-5">Ostatnia edycja:</dt>
                            <dd class="col-sm-7">{{ $kierunek->updated_at->format('d.m.Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>
                
                <hr>
                <h6>Opis kierunku:</h6>
                <p class="text-muted">{{ $kierunek->opis }}</p>
            </div>
        </div>

        <!-- Applications -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>Kandydatury na ten kierunek
                </h5>
                <a href="{{ route('kandydaturas.create') }}?kierunek_id={{ $kierunek->id }}" 
                   class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Dodaj kandydaturę
                </a>
            </div>
            <div class="card-body">
                @if($kierunek->kandydaturas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Kandydat</th>
                                    <th>Email</th>
                                    <th>Data złożenia</th>
                                    <th>Status</th>
                                    <th>Punkty</th>
                                    <th>Akcje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kierunek->kandydaturas as $kandydatura)
                                    <tr>
                                        <td>
                                            <a href="{{ route('kandydats.show', $kandydatura->kandydat) }}">
                                                {{ $kandydatura->kandydat->full_name }}
                                            </a>
                                        </td>
                                        <td>{{ $kandydatura->kandydat->email }}</td>
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
                        <p class="text-muted">Brak kandydatur na ten kierunek.</p>
                        <a href="{{ route('kandydaturas.create') }}?kierunek_id={{ $kierunek->id }}" 
                           class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Dodaj pierwszą kandydaturę
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics and Actions -->
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
                    <span class="badge bg-primary">{{ $stats['total_applications'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Oczekujące:</span>
                    <span class="badge bg-warning">{{ $stats['pending_applications'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Zaakceptowane:</span>
                    <span class="badge bg-success">{{ $stats['accepted_applications'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Odrzucone:</span>
                    <span class="badge bg-danger">{{ $stats['rejected_applications'] }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span><strong>Wolne miejsca:</strong></span>
                    <span class="badge bg-info">
                        {{ $kierunek->liczba_miejsc - $stats['accepted_applications'] }}
                    </span>
                </div>
                
                @if($stats['total_applications'] > 0)
                    <div class="mt-3">
                        <div class="progress">
                            <div class="progress-bar bg-success" 
                                 style="width: {{ ($stats['accepted_applications'] / $kierunek->liczba_miejsc) * 100 }}%">
                                {{ number_format(($stats['accepted_applications'] / $kierunek->liczba_miejsc) * 100, 1) }}%
                            </div>
                        </div>
                        <small class="text-muted">Zapełnienie miejsc</small>
                    </div>
                @endif
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
                    <a href="{{ route('kieruneks.edit', $kierunek) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>Edytuj kierunek
                    </a>
                    <a href="{{ route('kandydaturas.create') }}?kierunek_id={{ $kierunek->id }}" 
                       class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Dodaj kandydaturę
                    </a>
                    <a href="{{ route('kandydaturas.index') }}?kierunek_id={{ $kierunek->id }}" 
                       class="btn btn-outline-info">
                        <i class="fas fa-list me-2"></i>Zobacz wszystkie kandydatury
                    </a>
                    @if($stats['total_applications'] == 0)
                        <form method="POST" action="{{ route('kieruneks.destroy', $kierunek) }}" 
                              onsubmit="return confirm('Czy na pewno chcesz usunąć ten kierunek? Ta akcja jest nieodwracalna.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Usuń kierunek
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection