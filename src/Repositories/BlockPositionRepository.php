<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Repositories;

use VitesseCms\Block\Models\BlockPosition;
use VitesseCms\Block\Models\BlockPositionIterator;
use VitesseCms\Database\Models\FindOrder;
use VitesseCms\Database\Models\FindOrderIterator;
use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;

class BlockPositionRepository extends \VitesseCms\Block\Repositories\BlockPositionRepository
{
    public function findAllWithOneDatagroup(): BlockPositionIterator
    {
        $blockPositions = $this->findAll();
        $return = new BlockPositionIterator();
        while($blockPositions->valid()):
            $blockPosition = $blockPositions->current();
            $add = true;

            if(is_array($blockPosition->getDatagroup()) && count($blockPosition->getDatagroup()) > 1):
                $add = false;
            endif;
            if(is_array($blockPosition->getDatagroup()) && count($blockPosition->getDatagroup()) === 1&& $blockPosition->getDatagroup()[0] === 'all'):
                $add = false;
            endif;

            if(is_string($blockPosition->getDatagroup()) && $blockPosition->getDatagroup() === 'all') :
                $add = false;
            endif;

            if(is_string($blockPosition->getDatagroup()) && empty($blockPosition->getDatagroup())) :
                $add = false;
            endif;

            if ($add) :
                $return->add($blockPosition);
            endif;

            $blockPositions->next();
        endwhile;

        return $return;
    }
}
