<?php

namespace Snowdog\Academy\Model;

class User
{
    public int $id;
    public string $login;
    public string $password;
    public bool $is_admin;
    public bool $is_active;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function getPasswordHash(): string
    {
        return $this->password;
    }

    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
}
