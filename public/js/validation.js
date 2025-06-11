// PESEL validation function
function validatePESEL(pesel) {
    if (pesel.length !== 11) return false;
    
    const weights = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3];
    let sum = 0;
    
    for (let i = 0; i < 10; i++) {
        sum += parseInt(pesel[i]) * weights[i];
    }
    
    const checkDigit = (10 - (sum % 10)) % 10;
    return checkDigit === parseInt(pesel[10]);
}

// Email validation function
function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Phone validation function
function validatePhone(phone) {
    const phoneRegex = /^[+]?[0-9\s\-()]{7,15}$/;
    return phoneRegex.test(phone);
}

// Real-time validation for candidate form
document.addEventListener('DOMContentLoaded', function() {
    
    // PESEL validation
    const peselInput = document.getElementById('pesel');
    if (peselInput) {
        peselInput.addEventListener('input', function() {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Limit to 11 characters
            if (this.value.length > 11) {
                this.value = this.value.substr(0, 11);
            }
            
            // Validate PESEL
            const isValid = this.value.length === 11 && validatePESEL(this.value);
            
            this.classList.remove('is-valid', 'is-invalid');
            
            if (this.value.length === 11) {
                if (isValid) {
                    this.classList.add('is-valid');
                    this.setCustomValidity('');
                } else {
                    this.classList.add('is-invalid');
                    this.setCustomValidity('Nieprawidłowy numer PESEL');
                }
            }
        });
    }

    // Email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const isValid = validateEmail(this.value);
            
            this.classList.remove('is-valid', 'is-invalid');
            
            if (this.value) {
                if (isValid) {
                    this.classList.add('is-valid');
                    this.setCustomValidity('');
                } else {
                    this.classList.add('is-invalid');
                    this.setCustomValidity('Nieprawidłowy format email');
                }
            }
        });
    }

    // Phone validation
    const phoneInput = document.getElementById('telefon');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            // Allow only valid phone characters
            this.value = this.value.replace(/[^\d\+\-\s\(\)]/g, '');
        });

        phoneInput.addEventListener('blur', function() {
            const isValid = validatePhone(this.value);
            
            this.classList.remove('is-valid', 'is-invalid');
            
            if (this.value) {
                if (isValid) {
                    this.classList.add('is-valid');
                    this.setCustomValidity('');
                } else {
                    this.classList.add('is-invalid');
                    this.setCustomValidity('Nieprawidłowy format numeru telefonu');
                }
            }
        });
    }

    // Grade validation
    const gradeInput = document.getElementById('srednia_ocen');
    if (gradeInput) {
        gradeInput.addEventListener('input', function() {
            const value = parseFloat(this.value);
            
            this.classList.remove('is-valid', 'is-invalid');
            
            if (!isNaN(value)) {
                if (value >= 1.00 && value <= 6.00) {
                    this.classList.add('is-valid');
                    this.setCustomValidity('');
                } else {
                    this.classList.add('is-invalid');
                    this.setCustomValidity('Średnia ocen musi być między 1.00 a 6.00');
                }
            }
        });
    }

    // Name validation (only letters and Polish characters)
    const nameInputs = document.querySelectorAll('#imie, #nazwisko');
    nameInputs.forEach(input => {
        input.addEventListener('input', function() {
            // Allow only letters and Polish characters
            this.value = this.value.replace(/[^a-zA-ZąćęłńóśźżĄĆĘŁŃÓŚŹŻ\s\-]/g, '');
            
            // Capitalize first letter
            this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();
        });

        input.addEventListener('blur', function() {
            const isValid = this.value.length >= 2 && this.value.length <= 100;
            
            this.classList.remove('is-valid', 'is-invalid');
            
            if (this.value) {
                if (isValid) {
                    this.classList.add('is-valid');
                    this.setCustomValidity('');
                } else {
                    this.classList.add('is-invalid');
                    this.setCustomValidity('Imię/nazwisko musi mieć od 2 do 100 znaków');
                }
            }
        });
    });

    // Date validation
    const dateInput = document.getElementById('data_urodzenia');
    if (dateInput) {
        dateInput.addEventListener('change', function() {
            const selectedDate = new Date(this.value);
            const today = new Date();
            const minDate = new Date('1950-01-01');
            
            this.classList.remove('is-valid', 'is-invalid');
            
            if (this.value) {
                if (selectedDate > minDate && selectedDate < today) {
                    this.classList.add('is-valid');
                    this.setCustomValidity('');
                } else {
                    this.classList.add('is-invalid');
                    this.setCustomValidity('Data urodzenia musi być między 1950 a dzisiejszą datą');
                }
            }
        });
    }

    // Form submission validation
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Focus on first invalid field
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
            form.classList.add('was-validated');
        });
    });

    // Character counter for text areas
    const textareas = document.querySelectorAll('textarea[maxlength]');
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        const counter = document.createElement('small');
        counter.className = 'form-text text-muted';
        counter.innerHTML = `<span class="current">0</span>/${maxLength} znaków`;
        textarea.parentNode.appendChild(counter);

        textarea.addEventListener('input', function() {
            const current = this.value.length;
            counter.querySelector('.current').textContent = current;
            
            if (current > maxLength * 0.9) {
                counter.classList.add('text-warning');
                counter.classList.remove('text-muted');
            } else {
                counter.classList.add('text-muted');
                counter.classList.remove('text-warning');
            }
        });
    });

    // Search functionality with debounce
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    // Auto-submit search form after 500ms of no typing
                    this.closest('form').submit();
                }, 500);
            }
        });
    }

    // Confirmation dialogs for delete actions
    const deleteButtons = document.querySelectorAll('button[type="submit"][class*="btn-danger"], input[type="submit"][class*="btn-danger"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const form = this.closest('form');
            if (form && form.method.toLowerCase() === 'post' && form.querySelector('input[name="_method"][value="DELETE"]')) {
                if (!confirm('Czy na pewno chcesz usunąć ten element? Ta akcja jest nieodwracalna.')) {
                    e.preventDefault();
                }
            }
        });
    });

    // Dynamic form field highlighting
    const requiredFields = document.querySelectorAll('input[required], select[required], textarea[required]');
    requiredFields.forEach(field => {
        field.addEventListener('focus', function() {
            const label = document.querySelector(`label[for="${this.id}"]`);
            if (label) {
                label.style.fontWeight = 'bold';
            }
        });

        field.addEventListener('blur', function() {
            const label = document.querySelector(`label[for="${this.id}"]`);
            if (label) {
                label.style.fontWeight = 'normal';
            }
        });
    });

    // File upload validation
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const maxSize = 5 * 1024 * 1024; // 5MB
                const allowedTypes = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];
                const fileExtension = file.name.split('.').pop().toLowerCase();
                
                this.classList.remove('is-valid', 'is-invalid');
                
                if (file.size > maxSize) {
                    this.classList.add('is-invalid');
                    this.setCustomValidity('Plik jest za duży. Maksymalny rozmiar to 5MB.');
                } else if (!allowedTypes.includes(fileExtension)) {
                    this.classList.add('is-invalid');
                    this.setCustomValidity('Nieprawidłowy format pliku. Dozwolone: PDF, DOC, DOCX, JPG, PNG.');
                } else {
                    this.classList.add('is-valid');
                    this.setCustomValidity('');
                }
            }
        });
    });
});

