<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use VitesseCms\Cli\ConsoleApplication;
use VitesseCms\Core\Interfaces\InjectableInterface;
use VitesseCms\Mustache\Listeners\Cli\DeployListener;

class CliListeners
{
    public static function setListeners(ConsoleApplication $di): void
    {
        $di->eventsManager->attach('Deploy', new DeployListener());
    }
}