<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use VitesseCms\Mustache\Repositories\LayoutRepository;

class LayoutListener
{
    public function __construct(private readonly LayoutRepository $layoutRepository)
    {
    }

    public function getRepository(): LayoutRepository
    {
        return $this->layoutRepository;
    }
}