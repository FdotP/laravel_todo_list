
# Instalacja i konfiguracja aplikacji Laravel

## Spis treści
1. [Instalacja zależności npm, Composer i Artisan](#instalacja-zależności)
2. [Konfiguracja SMTP z Mailtrap](#konfiguracja-smtp-z-mailtrap)
3. [Konfiguracja API Google dla integracji z kalendarzem](#konfiguracja-api-google)
4. [Uruchomienie schedulerów i workerów w Laravel](#uruchomienie-schedulerów-i-workerów)

---

## Instalacja zależności

### 1.1 Instalacja zależności npm

Aby zainstalować wszystkie zależności npm, uruchom następujące polecenie w katalogu głównym projektu:

```bash
npm install
```


### 1.2 Instalacja zależności Composer

Aby zainstalować zależności PHP (Composer), uruchom następujące polecenie w katalogu głównym projektu:

```bash
composer install
```

### 1.2 Uzupelnienie danych potrzebnych do polaczenia z baza 

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password


### 1.3 Uruchomienie Artisan

Po zainstalowaniu zależności Composer, uruchom polecenia Artisan, aby przygotować środowisko Laravel:

```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
```


## Konfiguracja SMTP z Mailtrap

### 2.1 Rejestracja w Mailtrap

1. Zarejestruj się na [Mailtrap.io](https://mailtrap.io/).
2. Utwórz nową skrzynkę odbiorczą (Inbox) i uzyskaj dane do SMTP (username, password, host, port).

### 2.2 Konfiguracja pliku `.env`

Po uzyskaniu danych do Mailtrap, skonfiguruj plik `.env` w projekcie, aby Laravel mógł używać Mailtrap do wysyłania maili:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_FROM_ADDRESS=your_email@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

Zastąp `your_mailtrap_username` i `your_mailtrap_password` danymi, które otrzymasz z Mailtrap.



## Konfiguracja API Google dla integracji z kalendarzem

### 3.1 Tworzenie projektu w Google Cloud Console

1. Zaloguj się do [Google Cloud Console](https://console.cloud.google.com/).
2. Utwórz nowy projekt.
3. W sekcji `APIs & Services > Library` znajdź i włącz API Google Calendar.
4. W sekcji `APIs & Services > Credentials` utwórz dane uwierzytelniające OAuth 2.0 (Client ID i Client Secret).

### 3.2 Konfiguracja pliku `.env`

Po uzyskaniu danych (Client ID i Client Secret), dodaj je do pliku `.env`:

```dotenv
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

Zastąp `your_google_client_id` i `your_google_client_secret` swoimi danymi.

### 3.3 Instalacja pakietów

Wykonaj poniższe polecenia, aby zainstalować pakiet do integracji z Google API:

```bash
composer require google/apiclient:^2.0
```



## Uruchomienie schedulerów i workerów w Laravel

### 4.1 Konfiguracja Cron dla schedulera

Aby uruchomić Laravel Scheduler, dodaj poniższy wpis do crona na serwerze:

```bash
w folderze z projektem php artisan schedule:run >> /dev/null 2>&1
```

Ten cron będzie uruchamiać scheduler co minutę.

### 4.2 Uruchomienie Queue Workerów

Aby uruchomić workerów w Laravel, wykonaj poniższe polecenie:

```bash
php artisan queue:work
```

