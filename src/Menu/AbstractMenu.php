<?php

namespace Snowdog\Academy\Menu;

abstract class AbstractMenu
{
    abstract public function getHref(): string;

    abstract public function getLabel(): string;

    public function isActive(): bool
    {
        return $_SERVER['REQUEST_URI'] === $this->getHref();
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function __invoke()
    {
        require __DIR__ . '/../view/common/menu_item.phtml';
    }
}
