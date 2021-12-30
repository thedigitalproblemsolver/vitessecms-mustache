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
    public $blockposition;

    public function getHtml(): string
    {
        return (string)$this->html;
    }

    public function getDatagroup(): ?string
    {
        return $this->datagroup;
    }

    public function getBlockPosition(): ?string
    {
        return $this->blockposition;
    }
}

