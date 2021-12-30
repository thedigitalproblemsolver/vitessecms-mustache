<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Forms;

use VitesseCms\Mustache\Interfaces\RepositoryInterface;
use VitesseCms\Datagroup\Models\Datagroup;
use VitesseCms\Form\AbstractFormWithRepository;
use VitesseCms\Form\Helpers\ElementHelper;
use VitesseCms\Form\Interfaces\FormWithRepositoryInterface;
use VitesseCms\Form\Models\Attributes;
use VitesseCms\Mustache\Models\Layout;
use VitesseCms\Mustache\Repositories\AdminRepositoryInterface;

class LayoutForm extends AbstractFormWithRepository
{
    /**
     * @var AdminRepositoryInterface
     */
    protected $repositories;

    /**
     * @var Layout
     */
    protected $_entity;

    public function buildForm(): FormWithRepositoryInterface
    {
        $this->addText(
            '%CORE_NAME%',
            'name',
            (new Attributes())->setRequired()->setMultilang()
        )
            ->addDropdown('%MUSTACHE_DATAGROUP%','datagroup',(new Attributes())->setRequired()->setOptions(
                ElementHelper::modelIteratorToOptions($this->repositories->datagroup->findAll())
            ))
            ->addHidden('html')
            ->addHtml('<div id="layout_editor">'.($this->_entity?$this->_entity->getHtml():'').'</div>')
            ->addSubmitButton('Opslaan', (new Attributes())->setElementId('layout_editor_button_save'))
        ;

        return $this;
    }
}