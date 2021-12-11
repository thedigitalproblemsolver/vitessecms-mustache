<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Models;

use VitesseCms\Database\AbstractCollection;

class Layout extends AbstractCollection
{
    /**
     * @var string
     */
    public $html;

    /**
     * @var string
     */
    public $datagroup;

    /**
     * @var string
     */
    public $block;

    public function getHtml(): string
    {
        return (string)$this->html;
    }

    public function getDatagroup(): ?string
    {
        return $this->datagroup;
    }

    public function getBlock(): ?string
    {
        return $this->block;
    }
}

