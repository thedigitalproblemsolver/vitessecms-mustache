<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Mustache\Listeners\Admin\AdminMenuListener;

class InitiateListeners  implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        if($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
            $di->eventsManager->attach('assets', new AssetsListener(
                $di->configuration->getVendorNameDir(),
                AdminUtil::isAdminPage()
            ));
        endif;
    }
}
