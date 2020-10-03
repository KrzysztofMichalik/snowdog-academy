<?php

namespace Snowdog\Academy\Model;

use Snowdog\Academy\Core\Database;

class UserManager
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function getByLogin(string $login): User
    {
        $query = $this->database->prepare('SELECT * FROM users WHERE login = :login');
        $query->setFetchMode(Database::FETCH_CLASS, User::class);
        $query->bindParam(':login', $login, Database::PARAM_STR);
        $query->execute();

        return $query->fetch(Database::FETCH_CLASS);
    }

    public function getById(int $id): User
    {
        $query = $this->database->prepare('SELECT * FROM users WHERE id = :id');
        $query->setFetchMode(Database::FETCH_CLASS, User::class);
        $query->bindParam(':id', $id, Database::PARAM_INT);
        $query->execute();

        return $query->fetch(Database::FETCH_CLASS);
    }

    public function create(string $login, string $password, bool $isAdmin = false, bool $isActive = false): int
    {
        $hash = $this->hashPassword($password);
        $statement = $this->database->prepare('INSERT INTO users (login, password, is_admin, is_active) VALUES (:login, :password, :is_admin, :is_active)');
        $statement->bindParam(':login', $login, Database::PARAM_STR);
        $statement->bindParam(':password', $hash, Database::PARAM_STR);
        $statement->bindParam(':is_admin', $isAdmin, Database::PARAM_BOOL);
        $statement->bindParam(':is_active', $isActive, Database::PARAM_BOOL);
        $statement->execute();

        return (int) $this->database->lastInsertId();
    }

    public function activate(int $id): bool
    {
        $statement = $this->database->prepare('UPDATE users SET is_active = 1 WHERE id = :id');
        $statement->bindParam(':id', $id, Database::PARAM_INT);

        return $statement->execute();
    }

    public function getAllByIsActive(bool $isActive = true): array
    {
        $query = $this->database->prepare('SELECT * FROM users WHERE is_admin = 0 AND is_active = :is_active');
        $query->bindParam(':is_active', $isActive, Database::PARAM_BOOL);
        $query->execute();

        return $query->fetchAll(Database::FETCH_CLASS, User::class);
    }

    public function verifyPassword(User $user, $password): bool
    {
        return $this->hashPassword($password) === $user->getPasswordHash();
    }

    private function hashPassword(string $password): string
    {
        return hash('sha512', $password);
    }
}
