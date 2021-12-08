<?php

namespace VitesseCms\Mustache\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Enum\ViewEnum;

class AdminlayoutController extends AbstractAdminController
{
    public function IndexAction(): void
    {
        $this->view->setVar('content', $this->eventsManager->fire(ViewEnum::RENDER_TEMPLATE_EVENT, new RenderTemplateDTO(
            'layout_editor',
            'mustache/src/Resources/admin/views'
        )));

        $this->prepareView();
    }
}