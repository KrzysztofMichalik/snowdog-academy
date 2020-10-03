<?php

namespace Snowdog\Academy\Menu;

class InactiveUsersMenu extends AbstractMenu
{
    public function getHref(): string
    {
        return '/admin/user/list/0';
    }

    public function getLabel(): string
    {
        return 'Inactive users';
    }

    public function isVisible(): bool
    {
        return $_SESSION['login'] && $_SESSION['is_admin'];
    }
}
