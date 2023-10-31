<?php

declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use Phalcon\Events\Event;
use Phalcon\Mvc\View;
use VitesseCms\Content\Models\Item;
use VitesseCms\Core\Services\ViewService;
use VitesseCms\Mustache\DTO\RenderLayoutDTO;
use VitesseCms\Mustache\DTO\RenderPartialDTO;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Repositories\LayoutRepository;
use VitesseCms\Mustache\Services\RenderService;

final class ViewListener
{
    public function __construct(
        private readonly ViewService $viewService,
        private readonly string $baseDir,
        private readonly string $templateDir,
        private readonly string $coreTemplateDir,
        private readonly string $accountTemplateDir,
        private readonly LayoutRepository $layoutRepository,
        private readonly RenderService $renderService,
        private readonly array $modules
    ) {
    }

    public function renderPartial(Event $event, RenderPartialDTO $renderPartialDTO, Item $item = null): string
    {
        //TODO move currentItem to place wher it is fired
        $params = $renderPartialDTO->params;
        $params['currentItem'] = $item;

        if (is_file($this->templateDir . 'views/partials/fields/' . $renderPartialDTO->partial . '.mustache')) {
            $dir = $this->templateDir . 'views/partials/fields/';
        } elseif (is_file($this->templateDir . 'views/partials/' . $renderPartialDTO->partial . '.mustache')) {
            $dir = $this->templateDir . 'views/partials/';
        } elseif (is_file(
            str_replace(
                $this->baseDir,
                '',
                $this->coreTemplateDir
            ) . 'views/partials/' . $renderPartialDTO->partial . '.mustache'
        )) {
            $dir = str_replace($this->baseDir, '', $this->coreTemplateDir) . 'views/partials/';
        } else {
            $dir = str_replace($this->baseDir, '', $this->coreTemplateDir) . 'views/partials/fields/';
        }

        $renderTemplateDTO = new RenderTemplateDTO($renderPartialDTO->partial, $dir, $params);

        return $this->renderTemplate($event, $renderTemplateDTO, '');
    }

    public function renderTemplate(Event $event, RenderTemplateDTO $renderTemplateDTO, ?string $baseDir = null): string
    {
        $templatePath = $renderTemplateDTO->templatePath;
        $template = $renderTemplateDTO->template;
        $params = $renderTemplateDTO->params;
        $useRenderService = false;

        foreach ($this->modules as $key => $moduleDir):
            if (is_file($moduleDir . '/Template/' . $template . '.mustache')):
                $renderTemplateDTO->templatePath = $moduleDir . '/Template/';
                $useRenderService = true;
                break;
            endif;
        endforeach;

        if ($useRenderService || is_file($this->accountTemplateDir . $template . '.mustache')) :
            $return = $this->renderService->render($renderTemplateDTO);
        else:
            $this->viewService->setRenderLevel(View::LEVEL_ACTION_VIEW);
            $this->viewService->render(($baseDir ?? $this->baseDir) . $templatePath, $template, $params);
            $return = $this->viewService->getContent();
            $this->viewService->setRenderLevel(View::LEVEL_MAIN_LAYOUT);
        endif;

        return $return;
    }

    public function renderLayout(Event $event, RenderLayoutDTO $layoutDTO): string
    {
        $layout = $this->layoutRepository->getById($layoutDTO->layoutId);
        if ($layout === null):
            return '';
        endif;

        return $layout->getHtml();
    }
}
