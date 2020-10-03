<?php

namespace Snowdog\Academy\Controller\Admin;

class AdminAbstract
{
    public function __construct()
    {
        if (empty($_SESSION['is_admin'])) {
            header('Location: /');
        }
    }
}