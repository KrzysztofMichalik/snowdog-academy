<?php

namespace Snowdog\Academy\Menu;

class ActiveUsersMenu extends AbstractMenu
{
    public function getHref(): string
    {
        return '/admin/user/list/1';
    }

    public function getLabel(): string
    {
        return 'Active users';
    }

    public function isVisible(): bool
    {
        return $_SESSION['login'] && $_SESSION['is_admin'];
    }
}
