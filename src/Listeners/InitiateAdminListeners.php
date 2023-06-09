<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use Mustache_Engine;
use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Core\Utils\SystemUtil;
use VitesseCms\Media\Enums\MediaEnum;
use VitesseCms\Mustache\Controllers\AdminlayoutController;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Listeners\Admin\AdminMenuListener;
use VitesseCms\Mustache\Listeners\Admin\AssetsListener;
use VitesseCms\Mustache\Listeners\Controllers\AdminlayoutControllerListener;
use VitesseCms\Mustache\Repositories\LayoutRepository;
use VitesseCms\Mustache\Services\RenderService;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $di): void
    {
        $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        $di->eventsManager->attach(AdminlayoutController::class, new AdminlayoutControllerListener());
        $di->eventsManager->attach(
            ViewEnum::VIEW_LISTENER,
            new ViewListener(
                $di->view,
                $di->configuration->getVendorNameDir(),
                $di->configuration->getTemplateDir(),
                $di->configuration->getCoreTemplateDir(),
                $di->configuration->getAccountTemplateDir(),
                new LayoutRepository(),
                new RenderService(
                    new Mustache_Engine(),
                    $di->configuration->getAccountTemplateDir(),
                    $di->configuration->getTemplateDir(),
                    $di->configuration->getCoreTemplateDir(),
                    $di->configuration->getLanguageShort()
                ),
                SystemUtil::getModules($di->configuration)
            )
        );
        $di->eventsManager->attach(
            MediaEnum::ASSETS_LISTENER,
            new AssetsListener($di->configuration->getVendorNameDir())
        );
    }
}
