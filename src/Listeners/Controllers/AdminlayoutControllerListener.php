<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners\Controllers;

use Phalcon\Events\Event;
use VitesseCms\Mustache\Controllers\AdminlayoutController;
use VitesseCms\Mustache\Models\Layout;

class AdminlayoutControllerListener
{
    public function beforeEdit(Event $event, AdminlayoutController $controller, Layout $item){
        $datagroup = $controller->repositories->datagroup->getById($item->getDatagroup());
        $item->availableFields = [];
        foreach( $datagroup->getDatafields() as $datafield) :
            $item->availableFields[] = $controller->repositories->datafield->getById($datafield['id']);
        endforeach;
    }
}