<?php declare(strict_types=1);

namespace VitesseCms\Mustache;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Mustache\Repositories\BlockPositionRepository;
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
                new BlockPositionRepository(),
                new DatafieldRepository()
            ));
        endif;
    }
}
