<?php declare(strict_types=1);

namespace VitesseCms\Mustache\DTO;

final class RenderPartialDTO
{
    public function __construct(readonly string $partial, readonly array $params = []) {}
}