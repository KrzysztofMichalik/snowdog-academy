<?php

namespace Snowdog\Academy\Migration;

use Snowdog\Academy\Model\BookManager;
use Snowdog\Academy\Model\BorrowManager;
use Snowdog\Academy\Model\UserManager;

class Version4
{
    private UserManager $userManager;
    private BorrowManager $borrowManager;
    private BookManager $bookManager;

    public function __construct(UserManager $userManager, BorrowManager $borrowManager, BookManager $bookManager)
    {
        $this->userManager = $userManager;
        $this->borrowManager = $borrowManager;
        $this->bookManager = $bookManager;
    }

    public function __invoke()
    {
        $this->addBorrows();
    }

    private function addBorrows(): void
    {
        $users = $this->userManager->getAllByIsActive(true);
        $books = $this->bookManager->getAllBooks();

        foreach ($users as $key => $user) {
            $this->borrowManager->create($user->getId(), $books[$key]->getId());
        }
    }
}
