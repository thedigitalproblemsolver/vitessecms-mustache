<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Services;

use Mustache_Engine;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;

class RenderService
{
    /**
     * @var Mustache_Engine
     */
    private $mustacheEngine;

    /**
     * @var string
     */
    private $accountTemplateDir;

    /**
     * @var string
     */
    private $templateDir;

    /**
     * @var string
     */
    private $coreTemplateDir;

    public function __construct(
        Mustache_Engine $mustacheEngine,
        string           $accountTemplateDir,
        string           $templateDir,
        string           $coreTemplateDir
    )
    {
        $this->mustacheEngine = $mustacheEngine;
        $this->accountTemplateDir = $accountTemplateDir;
        $this->templateDir = $templateDir;
        $this->coreTemplateDir = $coreTemplateDir;
    }

    public function render(RenderTemplateDTO $renderTemplateDTO): string
    {
        $templatePath = $renderTemplateDTO->getTemplatePath();
        $template = $renderTemplateDTO->getTemplate();
        $params = $renderTemplateDTO->getParams();

        if (is_file($templatePath . $template . '.mustache')) :
            return $this->mustacheEngine->render(file_get_contents($templatePath . $template . '.mustache'), $params);
        endif;

        if (is_file($this->accountTemplateDir . $template . '.mustache')) :
            return $this->mustacheEngine->render(file_get_contents($this->accountTemplateDir . $template . '.mustache'), $params);
        endif;

        if (is_file($this->templateDir . $template . '.mustache')) :
            return $this->mustacheEngine->render(file_get_contents($this->templateDir . $template . '.mustache'), $params);
        endif;

        return $this->mustacheEngine->render(file_get_contents($this->coreTemplateDir . $template . '.mustache'), $params);
    }
}