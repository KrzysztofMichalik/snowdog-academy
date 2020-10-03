<?php

namespace Snowdog\Academy\Controller\Admin;

use Snowdog\Academy\Model\UserManager;

class User extends AdminAbstract
{
    private UserManager $userManager;
    private string $title;
    private bool $isActive;

    public function __construct(UserManager $userManager)
    {
        parent::__construct();
        $this->userManager = $userManager;
        $this->title = '';
        $this->isActive = false;
    }

    public function activate(int $id): void
    {
        $user = $this->userManager->getById($id);

        if ($user) {
            $this->userManager->activate($id);
            $_SESSION['flash'] = 'User ' . $user->getLogin() . ' was activated';
        } else {
            $_SESSION['flash'] = 'Incorrect user!';
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function list(bool $isActive): void
    {
        $this->isActive = $isActive;
        $this->title = $isActive ? 'Active' : 'Inactive';
        require __DIR__ . '/../../view/admin/user/list.phtml';
    }

    private function getUsers(bool $isActive = true): array
    {
        return $this->userManager->getAllByIsActive($isActive);
    }
}
