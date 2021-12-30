<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Repositories;

use VitesseCms\Block\Repositories\BlockPositionRepository;
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
     * @var BlockPositionRepository
     */
    public $blockposition;

    /**
     * @var DatafieldRepository
     */
    public $datafield;

    public function __construct(
        DatagroupRepository $datagroupRepository,
        BlockPositionRepository $blockRepository,
        DatafieldRepository $datafieldRepository
    )
    {
        $this->datagroup = $datagroupRepository;
        $this->blockposition = $blockRepository;
        $this->datafield = $datafieldRepository;
    }
}
