<?php

namespace Snowdog\Academy\Controller;

use Snowdog\Academy\Model\BorrowManager;
use Snowdog\Academy\Model\UserManager;

class MyBooksList
{
    private BorrowManager $borrowManager;
    private UserManager $userManager;

    public function __construct(BorrowManager $borrowManager, UserManager $userManager)
    {
        $this->borrowManager = $borrowManager;
        $this->userManager = $userManager;
    }

    public function index(): void
    {
        if (!isset($_SESSION['login'])) {
            header('Location: /');
            return;
        }

        require __DIR__ . '/../view/index/my_books.phtml';
    }

    private function getBorrowedBooks(): array
    {
        $user = $this->userManager->getByLogin($_SESSION['login']);
        if (!$user->getId()) {
            return [];
        }

        return $this->borrowManager->getAllByUserId($user->getId());
    }
}
