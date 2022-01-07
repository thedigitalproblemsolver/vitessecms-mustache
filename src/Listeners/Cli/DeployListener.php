<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners\Cli;

use Phalcon\Events\Event;
use VitesseCms\Cli\DTO\MappingDTOInterface;
use VitesseCms\Cli\Models\Mapping;
use VitesseCms\Cli\Models\MappingIterator;

class DeployListener
{
    public function JSMapping(Event $event, MappingDTOInterface $mappingDTO): MappingIterator
    {
        $JSMapping = $mappingDTO->getIterator();
        $JSMapping->add(new Mapping(
            $mappingDTO->getVendorDir().'vitessecms/mustache/src/Resources/js/jquery.grideditor.js',
            $mappingDTO->getPublicHtmlDir().'assets/default/js/jquery.grideditor.js'
        ));

        return $JSMapping;
    }

    public function CssMapping(Event $event, MappingDTOInterface $mappingDTO): MappingIterator
    {
        $CssMapping = $mappingDTO->getIterator();
        $CssMapping->add(new Mapping(
            $mappingDTO->getVendorDir().'vitessecms/mustache/src/Resources/css/grideditor.css',
            $mappingDTO->getPublicHtmlDir().'assets/default/css/grideditor.css'
        ));

        return $CssMapping;
    }
}
