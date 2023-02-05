<?php declare(strict_types=1);

namespace VitesseCms\Mustache\DTO;

final class RenderTemplateDTO
{
    readonly string $template;
    public string $templatePath;
    readonly array $params;

    public function __construct(string $template, string $templatePath, array  $params = [])
    {
        $this->template = $template;
        $this->templatePath = $templatePath;
        $this->params = $params;
    }
}