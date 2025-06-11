@extends('layouts.app')

@section('title', 'Dodaj kierunek')
@section('header', 'Dodaj nowy kierunek studiów')

@section('header-actions')
    <a href="{{ route('kieruneks.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Powrót do listy
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book me-2"></i>
                    Formularz nowego kierunku
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kieruneks.store') }}" 
                      class="needs-validation" 
                      enctype="multipart/form-data" 
                      novalidate>
                    @csrf
                    
                    <div class="mb-3">
                        <label for="nazwa" class="form-label">Nazwa kierunku <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('nazwa') is-invalid @enderror" 
                               id="nazwa" 
                               name="nazwa" 
                               value="{{ old('nazwa') }}" 
                               required 
                               maxlength="200"
                               placeholder="np. Informatyka">
                        @error('nazwa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback">Podaj nazwę kierunku (maksymalnie 200 znaków).</div>
                    </div>

                    <div class="mb-3">
                        <label for="opis" class="form-label">Opis kierunku <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('opis') is-invalid @enderror" 
                                  id="opis" 
                                  name="opis" 
                                  rows="4" 
                                  required 
                                  maxlength="1000"
                                  placeholder="Opis kierunku studiów, specjalizacje, perspektywy zawodowe...">{{ old('opis') }}</textarea>
                        @error('opis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback">Podaj opis kierunku (maksymalnie 1000 znaków).</div>
                    </div>

                    <!-- NOWE: Upload zdjęcia -->
                    <div class="mb-3">
                        <label for="zdjecie" class="form-label">
                            <i class="fas fa-camera me-2"></i>Zdjęcie kierunku
                        </label>
                        <input type="file" 
                               class="form-control @error('zdjecie') is-invalid @enderror" 
                               id="zdjecie" 
                               name="zdjecie"
                               accept="image/jpeg,image/jpg,image/png,image/webp">
                        @error('zdjecie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Dozwolone formaty: JPEG, JPG, PNG, WEBP. Maksymalny rozmiar: 2MB.</div>
                        
                        <!-- Preview -->
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <label class="form-label">Podgląd:</label>
                            <br>
                            <img id="previewImg" src="" alt="Podgląd" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="liczba_miejsc" class="form-label">Liczba miejsc <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('liczba_miejsc') is-invalid @enderror" 
                                   id="liczba_miejsc" 
                                   name="liczba_miejsc" 
                                   value="{{ old('liczba_miejsc') }}" 
                                   required 
                                   min="1" 
                                   max="500"
                                   placeholder="np. 120">
                            @error('liczba_miejsc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Podaj liczbę miejsc (1-500).</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="prog_punktowy" class="form-label">Próg punktowy</label>
                            <input type="number" 
                                   class="form-control @error('prog_punktowy') is-invalid @enderror" 
                                   id="prog_punktowy" 
                                   name="prog_punktowy" 
                                   value="{{ old('prog_punktowy') }}" 
                                   min="0" 
                                   max="100" 
                                   step="0.01"
                                   placeholder="np. 85.50">
                            @error('prog_punktowy')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Punkty między 0 a 100 (opcjonalnie)</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input @error('aktywny') is-invalid @enderror" 
                                   type="checkbox" 
                                   id="aktywny" 
                                   name="aktywny" 
                                   value="1" 
                                   {{ old('aktywny', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="aktywny">
                                Kierunek aktywny (dostępny w rekrutacji)
                            </label>
                            @error('aktywny')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('kieruneks.index') }}" class="btn btn-secondary">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Dodaj kierunek
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Image preview
document.getElementById('zdjecie').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        // Check file size (2MB = 2097152 bytes)
        if (file.size > 2097152) {
            alert('Plik jest za duży! Maksymalny rozmiar to 2MB.');
            this.value = '';
            preview.style.display = 'none';
            return;
        }
        
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Nieprawidłowy format pliku! Dozwolone: JPEG, JPG, PNG, WEBP.');
            this.value = '';
            preview.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});
</script>
@endpush