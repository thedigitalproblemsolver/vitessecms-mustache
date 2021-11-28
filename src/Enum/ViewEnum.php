<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Enum;

use VitesseCms\Core\AbstractEnum;

class ViewEnum extends AbstractEnum
{
    //public const ATTACH_SERVICE_LISTENER = 'viewService:attach';
    public const RENDER_TEMPLATE_EVENT = 'view:renderTemplate';
}
