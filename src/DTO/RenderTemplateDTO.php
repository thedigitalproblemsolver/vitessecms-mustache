<?php declare(strict_types=1);

namespace VitesseCms\Mustache\DTO;

final class RenderTemplateDTO
{
    public function __construct(readonly string $template, public string $templatePath, readonly array  $params = []){}
}