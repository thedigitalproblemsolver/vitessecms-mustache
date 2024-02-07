<?php

declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use Mustache_Engine;
use VitesseCms\Core\Interfaces\InitiateListenersInterface;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Core\Utils\SystemUtil;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Listeners\Admin\AdminMenuListener;
use VitesseCms\Mustache\Repositories\LayoutRepository;
use VitesseCms\Mustache\Services\RenderService;

class InitiateListeners implements InitiateListenersInterface
{
    public static function setListeners(InjectableInterface $injectable): void
    {
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

        if ($injectable->user->hasAdminAccess()):
            $injectable->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
    }
}
