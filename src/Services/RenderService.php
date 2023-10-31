<?php

declare(strict_types=1);

namespace VitesseCms\Mustache\Services;

use Mustache_Engine;
use VitesseCms\Configuration\Services\ConfigService;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Setting\Services\SettingService;

class RenderService
{
    public function __construct(
        private readonly Mustache_Engine $mustacheEngine,
        private readonly string $accountTemplateDir,
        private readonly string $templateDir,
        private readonly string $coreTemplateDir,
        private readonly string $languageShort,
        private readonly SettingService $settingService,
        private readonly ConfigService $configService
    ) {
    }

    public function render(RenderTemplateDTO $renderTemplateDTO): string
    {
        $templatePath = $renderTemplateDTO->templatePath;
        $template = $renderTemplateDTO->template;
        $params = $renderTemplateDTO->params;
        $parseSettings = $renderTemplateDTO->parseSettings;

        if (is_file($templatePath . $template . '.mustache')) {
            $params = $this->getParams($template, $templatePath, $parseSettings, $params);

            return $this->mustacheEngine->render(
                $this->getTemplateContent($template, $templatePath),
                $params
            );
        }

        if (is_file($this->accountTemplateDir . $template . '.mustache')) {
            $params = $this->getParams($template, $this->accountTemplateDir, $parseSettings, $params);

            return $this->mustacheEngine->render(
                $this->getTemplateContent($template, $this->accountTemplateDir),
                $params
            );
        }

        if (is_file($this->templateDir . $template . '.mustache')) {
            $params = $this->getParams($template, $this->templateDir, $parseSettings, $params);

            return $this->mustacheEngine->render(
                $this->getTemplateContent($template, $this->templateDir),
                $params
            );
        }

        $params = $this->getParams($template, $this->coreTemplateDir, $parseSettings, $params);

        return $this->mustacheEngine->render(
            $this->getTemplateContent($template, $this->coreTemplateDir),
            $params
        );
    }

    private function getParams(string $template, string $templatePath, bool $parseSettings, array $params): array
    {
        $params['BASE_URI'] = $this->configService->getBaseUri();
        $params['UPLOAD_URI'] = $this->configService->getUploadUri();

        if ($parseSettings) {
            $settings = $this->settingService->getSettingsFromString(
                $this->getTemplateContent($template, $templatePath)
            );
            foreach ($settings as $value) {
                $params[$value] = $this->settingService->getString($value);
            }
        }

        return $params;
    }

    private function getTemplateContent(string $template, string $templatePath): string
    {
        return str_replace(
            '[]',
            '.' . $this->languageShort,
            file_get_contents($templatePath . $template . '.mustache')
        );
    }
}