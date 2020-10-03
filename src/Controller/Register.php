<?php

namespace Snowdog\Academy\Controller;

use Snowdog\Academy\Model\UserManager;

class Register
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function index(): void
    {
        require __DIR__ . '/../view/register/index.phtml';
    }

    public function register(): void
    {
        $password = $_POST['password'];
        $confirm = $_POST['confirm'];
        $login = $_POST['login'];

        if ($password !== $confirm) {
            $_SESSION['flash'] = 'Given passwords do not match';
        } elseif (empty($password)) {
            $_SESSION['flash'] = 'Password cannot be empty!';
        } elseif (empty($login)) {
            $_SESSION['flash'] = 'Login cannot be empty!';
        } else if ($this->userManager->create($login, $password, false)) {
            $_SESSION['flash'] = 'Hello ' . $login . '! You will be able to login once your account is activated by an administrator';
            header('Location: /');
            return;
        }

        header('Location: /register');
    }
}
