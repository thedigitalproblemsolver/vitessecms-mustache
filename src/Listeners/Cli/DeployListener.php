<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners\Cli;

use Phalcon\Events\Event;
use VitesseCms\Cli\DTO\MappingDTO;
use VitesseCms\Cli\Models\Mapping;

class DeployListener
{
    public function JSMapping(Event $event, MappingDTO $mappingDTO): void
    {
        $mappingDTO->iterator->add(new Mapping(
            $mappingDTO->vendorDir.'vitessecms/mustache/src/Resources/js/jquery.grideditor.js',
            $mappingDTO->publicHtmlDir.'assets/default/js/jquery.grideditor.js'
        ));
    }

    public function CssMapping(Event $event, MappingDTO $mappingDTO): void
    {
        $mappingDTO->iterator->add(new Mapping(
            $mappingDTO->vendorDir.'vitessecms/mustache/src/Resources/css/grideditor.css',
            $mappingDTO->publicHtmlDir.'assets/default/css/grideditor.css'
        ));
    }
}
