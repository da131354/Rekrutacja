#!/bin/bash

echo "🎓 System Rekrutacji na Studia - Skrypt startowy"
echo "================================================"

# Sprawdź czy jesteśmy w katalogu projektu
if [ ! -f "composer.json" ]; then
    echo "❌ Błąd: Uruchom skrypt w katalogu głównym projektu Laravel"
    exit 1
fi

# Sprawdź wymagania systemowe
echo "🔍 Sprawdzanie wymagań systemowych..."

# Sprawdź PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP nie jest zainstalowane"
    exit 1
fi

PHP_VERSION=$(php -r "echo PHP_VERSION;")
echo "✅ PHP $PHP_VERSION"

# Sprawdź Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer nie jest zainstalowany"
    exit 1
fi
echo "✅ Composer zainstalowany"

# Sprawdź Node.js (opcjonalnie)
if command -v node &> /dev/null; then
    NODE_VERSION=$(node --version)
    echo "✅ Node.js $NODE_VERSION"
fi

echo ""
echo "📦 Instalowanie zależności..."

# Instaluj zależności Composer
echo "🔧 Instalowanie pakietów PHP..."
composer install --no-dev --optimize-autoloader

if [ $? -ne 0 ]; then
    echo "❌ Błąd podczas instalacji pakietów Composer"
    exit 1
fi

echo "✅ Pakiety PHP zainstalowane"

# Kopiuj plik .env jeśli nie istnieje
if [ ! -f ".env" ]; then
    echo "📝 Tworzenie pliku .env..."
    cp .env.example .env
    echo "✅ Plik .env utworzony"
else
    echo "ℹ️  Plik .env już istnieje"
fi

# Generuj klucz aplikacji
echo "🔑 Generowanie klucza aplikacji..."
php artisan key:generate

# Sprawdź połączenie z bazą danych
echo ""
echo "🗄️  Konfiguracja bazy danych..."

# Funkcja do sprawdzenia połączenia z bazą
check_database() {
    php artisan migrate:status &> /dev/null
    return $?
}

# Spróbuj połączyć się z bazą danych
if check_database; then
    echo "✅ Połączenie z bazą danych nawiązane"
else
    echo "⚠️  Nie można połączyć się z bazą danych"
    echo "📋 Sprawdź konfigurację w pliku .env:"
    echo "   - DB_HOST"
    echo "   - DB_DATABASE"
    echo "   - DB_USERNAME"
    echo "   - DB_PASSWORD"
    
    read -p "Czy chcesz kontynuować? (t/n): " continue_setup
    if [[ $continue_setup != "t" && $continue_setup != "T" ]]; then
        echo "❌ Instalacja przerwana"
        exit 1
    fi
fi

# Uruchom migracje
echo ""
echo "🔄 Uruchamianie migracji bazy danych..."
php artisan migrate --force

if [ $? -ne 0 ]; then
    echo "❌ Błąd podczas migracji bazy danych"
    echo "💡 Sprawdź konfigurację bazy danych w pliku .env"
    exit 1
fi

echo "✅ Migracje wykonane pomyślnie"

# Zapytaj o wypełnienie bazy danych przykładowymi danymi
echo ""
read -p "📊 Czy chcesz wypełnić bazę danych przykładowymi danymi? (t/n): " seed_database

if [[ $seed_database == "t" || $seed_database == "T" ]]; then
    echo "🌱 Wypełnianie bazy danych przykładowymi danymi..."
    php artisan db:seed
    
    if [ $? -eq 0 ]; then
        echo "✅ Baza danych wypełniona przykładowymi danymi"
        echo ""
        echo "📋 Utworzone przykładowe dane:"
        echo "   • 5 kierunków studiów (Informatyka, Zarządzanie, Psychologia, Budownictwo, Filologia Angielska)"
        echo "   • 23 kandydatów (3 ręcznie dodanych + 20 losowych)"
        echo "   • 30+ kandydatur z różnymi statusami"
    else
        echo "⚠️  Wystąpiły błędy podczas wypełniania bazy danych"
    fi
fi

# Utwórz link symboliczny dla storage
echo ""
echo "🔗 Tworzenie linku symbolicznego storage..."
php artisan storage:link

# Ustaw uprawnienia
echo "🔐 Ustawianie uprawnień..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || echo "ℹ️  Nie można zmienić właściciela plików (normalny błąd w środowisku deweloperskim)"

# Cache configuration (opcjonalnie dla produkcji)
if [ "$1" == "--production" ]; then
    echo ""
    echo "🚀 Optymalizacja dla środowiska produkcyjnego..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo "✅ Cache konfiguracji utworzony"
fi

# Podsumowanie
echo ""
echo "🎉 Instalacja zakończona pomyślnie!"
echo "================================================"
echo ""
echo "📋 Następne kroki:"
echo "1. Sprawdź konfigurację w pliku .env"
echo "2. Uruchom serwer: php artisan serve"
echo "3. Otwórz aplikację: http://localhost:8000"
echo ""
echo "🔧 Przydatne komendy:"
echo "   php artisan serve              - Uruchom serwer deweloperski"
echo "   php artisan migrate:fresh      - Resetuj bazę danych"
echo "   php artisan db:seed            - Wypełnij bazę przykładowymi danymi"
echo "   php artisan tinker             - Konsola Laravel"
echo ""

# Opcjonalnie uruchom serwer
read -p "🚀 Czy chcesz uruchomić serwer deweloperski teraz? (t/n): " start_server

if [[ $start_server == "t" || $start_server == "T" ]]; then
    echo ""
    echo "🌐 Uruchamianie serwera na http://localhost:8000"
    echo "💡 Aby zatrzymać serwer, naciśnij Ctrl+C"
    echo ""
    php artisan serve
fi

echo ""
echo "✨ Dziękujemy za użycie Systemu Rekrutacji na Studia!"
echo "📧 W przypadku problemów sprawdź dokumentację Laravel: https://laravel.com/docs"