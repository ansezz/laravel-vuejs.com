<?php

namespace Core\Services;


use Core\Models\Post;
use Core\Repository\MenuRepository;

class MenuService
{
    /** @var MenuRepository */
    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function getMenuById($menuId)
    {
        return $this->menuRepository->where(Post::PRIMARY_KEY, $menuId);
    }
}