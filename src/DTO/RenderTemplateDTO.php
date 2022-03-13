<?php declare(strict_types=1);

namespace VitesseCms\Mustache\DTO;

final class RenderTemplateDTO
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var string
     */
    private $templatePath;

    /**
     * @var array
     */
    private $params;

    public function __construct(string $template, string $templatePath, array  $params = [])
    {
        $this->template = $template;
        $this->templatePath = $templatePath;
        $this->params = $params;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getTemplatePath(): string
    {
        return $this->templatePath;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setTemplatePath(string $templatePath): void
    {
        $this->templatePath = $templatePath;
    }
}