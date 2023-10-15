<?php declare(strict_types=1);

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

    /**
     * @var string
     */
    private $coreTemplateDir;

    /**
     * @var string
     */
    private $templateDir;

    /**
     * @var string
     */
    private $accountTemplateDir;

    /**
     * @var RenderService
     */
    private $renderService;

    /**
     * @var array
     */
    private $modules;

    public function __construct(
        ViewService      $viewService,
        string           $baseDir,
        string           $templateDir,
        string           $coreTemplateDir,
        string           $accountTemplateDir,
        LayoutRepository $layoutRepository,
        RenderService    $renderService,
        array            $modules
    )
    {
        $this->viewService = $viewService;
        $this->baseDir = $baseDir;
        $this->layoutRepository = $layoutRepository;
        $this->coreTemplateDir = $coreTemplateDir;
        $this->templateDir = $templateDir;
        $this->accountTemplateDir = $accountTemplateDir;
        $this->renderService = $renderService;
        $this->modules = $modules;
    }

    public function renderPartial(Event $event, RenderPartialDTO $renderPartialDTO, Item $item = null): string
    {
        //TODO move currentItem to place wher it is fired
        $params = $renderPartialDTO->params;
        $params['currentItem'] = $item;

        if (is_file($this->templateDir . 'views/partials/fields/' . $renderPartialDTO->partial . '.mustache')) {
            $dir = $this->templateDir . 'views/partials/fields/';
        } elseif(is_file($this->templateDir . 'views/partials/' . $renderPartialDTO->partial . '.mustache')) {
            $dir = $this->templateDir . 'views/partials/';
        } elseif(is_file(str_replace($this->baseDir, '', $this->coreTemplateDir) . 'views/partials/'. $renderPartialDTO->partial . '.mustache')) {
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
