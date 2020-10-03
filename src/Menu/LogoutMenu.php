<?php

namespace Snowdog\Academy\Menu;

class LogoutMenu extends AbstractMenu
{
    public function getHref(): string
    {
        return '/logout';
    }

    public function getLabel(): string
    {
        return 'Logout';
    }

    public function isVisible(): bool
    {
        return (bool) $_SESSION['login'];
    }
}
