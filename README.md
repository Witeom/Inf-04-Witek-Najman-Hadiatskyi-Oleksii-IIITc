# EduResource Manager

## Wymagania

- PHP 8.1 lub nowszy
- MySQL 8 albo MariaDB
- Serwer WWW z PHP, na przyklad XAMPP lub Apache

## Uruchomienie

1. Zaimportuj plik `eduresource_managerdb 0.2(data).sql` do MySQL.
2. Umiesc projekt w katalogu serwera WWW.
3. Otworz `index.php`.

## Dane logowania

- Administrator: `admin` lub `admin@eduresource.local`, haslo `password`
- Uzytkownik: `jan` lub `jan@eduresource.local`, haslo `password`

Mozna zmienic dane logowania albo ustawienia bazowe przez zmienne srodowiskowe:

- `DB_HOST`
- `DB_NAME`
- `DB_USER`
- `DB_PASSWORD`

## Funkcje

- logowanie i role administrator/uzytkownik
- katalog zasobow z wyszukiwaniem i filtrem kategorii
- CRUD zasobow dla administratora
- wypozyczanie i zwrot zasobow
- zgloszenia problemow i zamykanie zgloszen
