<?php declare(strict_types=1);

namespace VitesseCms\Mustache\DTO;

final class RenderLayoutDTO
{
    private string $layoutId;

    public function __construct(string $layoutId)
    {
        $this->layoutId = $layoutId;
    }

    public function getLayoutId(): string
    {
        return $this->layoutId;
    }
}