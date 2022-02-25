<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use Phalcon\Events\Event;
use Phalcon\Mvc\View;
use VitesseCms\Content\Models\Item;
use VitesseCms\Core\Services\ViewService;
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

    public function __construct(
        ViewService $viewService,
        string $baseDir,
        string $templateDir,
        string $coreTemplateDir,
        string $accountTemplateDir,
        LayoutRepository $layoutRepository,
        RenderService $renderService
    )
    {
        $this->viewService = $viewService;
        $this->baseDir = $baseDir;
        $this->layoutRepository = $layoutRepository;
        $this->coreTemplateDir = $coreTemplateDir;
        $this->templateDir = $templateDir;
        $this->accountTemplateDir = $accountTemplateDir;
        $this->renderService = $renderService;
    }

    public function renderTemplate( Event $event, RenderTemplateDTO $renderTemplateDTO, ?string $baseDir = null): string
    {
        $templatePath = $renderTemplateDTO->getTemplatePath();
        $template = $renderTemplateDTO->getTemplate();
        $params = $renderTemplateDTO->getParams();

        if(is_file($this->accountTemplateDir.$template.'.mustache')) :
            $return = $this->renderService->render($renderTemplateDTO);
        else:
            $this->viewService->setRenderLevel(View::LEVEL_ACTION_VIEW);
            $this->viewService->render(($baseDir??$this->baseDir).$templatePath, $template, $params);
            $return = $this->viewService->getContent();
            $this->viewService->setRenderLevel(View::LEVEL_MAIN_LAYOUT);
        endif;

        return $return;
    }

    public function renderPartial(Event $event, string $partial, Item $item): string
    {
        if(is_file($this->templateDir.'views/partials/fields/'.$partial.'.mustache')):
            $renderTemplateDTO = new RenderTemplateDTO(
                $partial,
                $this->templateDir.'views/partials/fields/',
                ['currentItem', $item]
            );
        else :
            $renderTemplateDTO = new RenderTemplateDTO(
                $partial,
                str_replace($this->baseDir,'', $this->coreTemplateDir).'views/partials/fields/',
                ['currentItem' => $item]
            );
        endif;

        return $this->renderTemplate($event, $renderTemplateDTO, '');
    }

    public function renderLayout(Event $event, string $layoutId): string
    {
        $layout = $this->layoutRepository->getById($layoutId);
        if($layout === null):
            return '';
        endif;

        return $layout->getHtml();
    }
}