// Utility functions for AJAX requests
function showLoading(element) {
    element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Ładowanie...';
    element.disabled = true;
}

function hideLoading(element, originalText) {
    element.innerHTML = originalText;
    element.disabled = false;
}

// Dynamic content loading
function loadKierunks(selectElement) {
    fetch('/api/kieruneks/active')
        .then(response => response.json())
        .then(data => {
            selectElement.innerHTML = '<option value="">Wybierz kierunek</option>';
            data.forEach(kierunek => {
                selectElement.innerHTML += `<option value="${kierunek.id}">${kierunek.nazwa} (${kierunek.liczba_miejsc} miejsc)</option>`;
            });
        })
        .catch(error => {
            console.error('Błąd podczas ładowania kierunków:', error);
            selectElement.innerHTML = '<option value="">Błąd ładowania kierunków</option>';
        });
}

// Initialize dynamic selects
document.addEventListener('DOMContentLoaded', function() {
    const kierunekSelects = document.querySelectorAll('select[data-load="kieruneks"]');
    kierunekSelects.forEach(select => {
        loadKierunks(select);
    });
});

// Statistics refresh functionality
function refreshStats() {
    fetch('/api/stats')
        .then(response => response.json())
        .then(data => {
            // Update dashboard statistics
            Object.keys(data).forEach(key => {
                const element = document.querySelector(`[data-stat="${key}"]`);
                if (element) {
                    element.textContent = data[key];
                }
            });
        })
        .catch(error => {
            console.error('Błąd podczas odświeżania statystyk:', error);
        });
}

// Auto-refresh stats every 5 minutes on dashboard
if (window.location.pathname === '/' || window.location.pathname === '/dashboard') {
    setInterval(refreshStats, 5 * 60 * 1000); // 5 minutes
}