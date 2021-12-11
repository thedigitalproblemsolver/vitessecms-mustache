<?php declare(strict_types=1);

namespace VitesseCms\Mustache;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Block\Repositories\BlockRepository;
use VitesseCms\Core\AbstractModule;
use Phalcon\DiInterface;
use VitesseCms\Datafield\Repositories\DatafieldRepository;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Mustache\Repositories\AdminRepositoryCollection;

class Module extends AbstractModule
{
    public function registerServices(DiInterface $di, string $string = null)
    {
        parent::registerServices($di, 'Mustache');
        if (AdminUtil::isAdminPage()) :
            $di->setShared('repositories', new AdminRepositoryCollection(
                new DatagroupRepository(),
                new BlockRepository(),
                new DatafieldRepository()
            ));
        endif;
    }
}
