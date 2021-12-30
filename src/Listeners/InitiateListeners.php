<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Mustache\Listeners\Admin\AdminMenuListener;
use VitesseCms\Mustache\Listeners\Admin\AssetsListener;

class InitiateListeners  implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        if($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
    }
}
