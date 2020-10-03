<?php

namespace Snowdog\Academy\Model;

class Borrow
{
    public int $user_id;
    public int $book_id;
    public string $borrowed_at;

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getBookId(): int
    {
        return $this->book_id;
    }

    public function getBorrowedAt(): string
    {
        return $this->borrowed_at;
    }
}
