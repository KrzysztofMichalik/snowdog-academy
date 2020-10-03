[ENGLISH VERSION](/README_EN.md)

# Snowdog Academy - zadanie rekrutacyjne

Zadanie rekrutacyjne polega na rozbudowaniu funkcjonalności aplikacji służącej do wypożyczania książek. W aktualnej wersji zarejestrowani użytkownicy mogą wyświetlać listę książek oraz je wypożyczać i zwracać. Administratorzy mogą dodawać nowe książki oraz edytować i usuwać te już istniejące. Rejestracja nowego użytkownika musi zostać zatwierdzona przez administratora. Nowych administratorów dodaje używając skryptu uruchamianego z linii poleceń.

## Uruchomienie aplikacji
Aplikację można uruchomić bezpośrednio na hoście lub z wykorzystaniem Dockera.

### Docker
Należy utworzyć plik `.env` w głównym katalogu (na bazie `.env.example`).

Z głównego folderu aplikacji uruchomić:
```
docker-compose up -d
``` 
Zostanie utworzony kontener z aplikacją oraz bazą danych. Następnie należy zainstalować wymagane biblioteki:
```
docker exec -it snowdog-academy_php_1 sh -c 'composer install'
```
Aplikacja będzie dostępna pod adresem http://127.0.0.1:8000.

Aby usunąć utworzone kontenery należy wykonać komendę:
```
docker-compose down
```

### Host
Wymagania:

* [Composer](https://getcomposer.org/)
* [PHP 7.4](https://www.php.net/manual/en/install.php)
* [MySQL 5.7](https://dev.mysql.com/doc/refman/5.7/en/installing.html)

W folderze głównym uruchomić komendę instalującą wymagane zależności:
```
composer install
```

Następnie należy uruchomić wbudowany w PHP serwer:
```
php -S 0.0.0.0:8000 -t web/
```
Aplikacja dostępna będzie pod adresem http://127.0.0.1:8000.

## Stworzenie struktury bazy danych
Konfiguracja bazy danych znajduje się w pliku `config.ini` - można go utworzyć na podstawie pliku `config.ini.example` oraz wypełnić odpowiednimi danymi.

Po pierwszym uruchomieniu aplikacji należy wykonać skrypt, który utworzy niezbędne tabele w bazie danych oraz doda do nich kilka testowych pozycji.

Dla środowiska opartego o Dockera:
```
docker exec -it snowdog-academy_php_1 sh -c 'php console.php migrate_db'
```

Dla środowiska utworzonego na hoście (uruchamiane z głównego folderu aplikacji):
```
php console.php migrate_db
```

## Zadania

### Zadanie 0 
Zrób forka tego repozytorium i wszystkie commity wysyłaj do niego. Każde zadanie powinno być osobnym, odpowiednio opisanym commitem.

### Zadanie 1
Dodaj możliwość importowania książek z pliku CSV przez administratorów.

### Zadanie 2
Dodaj listę prezentującą książki wypożyczone dłużej niż X dni. Lista ma być dostępna tylko dla administratorów.

### Zadanie 3
Dodaj do formularza dodawania książki przycisk dostępny po wpisaniu numeru ISBN. Kliknięcie w przycisk ma powodować import danych o książce z [ISBNDB API](https://isbndb.com/api/docs/v2), [Open Library Books API](https://openlibrary.org/dev/docs/api/books) lub innego dowolnego API.

### Zadanie 4
Dodaj typy użytkowników: dziecko i dorosły. Dodaj do książek znacznik informujący, czy są przeznaczone dla dzieci czy nie. Uniemożliwij przeglądanie i wypożyczanie książek przeznaczonych dla dorosłych przez dzieci.

## Uwagi
Jeżeli uważasz, że kod aplikacji wymaga refaktoryzacji, że coś można napisać lepiej lub wydajniej niż jest to zrobione teraz - możesz to zrobić. Na pewno wpłynie to pozytywnie na wyniki rekrutacji.
