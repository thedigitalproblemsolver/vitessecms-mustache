<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners\Controllers;

use Phalcon\Events\Event;
use VitesseCms\Admin\Forms\AdminlistFormInterface;
use VitesseCms\Mustache\Controllers\AdminlayoutController;

class AdminlayoutControllerListener
{
    public function adminListFilter(Event $event, AdminlayoutController $controller, AdminlistFormInterface $form): void
    {
        $form->addNameField($form);
        $form->addPublishedField($form);
    }
}