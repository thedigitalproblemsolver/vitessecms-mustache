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

    public function getHtml(): string
    {
        return (string)$this->html;
    }

    public function getDatagroup(): ?string
    {
        return $this->datagroup;
    }
}

