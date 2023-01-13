<?php declare(strict_types=1);

namespace VitesseCms\Mustache\DTO;

final class RenderPartialDTO
{
    private string $partial;

    public function __construct(string $partial)
    {
        $this->partial = $partial;
    }

    public function getPartial(): string
    {
        return $this->partial;
    }
}