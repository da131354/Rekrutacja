@extends('layouts.app')

@section('title', 'Lista kierunków')
@section('header', 'Kierunki studiów')

@section('header-actions')
    <a href="{{ route('kieruneks.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Dodaj kierunek
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @if($kieruneks->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Zdjęcie</th>
                            <th>Nazwa kierunku</th>
                            <th>Opis</th>
                            <th>Miejsca</th>
                            <th>Próg punktowy</th>
                            <th>Kandydatury</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kieruneks as $kierunek)
                            <tr>
                                <td>{{ $kierunek->id }}</td>
                                <td>
                                    <img src="{{ $kierunek->zdjecie_url }}" 
                                         alt="{{ $kierunek->nazwa }}" 
                                         class="img-thumbnail" 
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                </td>
                                <td>
                                    <strong>{{ $kierunek->nazwa }}</strong>
                                </td>
                                <td>{{ Str::limit($kierunek->opis, 80) }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $kierunek->liczba_miejsc }}</span>
                                </td>
                                <td>
                                    @if($kierunek->prog_punktowy)
                                        <span class="badge bg-warning">{{ number_format($kierunek->prog_punktowy, 2) }}</span>
                                    @else
                                        <span class="text-muted">Brak</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $kierunek->kandydaturas_count }}</span>
                                </td>
                                <td>
                                    @if($kierunek->aktywny)
                                        <span class="badge bg-success">Aktywny</span>
                                    @else
                                        <span class="badge bg-danger">Nieaktywny</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('kieruneks.show', $kierunek) }}" 
                                           class="btn btn-sm btn-outline-info" title="Zobacz">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('kieruneks.edit', $kierunek) }}" 
                                           class="btn btn-sm btn-outline-warning" title="Edytuj">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('kieruneks.destroy', $kierunek) }}" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Czy na pewno chcesz usunąć ten kierunek? Wszystkie powiązane kandydatury zostaną również usunięte!')">
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
                {{ $kieruneks->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Brak kierunków</h5>
                <p class="text-muted">Nie dodano jeszcze żadnych kierunków studiów.</p>
                <a href="{{ route('kieruneks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Dodaj pierwszy kierunek
                </a>
            </div>
        @endif
    </div>
</div>
@endsection