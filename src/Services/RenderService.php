<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Services;

use Mustache_Engine;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;

class RenderService
{
    public function __construct(
        private readonly Mustache_Engine $mustacheEngine,
        private readonly string           $accountTemplateDir,
        private readonly string           $templateDir,
        private readonly string           $coreTemplateDir,
        private readonly string $languageShort
    ){}

    public function render(RenderTemplateDTO $renderTemplateDTO): string
    {
        $templatePath = $renderTemplateDTO->templatePath;
        $template = $renderTemplateDTO->template;
        $params = $renderTemplateDTO->params;

        if (is_file($templatePath . $template . '.mustache')) :
            return $this->mustacheEngine->render($this->getTemplateContent($template, $templatePath), $params);
        endif;

        if (is_file($this->accountTemplateDir . $template . '.mustache')) :
            return $this->mustacheEngine->render($this->getTemplateContent($template, $this->accountTemplateDir ), $params);
        endif;

        if (is_file($this->templateDir . $template . '.mustache')) :
            return $this->mustacheEngine->render($this->getTemplateContent($template, $this->templateDir), $params);
        endif;

        return $this->mustacheEngine->render($this->getTemplateContent($template, $this->coreTemplateDir), $params);
    }

    private function getTemplateContent(string $template, string $templatePath): string
    {
        return str_replace('[]', '.' . $this->languageShort, file_get_contents($templatePath . $template . '.mustache'));
    }
}