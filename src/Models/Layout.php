<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Models;

use VitesseCms\Database\AbstractCollection;

class Layout extends AbstractCollection
{
    /**
     * @var string
     */
    public $html;

    public function getHtml(): string
    {
        return $this->html;
    }
}

