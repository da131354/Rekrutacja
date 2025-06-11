@extends('layouts.app')

@section('title', 'Edytuj kandydata')
@section('header', 'Edytuj kandydata: ' . $kandydat->full_name)

@section('header-actions')
    <div class="btn-group">
        <a href="{{ route('kandydats.show', $kandydat) }}" class="btn btn-outline-info">
            <i class="fas fa-eye me-2"></i>Zobacz
        </a>
        <a href="{{ route('kandydats.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Powrót do listy
        </a>
    </div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2"></i>
                    Edycja danych kandydata
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('kandydats.update', $kandydat) }}" 
      class="needs-validation" 
      enctype="multipart/form-data" 
      novalidate>
                    @csrf
                    @method('PUT')
                    
                    <!-- Personal Information -->
                    <h6 class="border-bottom pb-2 mb-3">Dane osobowe</h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="imie" class="form-label">Imię <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('imie') is-invalid @enderror" 
                                   id="imie" 
                                   name="imie" 
                                   value="{{ old('imie', $kandydat->imie) }}" 
                                   required 
                                   minlength="2" 
                                   maxlength="100">
                            @error('imie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nazwisko" class="form-label">Nazwisko <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nazwisko') is-invalid @enderror" 
                                   id="nazwisko" 
                                   name="nazwisko" 
                                   value="{{ old('nazwisko', $kandydat->nazwisko) }}" 
                                   required 
                                   minlength="2" 
                                   maxlength="100">
                            @error('nazwisko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pesel" class="form-label">PESEL <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('pesel') is-invalid @enderror" 
                                   id="pesel" 
                                   name="pesel" 
                                   value="{{ old('pesel', $kandydat->pesel) }}" 
                                   required 
                                   pattern="[0-9]{11}" 
                                   maxlength="11">
                            @error('pesel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="data_urodzenia" class="form-label">Data urodzenia <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('data_urodzenia') is-invalid @enderror" 
                                   id="data_urodzenia" 
                                   name="data_urodzenia" 
                                   value="{{ old('data_urodzenia', $kandydat->data_urodzenia->format('Y-m-d')) }}" 
                                   required 
                                   min="1950-01-01" 
                                   max="{{ date('Y-m-d') }}">
                            @error('data_urodzenia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="plec" class="form-label">Płeć <span class="text-danger">*</span></label>
                            <select class="form-select @error('plec') is-invalid @enderror" id="plec" name="plec" required>
                                <option value="">Wybierz płeć</option>
                                <option value="M" {{ old('plec', $kandydat->plec) === 'M' ? 'selected' : '' }}>Mężczyzna</option>
                                <option value="K" {{ old('plec', $kandydat->plec) === 'K' ? 'selected' : '' }}>Kobieta</option>
                            </select>
                            @error('plec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <h6 class="border-bottom pb-2 mb-3 mt-4">Dane kontaktowe</h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $kandydat->email) }}" 
                                   required 
                                   maxlength="255">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="telefon" class="form-label">Telefon <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control @error('telefon') is-invalid @enderror" 
                                   id="telefon" 
                                   name="telefon" 
                                   value="{{ old('telefon', $kandydat->telefon) }}" 
                                   required 
                                   maxlength="15">
                            @error('telefon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="adres" class="form-label">Adres <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('adres') is-invalid @enderror" 
                                  id="adres" 
                                  name="adres" 
                                  rows="3" 
                                  required 
                                  maxlength="500">{{ old('adres', $kandydat->adres) }}</textarea>
                        @error('adres')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Education Information -->
                    <h6 class="border-bottom pb-2 mb-3 mt-4">Wykształcenie</h6>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="szkola_srednia" class="form-label">Szkoła średnia <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('szkola_srednia') is-invalid @enderror" 
                                   id="szkola_srednia" 
                                   name="szkola_srednia" 
                                   value="{{ old('szkola_srednia', $kandydat->szkola_srednia) }}" 
                                   required 
                                   maxlength="200">
                            @error('szkola_srednia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="srednia_ocen" class="form-label">Średnia ocen <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('srednia_ocen') is-invalid @enderror" 
                                   id="srednia_ocen" 
                                   name="srednia_ocen" 
                                   value="{{ old('srednia_ocen', $kandydat->srednia_ocen) }}" 
                                   required 
                                   min="1.00" 
                                   max="6.00" 
                                   step="0.01">
                            @error('srednia_ocen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <!-- Aktualne zdjęcie i upload nowego -->
<div class="row">
    <div class="col-12 mb-3">
        <label class="form-label">
            <i class="fas fa-camera me-2"></i>Zdjęcie kandydata
        </label>
        
        <!-- Aktualne zdjęcie -->
        <div class="mb-3">
            <label class="form-label small text-muted">Aktualne zdjęcie:</label>
            <br>
            <img src="{{ $kandydat->zdjecie_url }}" 
                 alt="{{ $kandydat->full_name }}" 
                 class="img-thumbnail" 
                 style="max-width: 150px; max-height: 150px;">
            @if($kandydat->hasCustomImage())
                <br>
                <small class="text-success">
                    <i class="fas fa-check-circle"></i> Własne zdjęcie
                </small>
            @else
                <br>
                <small class="text-muted">
                    <i class="fas fa-info-circle"></i> Domyślne zdjęcie
                </small>
            @endif
        </div>
        
        <!-- Upload nowego zdjęcia -->
        <input type="file" 
               class="form-control @error('zdjecie') is-invalid @enderror" 
               id="zdjecie" 
               name="zdjecie"
               accept="image/jpeg,image/jpg,image/png,image/webp">
        @error('zdjecie')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        <div class="form-text">
            Wybierz nowe zdjęcie aby zastąpić aktualne. Dozwolone formaty: JPEG, JPG, PNG, WEBP. Maksymalny rozmiar: 2MB.
        </div>
        
        <!-- Preview nowego zdjęcia -->
        <div id="imagePreview" class="mt-3" style="display: none;">
            <label class="form-label small text-success">Nowe zdjęcie (podgląd):</label>
            <br>
            <img id="previewImg" src="" alt="Podgląd" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
            <br>
            <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="clearImagePreview()">
                <i class="fas fa-times"></i> Anuluj zmianę
            </button>
        </div>
    </div>
</div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('kandydats.show', $kandydat) }}" class="btn btn-secondary">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Zapisz zmiany
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
// Image preview for new upload
document.getElementById('zdjecie').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (file) {
        if (file.size > 2097152) {
            alert('Plik jest za duży! Maksymalny rozmiar to 2MB.');
            this.value = '';
            preview.style.display = 'none';
            return;
        }
        
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

// Clear image preview
function clearImagePreview() {
    document.getElementById('zdjecie').value = '';
    document.getElementById('imagePreview').style.display = 'none';
}
</script>
@endpush
@endsection