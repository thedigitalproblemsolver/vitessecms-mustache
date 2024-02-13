<?php

declare(strict_types=1);

namespace VitesseCms\Mustache;

use Phalcon\Di\DiInterface;
use VitesseCms\Admin\Utils\AdminUtil;
use VitesseCms\Block\Models\Block;
use VitesseCms\Block\Repositories\BlockRepository;
use VitesseCms\Core\AbstractModule;
use VitesseCms\Datafield\Repositories\DatafieldRepository;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Repositories\AdminRepositoryCollection;

class Module extends AbstractModule
{
    public function registerServices(DiInterface $di, string $module = null)
    {
        parent::registerServices($di, ViewEnum::MODULE);
        if (AdminUtil::isAdminPage()) {
            $di->setShared(
                'repositories',
                new AdminRepositoryCollection(
                    new DatagroupRepository(),
                    new DatafieldRepository(),
                    new BlockRepository(Block::class)
                )
            );
        }
    }
}
