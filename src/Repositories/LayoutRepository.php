<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Repositories;

use VitesseCms\Database\Models\FindValue;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Mustache\Models\Layout;
use VitesseCms\Mustache\Models\LayoutIterator;

class LayoutRepository
{
    public function getById(string $id, bool $hideUnpublished = true): ?Layout
    {
        Layout::setFindPublished($hideUnpublished);

        /** @var Layout $layout */
        $layout = Layout::findById($id);
        if (is_object($layout)):
            return $layout;
        endif;

        return null;
    }

    public function findAll(
        ?FindValueIterator $findValues = null,
        bool $hideUnpublished = true
    ): LayoutIterator
    {
        Layout::setFindPublished($hideUnpublished);
        Layout::addFindOrder('name');
        $this->parsefindValues($findValues);

        return new LayoutIterator(Layout::findAll());
    }

    public function findByDatagroup(
        string $datagroupId,
        ?FindValueIterator $findValues = null,
        bool $hideUnpublished = true
    ): LayoutIterator
    {
        if ($findValues === null) :
            $findValues = new FindValueIterator([]);
        endif;
        $findValues->append(new FindValue('datagroup',$datagroupId));

        return $this->findAll($findValues, $hideUnpublished);
    }

    protected function parsefindValues(?FindValueIterator $findValues = null): void
    {
        if ($findValues !== null) :
            while ($findValues->valid()) :
                $findValue = $findValues->current();
                Layout::setFindValue(
                    $findValue->getKey(),
                    $findValue->getValue(),
                    $findValue->getType()
                );
                $findValues->next();
            endwhile;
        endif;
    }
}