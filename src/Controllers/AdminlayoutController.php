<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Controllers;

use Phalcon\Events\Event;
use VitesseCms\Admin\AbstractAdminEventController;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Form\AbstractForm;
use VitesseCms\Mustache\DTO\RenderTemplateDTO;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Forms\LayoutForm;
use VitesseCms\Mustache\Models\Layout;
use VitesseCms\Mustache\Repositories\AdminRepositoriesInterface;

class AdminlayoutController extends AbstractAdminEventController implements AdminRepositoriesInterface
{
    public function onConstruct()
    {
        parent::onConstruct();

        $this->class = Layout::class;
        $this->classForm = LayoutForm::class;
    }

    public function editAction(
        string       $itemId = null,
        string       $template = 'editForm',
        string       $formTemplatePath = 'mustache/src/Resources/admin/views/',
        AbstractForm $form = null
    ): void
    {
        $this->assets->setEventLoader(ViewEnum::ASSETS_LOAD_GRID_EDITOR);
        parent::editAction($itemId, $template, $formTemplatePath, $form);
    }
}