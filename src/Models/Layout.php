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
        if($this->html === null) :
            return '';
        endif;

        $search = [
            'class="ge-content ge-content-type-summernote"',
            'data-ge-content-type="summernote"',
            '<p>{',
            '}<br></p>',
            '}<br>',
            '<div  >',
            ' style=""'
        ];
        $replace = [
            '',
            '',
            '{',
            '}',
            '}',
            '<div>',
            ''
        ];

        return str_replace($search, $replace, $this->html);
    }

    public function getDatagroup(): ?string
    {
        return $this->datagroup;
    }
}

