@extends('layouts.app')

@section('title', 'Niedozwolona metoda - 405')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card">
                <div class="card-body py-5">
                    <i class="fas fa-ban fa-5x text-danger mb-4"></i>
                    <h1 class="display-4 mb-3">405</h1>
                    <h4 class="mb-3">Niedozwolona metoda</h4>
                    <p class="text-muted mb-4">
                        Metoda HTTP użyta w żądaniu nie jest dozwolona dla tego zasobu.
                    </p>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Strona główna
                        </a>
                        <button onclick="history.back()" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Powrót
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection