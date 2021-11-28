<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use Phalcon\Events\Event;
use Phalcon\Mvc\View;
use VitesseCms\Core\Services\ViewService;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;

class ViewListener
{
    /**
     * @var ViewService
     */
    private $viewService;

    /**
     * @var string
     */
    private $baseDir;

    public function __construct(ViewService $viewService, string $baseDir)
    {
        $this->viewService = $viewService;
        $this->baseDir = $baseDir;
    }

    public function renderTemplate( Event $event, RenderTemplateDTO $renderTemplateDTO): string
    {
        $templatePath = $renderTemplateDTO->getTemplatePath();
        $template = $renderTemplateDTO->getTemplate();
        $params = $renderTemplateDTO->getParams();

        $this->viewService->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $this->viewService->render($this->baseDir.$templatePath, $template, $params);
        $return = $this->viewService->getContent();
        $this->viewService->setRenderLevel(View::LEVEL_MAIN_LAYOUT);

        return $return;
    }
}
