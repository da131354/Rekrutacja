@extends('layouts.app')

@section('title', 'Dodaj kandydata')
@section('header', 'Dodaj nowego kandydata')

@section('header-actions')
    <a href="{{ route('kandydats.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Powrót do listy
    </a>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-plus me-2"></i>
                    Formularz rejestracji kandydata
                </h5>
            </div>
            <div class="card-body">
             <form method="POST" action="{{ route('kandydats.store') }}" 
             class="needs-validation" 
             enctype="multipart/form-data" 
             novalidate>
                    @csrf
                    
                    <!-- Personal Information -->
                    <h6 class="border-bottom pb-2 mb-3">Dane osobowe</h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="imie" class="form-label">Imię <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('imie') is-invalid @enderror" 
                                   id="imie" 
                                   name="imie" 
                                   value="{{ old('imie') }}" 
                                   required 
                                   minlength="2" 
                                   maxlength="100">
                            @error('imie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Podaj prawidłowe imię (2-100 znaków).</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nazwisko" class="form-label">Nazwisko <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('nazwisko') is-invalid @enderror" 
                                   id="nazwisko" 
                                   name="nazwisko" 
                                   value="{{ old('nazwisko') }}" 
                                   required 
                                   minlength="2" 
                                   maxlength="100">
                            @error('nazwisko')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Podaj prawidłowe nazwisko (2-100 znaków).</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pesel" class="form-label">PESEL <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('pesel') is-invalid @enderror" 
                                   id="pesel" 
                                   name="pesel" 
                                   value="{{ old('pesel') }}" 
                                   required 
                                   pattern="[0-9]{11}" 
                                   maxlength="11"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            @error('pesel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">PESEL musi składać się z 11 cyfr.</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="data_urodzenia" class="form-label">Data urodzenia <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control @error('data_urodzenia') is-invalid @enderror" 
                                   id="data_urodzenia" 
                                   name="data_urodzenia" 
                                   value="{{ old('data_urodzenia') }}" 
                                   required 
                                   min="1950-01-01" 
                                   max="{{ date('Y-m-d') }}">
                            @error('data_urodzenia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Podaj prawidłową datę urodzenia.</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="plec" class="form-label">Płeć <span class="text-danger">*</span></label>
                            <select class="form-select @error('plec') is-invalid @enderror" id="plec" name="plec" required>
                                <option value="">Wybierz płeć</option>
                                <option value="M" {{ old('plec') === 'M' ? 'selected' : '' }}>Mężczyzna</option>
                                <option value="K" {{ old('plec') === 'K' ? 'selected' : '' }}>Kobieta</option>
                            </select>
                            @error('plec')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Wybierz płeć.</div>
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
                                   value="{{ old('email') }}" 
                                   required 
                                   maxlength="255">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Podaj prawidłowy adres email.</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="telefon" class="form-label">Telefon <span class="text-danger">*</span></label>
                            <input type="tel" 
                                   class="form-control @error('telefon') is-invalid @enderror" 
                                   id="telefon" 
                                   name="telefon" 
                                   value="{{ old('telefon') }}" 
                                   required 
                                   maxlength="15"
                                   placeholder="+48 123 456 789">
                            @error('telefon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Podaj prawidłowy numer telefonu.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="adres" class="form-label">Adres <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('adres') is-invalid @enderror" 
                                  id="adres" 
                                  name="adres" 
                                  rows="3" 
                                  required 
                                  maxlength="500">{{ old('adres') }}</textarea>
                        @error('adres')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback">Podaj prawidłowy adres (maksymalnie 500 znaków).</div>
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
                                   value="{{ old('szkola_srednia') }}" 
                                   required 
                                   maxlength="200"
                                   placeholder="Nazwa szkoły średniej">
                            @error('szkola_srednia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Podaj nazwę szkoły średniej.</div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="srednia_ocen" class="form-label">Średnia ocen <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control @error('srednia_ocen') is-invalid @enderror" 
                                   id="srednia_ocen" 
                                   name="srednia_ocen" 
                                   value="{{ old('srednia_ocen') }}" 
                                   required 
                                   min="1.00" 
                                   max="6.00" 
                                   step="0.01"
                                   placeholder="np. 4.50">
                            @error('srednia_ocen')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback">Średnia ocen musi być między 1.00 a 6.00.</div>
                        </div>
                    </div>
                    <!-- NOWE: Upload zdjęcia -->
                        <div class="row">
                            <div class="col-12 mb-3">
                     <label for="zdjecie" class="form-label">
                 <i class="fas fa-camera me-2"></i>Zdjęcie kandydata
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
            <img id="previewImg" src="" alt="Podgląd" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
        </div>
    </div>
</div>

                    <!-- Submit Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('kandydats.index') }}" class="btn btn-secondary">Anuluj</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Zapisz kandydata
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
// Image preview
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
</script>
@endpush
@endsection

@push('scripts')
<script>
    // PESEL validation
    document.getElementById('pesel').addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Limit to 11 characters
        if (this.value.length > 11) {
            this.value = this.value.substr(0, 11);
        }
        
        // Basic PESEL validation
        if (this.value.length === 11) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
        }
    });

    // Phone number formatting
    document.getElementById('telefon').addEventListener('input', function(e) {
        let value = this.value.replace(/[^\d\+\-\s\(\)]/g, '');
        this.value = value;
    });

    // Grade validation
    document.getElementById('srednia_ocen').addEventListener('input', function(e) {
        let value = parseFloat(this.value);
        if (value >= 1.00 && value <= 6.00) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
        }
    });
</script>
@endpush