<?php declare(strict_types=1);

namespace VitesseCms\Mustache\DTO;

final class RenderLayoutDTO
{
    public function __construct(readonly string $layoutId){}
}