<?php declare(strict_types=1);

namespace VitesseCms\Mustache\DTO;

final class RenderPartialDTO
{
    readonly string $partial;
    readonly array $params;

    public function __construct(string $partial, array $params = [])
    {
        $this->partial = $partial;
        $this->params = $params;
    }
}