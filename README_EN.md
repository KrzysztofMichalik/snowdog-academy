[POLSKA WERSJA](/README.md)

# Snowdog Academy - recruitment task

In this recruitment task you will have to add a few new features to a library-like application. In the current version registered users are able to display a list of books and borrow and return them. Administrators are able to add a new book, as well as edit and delete existing ones. New users must be accepted by an administrator. New administrator account can be created using a script run from command line.

## Running the application

The application can be run directly on the host machine or using a Docker environment.

### Docker

`.env` file must be created in the main folder (you can base on `.env.example`).

From the main folder run the following command:
```
docker-compose up -d
``` 
Containers with the application and database will be created. After that install required Composer libraries:
```
docker exec -it snowdog-academy_php_1 sh -c 'composer install'
```
The application will be accessible via http://127.0.0.1:8000.

To remove the containers run:
```
docker-compose down
```

### Host
Requirements:

* [Composer](https://getcomposer.org/)
* [PHP 7.4](https://www.php.net/manual/en/install.php)
* [MySQL 5.7](https://dev.mysql.com/doc/refman/5.7/en/installing.html)

In the mail folder run a command to install required Composer packages:
```
composer install
```

After that start PHP built-in server:
```
php -S 0.0.0.0:8000 -t web/
```
The application will be accessible via http://127.0.0.1:8000.

## Creating database structure

Database configuration is placed in the `config.ini` file - it can be created based on `config.ini.example` and filled with proper values to your environment.

When the application is up and running for the first time, you have to run a script that will create all necessary tables in the database and will fill them with some data.

For Docker-based environment:
```
docker exec -it snowdog-academy_php_1 sh -c 'php console.php migrate_db'
```

For environment running on the host machine (run from the mail folder):
```
php console.php migrate_db
```

## Tasks

### Task 0
Create a fork of this repository and commit all changes there. Each task should be a separate, properly described commit.

### Task 1
Add a possibility to import books from a CSV file by administrators.

### Task 2
Add a list of books that are being borrowed for more than X days. The list should be available only for administrators.

### Task 3
Add a button to the book-edit form that is available after the ISBN number is typed in. Clicking in the button will import book data from [ISBNDB API](https://isbndb.com/api/docs/v2), [Open Library Books API](https://openlibrary.org/dev/docs/api/books) or any other API of your choice.

### Task 4
Add user types: child and adult. Add a flag to the books indicating if they are designed for children or not. Listing and borrowing adult books by children should not be allowed.

## Notes
If you think the code needs refactoring or something can be done better or be optimised - do it. For sure, it will affect the score.
