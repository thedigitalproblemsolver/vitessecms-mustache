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
     * @var BlockRepository
     */
    public $block;

    /**
     * @var DatafieldRepository
     */
    public $datafield;

    public function __construct(
        DatagroupRepository $datagroupRepository,
        BlockRepository $blockRepository,
        DatafieldRepository $datafieldRepository
    )
    {
        $this->datagroup = $datagroupRepository;
        $this->block = $blockRepository;
        $this->datafield = $datafieldRepository;
    }
}
