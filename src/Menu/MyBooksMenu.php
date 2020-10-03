<?php

namespace Snowdog\Academy\Menu;

class MyBooksMenu extends AbstractMenu
{
    public function getHref(): string
    {
        return '/my_books';
    }

    public function getLabel(): string
    {
        return 'My Books';
    }

    public function isVisible(): bool
    {
        return isset($_SESSION['login']) && empty($_SESSION['is_admin']);
    }
}
