<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Listeners\Admin\AdminMenuListener;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        $di->eventsManager->attach(ViewEnum::RENDER_TEMPLATE_EVENT, new ViewListener(
            $di->view,
            $di->configuration->getVendorNameDir()
        ));
        $di->eventsManager->attach('assets', new AssetsListener(
            $di->configuration->getVendorNameDir(),
            AdminUtil::isAdminPage()
        ));
    }
}
