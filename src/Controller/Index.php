<?php

namespace Snowdog\Academy\Controller;

class Index
{
    public function index(): void
    {
        if ($_SESSION['is_admin']) {
            header('Location: /admin');
            return;
        }

        if ($_SESSION['login']) {
            header('Location: /books');
            return;
        }

        require __DIR__ . '/../view/index/index.phtml';
    }
}
