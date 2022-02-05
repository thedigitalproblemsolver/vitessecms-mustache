<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Repositories;

use VitesseCms\Block\Repositories\BlockRepository;
use VitesseCms\Database\Interfaces\BaseRepositoriesInterface;
use VitesseCms\Datafield\Repositories\DatafieldRepository;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;

class AdminRepositoryCollection implements BaseRepositoriesInterface
{
    /**
     * @var DatagroupRepository
     */
    public $datagroup;

    /**
     * @var DatafieldRepository
     */
    public $datafield;

    /**
     * @var BlockRepository
     */
    public $block;

    public function __construct(
        DatagroupRepository $datagroupRepository,
        DatafieldRepository $datafieldRepository,
        BlockRepository $blockRepository
    )
    {
        $this->datagroup = $datagroupRepository;
        $this->datafield = $datafieldRepository;
        $this->block = $blockRepository;
    }
}
