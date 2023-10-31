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
    public static function setListeners(InjectableInterface $di): void
    {
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
                    $di->configuration->getLanguageShort(),
                    $di->setting,
                    $di->configuration
                ),
                SystemUtil::getModules($di->configuration)
            )
        );

        if ($di->user->hasAdminAccess()):
            $di->eventsManager->attach('adminMenu', new AdminMenuListener());
        endif;
    }
}
