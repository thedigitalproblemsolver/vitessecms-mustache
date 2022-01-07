<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Listeners\Admin\AdminMenuListener;
use VitesseCms\Mustache\Listeners\Admin\AssetsListener;
use VitesseCms\Mustache\Repositories\LayoutRepository;

class InitiateListeners  implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach(
            ViewEnum::VIEW_LISTENER,
            new ViewListener(
                $di->view,
                $di->configuration->getVendorNameDir(),
                $di->configuration->getTemplateDir(),
                $di->configuration->getCoreTemplateDir(),
                new LayoutRepository()),
        );

        if($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
    }
}
