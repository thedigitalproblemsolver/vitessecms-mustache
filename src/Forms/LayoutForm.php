<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Forms;

use VitesseCms\Form\AbstractForm;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Mustache\Models\Layout;

class LayoutForm extends AbstractForm
{
    public function initialize(Layout $item = null): void
    {
        $this->addText(
            '%CORE_NAME%',
            'name',
            (new Attributes())->setRequired()->setMultilang()
        )
            ->addHidden('html')
            ->addHtml('<div id="layout_editor">'.($item?$item->getHtml():'').'</div>')
            ->addSubmitButton('Opslaan', (new Attributes())->setElementId('layout_editor_button_save'))
        ;
    }
}