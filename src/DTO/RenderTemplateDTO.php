<?php

declare(strict_types=1);

namespace VitesseCms\Mustache\DTO;

final class RenderTemplateDTO
{
    public function __construct(
        public readonly string $template,
        public string $templatePath,
        public readonly array $params = [],
        public readonly bool $parseSettings = false
    ) {
    }
}