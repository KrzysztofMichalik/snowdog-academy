<?php

namespace Snowdog\Academy\Model;

use Exception;
use Snowdog\Academy\Core\Database;

class BorrowManager
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getByBookId(int $bookId)
    {
        $query = $this->database->prepare('SELECT * FROM borrows WHERE book_id = :book_id');
        $query->setFetchMode(Database::FETCH_CLASS, Borrow::class);
        $query->bindParam(':book_id', $bookId, Database::PARAM_INT);
        $query->execute();

        return $query->fetch(Database::FETCH_CLASS);
    }

    public function getAllByUserId(int $userId): array
    {
        $query = $this->database->prepare('SELECT books.*, borrows.borrowed_at FROM books LEFT JOIN borrows ON borrows.book_id = books.id WHERE user_id = :user_id');
        $query->bindParam(':user_id', $userId, Database::PARAM_INT);
        $query->execute();

        return $query->fetchAll(Database::FETCH_CLASS, Book::class);
    }

    public function create(int $userId, int $bookId): bool
    {
        try {
            $this->database->beginTransaction();

            $statement = $this->database->prepare('INSERT INTO borrows (user_id, book_id, borrowed_at) VALUES (:user_id, :book_id, NOW())');
            $statement->bindParam(':user_id', $userId, Database::PARAM_INT);
            $statement->bindParam(':book_id', $bookId, Database::PARAM_INT);
            $statement->execute();

            $statement = $this->database->prepare('UPDATE books SET borrowed = 1 WHERE id = :book_id');
            $statement->bindParam(':book_id', $bookId, Database::PARAM_INT);
            $statement->execute();

            $this->database->commit();

            return true;
        } catch (Exception $e) {
            $this->database->rollBack();

            return false;
        }
    }

    public function return(int $userId, int $bookId): bool
    {
        try {
            $this->database->beginTransaction();

            $statement = $this->database->prepare('DELETE FROM  borrows WHERE book_id = :book_id AND user_id = :user_id');
            $statement->bindParam(':user_id', $userId, Database::PARAM_INT);
            $statement->bindParam(':book_id', $bookId, Database::PARAM_INT);
            $statement->execute();

            $statement = $this->database->prepare('UPDATE books SET borrowed = 0 WHERE id = :book_id');
            $statement->bindParam(':book_id', $bookId, Database::PARAM_INT);
            $statement->execute();

            $this->database->commit();

            return true;
        } catch (Exception $e) {
            $this->database->rollBack();

            return false;
        }
    }
}
