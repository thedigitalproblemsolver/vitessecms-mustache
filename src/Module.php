<?php declare(strict_types=1);

namespace VitesseCms\Mustache;

use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Block\Repositories\BlockRepository;
use VitesseCms\Core\AbstractModule;
use Phalcon\Di\DiInterface;
use VitesseCms\Database\Enums\DatabaseEnum;
use VitesseCms\Datafield\Repositories\DatafieldRepository;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Repositories\AdminRepositoryCollection;

class Module extends AbstractModule
{
    public function registerServices(DiInterface $di, string $string = null)
    {
        parent::registerServices($di, ViewEnum::MODULE);
        if (AdminUtil::isAdminPage()) :
            $di->setShared(
                DatabaseEnum::REPOSITORIES,
                new AdminRepositoryCollection(
                    new DatagroupRepository(),
                    new DatafieldRepository(),
                    new BlockRepository()
                )
            );
        endif;
    }
}
