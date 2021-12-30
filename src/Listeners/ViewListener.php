<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use Phalcon\Events\Event;
use Phalcon\Mvc\View;
use VitesseCms\Core\Services\ViewService;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Repositories\LayoutRepository;

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

    /**
     * @var LayoutRepository
     */
    private $layoutRepository;

    public function __construct(
        ViewService $viewService,
        string $baseDir,
        LayoutRepository $layoutRepository
    )
    {
        $this->viewService = $viewService;
        $this->baseDir = $baseDir;
        $this->layoutRepository = $layoutRepository;
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

    public function renderLayout(Event $event, string $layoutId): string
    {
        return $this->layoutRepository->getById($layoutId)->getHtml();
    }
}
