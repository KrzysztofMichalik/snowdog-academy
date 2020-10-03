<?php

namespace Snowdog\Academy\Controller;

use Snowdog\Academy\Model\BorrowManager;
use Snowdog\Academy\Model\User;
use Snowdog\Academy\Model\UserManager;

class Book
{
    private BorrowManager $borrowManager;
    private User $user;

    public function __construct(BorrowManager $borrowManager, UserManager $userManager)
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /');
            return;
        }

        $this->user = $userManager->getByLogin($_SESSION['login']);
        if (!$this->user->getId()) {
            header('Location: /');
            return;
        }

        $this->borrowManager = $borrowManager;
    }

    public function borrow(int $id): void
    {
        if ($this->borrowManager->create($this->user->getId(), $id)) {
            $_SESSION['flash'] = 'You have successfully borrowed a book!';
        } else {
            $_SESSION['flash'] = 'There was an error while borrowing a book';
        }

        header('Location: /my_books');
    }

    public function return(int $id): void
    {
        if ($this->borrowManager->return($this->user->getId(), $id)) {
            $_SESSION['flash'] = 'You have successfully returned a book!';
        } else {
            $_SESSION['flash'] = 'There was an error while returning a book';
        }

        header('Location: /my_books');
    }
}
