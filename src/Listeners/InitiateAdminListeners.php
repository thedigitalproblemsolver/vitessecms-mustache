<?php

declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use Mustache_Engine;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Core\Utils\SystemUtil;
use VitesseCms\Media\Enums\MediaEnum;
use VitesseCms\Mustache\Controllers\AdminlayoutController;
use VitesseCms\Mustache\Enum\LayoutEnum;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Listeners\Admin\AdminMenuListener;
use VitesseCms\Mustache\Listeners\Admin\AssetsListener;
use VitesseCms\Mustache\Listeners\Controllers\AdminlayoutControllerListener;
use VitesseCms\Mustache\Repositories\LayoutRepository;
use VitesseCms\Mustache\Services\RenderService;

class InitiateAdminListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $injectable): void
    {
        $injectable->eventsManager->attach('adminMenu', new AdminMenuListener());
        $injectable->eventsManager->attach(AdminlayoutController::class, new AdminlayoutControllerListener());
        $injectable->eventsManager->attach(
            ViewEnum::VIEW_LISTENER,
            new ViewListener(
                $injectable->view,
                $injectable->configuration->getVendorNameDir(),
                $injectable->configuration->getTemplateDir(),
                $injectable->configuration->getCoreTemplateDir(),
                $injectable->configuration->getAccountTemplateDir(),
                new LayoutRepository(),
                new RenderService(
                    new Mustache_Engine(),
                    $injectable->configuration->getAccountTemplateDir(),
                    $injectable->configuration->getTemplateDir(),
                    $injectable->configuration->getCoreTemplateDir(),
                    $injectable->configuration->getLanguageShort(),
                    $injectable->setting,
                    $injectable->configuration
                ),
                SystemUtil::getModules($injectable->configuration)
            )
        );
        $injectable->eventsManager->attach(
            MediaEnum::ASSETS_LISTENER,
            new AssetsListener($injectable->configuration->getVendorNameDir())
        );
        $injectable->eventsManager->attach(LayoutEnum::LISTENER->value, new LayoutListener(new LayoutRepository()));
    }
}
