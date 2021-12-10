<?php

namespace VitesseCms\Mustache\Controllers;

use VitesseCms\Admin\AbstractAdminController;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Form\AbstractForm;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Forms\LayoutForm;
use VitesseCms\Mustache\Models\Layout;

class AdminlayoutController extends AbstractAdminController
{
    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = Layout::class;
        $this->classForm = LayoutForm::class;
    }
}