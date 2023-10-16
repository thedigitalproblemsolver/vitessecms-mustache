<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Models;

use VitesseCms\Database\AbstractCollection;
use ArrayIterator;

class LayoutIterator extends ArrayIterator
{
    public function __construct(array $layouts)
    {
        parent::__construct($layouts);
    }

    public function current(): Layout
    {
        return parent::current();
    }
}