<?php

namespace Snowdog\Academy\Menu;

class RegisterMenu extends AbstractMenu
{
    public function getHref(): string
    {
        return '/register';
    }

    public function getLabel(): string
    {
        return 'Register';
    }

    public function isVisible(): bool
    {
        return !$_SESSION['login'];
    }
}
