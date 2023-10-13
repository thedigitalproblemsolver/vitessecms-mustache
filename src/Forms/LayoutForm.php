<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Forms;

use VitesseCms\Admin\Interfaces\AdminModelFormInterface;
use VitesseCms\Form\AbstractForm;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Models\Attributes;

class LayoutForm extends AbstractForm implements AdminModelFormInterface
{
    public function buildForm(): void
    {
        $this->addText('%CORE_NAME%', 'name', (new Attributes())->setRequired()->setMultilang())
            ->addDropdown('%MUSTACHE_DATAGROUP%','datagroup',(new Attributes())->setRequired()->setOptions(
                ElementHelper::modelIteratorToOptions($this->repositories->datagroup->findAll())
            ))
            ->addHidden('html')
            ->addHtml('<div id="layout_editor">'.($this->entity?$this->entity->getHtml():'').'</div>')
            ->addSubmitButton('Opslaan', (new Attributes())->setElementId('layout_editor_button_save'))
        ;
    }
}