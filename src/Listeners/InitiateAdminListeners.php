<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Media\Enums\MediaEnum;
use VitesseCms\Mustache\Controllers\AdminlayoutController;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Listeners\Admin\AdminMenuListener;
use VitesseCms\Mustache\Listeners\Admin\AssetsListener;
use VitesseCms\Mustache\Listeners\Controllers\AdminlayoutControllerListener;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        $di->eventsManager->attach(AdminlayoutController::class, new AdminlayoutControllerListener());
        $di->eventsManager->attach(
            ViewEnum::RENDER_TEMPLATE_EVENT,
            new ViewListener($di->view, $di->configuration->getVendorNameDir())
        );
        $di->eventsManager->attach(
            MediaEnum::ASSETS_LISTENER,
            new AssetsListener($di->configuration->getVendorNameDir())
        );
    }
}
