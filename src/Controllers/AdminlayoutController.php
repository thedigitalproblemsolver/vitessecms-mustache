<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Controllers;

use VitesseCms\Admin\Interfaces\AdminModelAddableInterface;
use VitesseCms\Admin\Interfaces\AdminModelCopyableInterface;
use VitesseCms\Admin\Interfaces\AdminModelDeletableInterface;
use VitesseCms\Admin\Interfaces\AdminModelEditableInterface;
use VitesseCms\Admin\Interfaces\AdminModelFormInterface;
use VitesseCms\Admin\Interfaces\AdminModelListInterface;
use VitesseCms\Admin\Interfaces\AdminModelPublishableInterface;
use VitesseCms\Admin\Traits\TraitAdminModelAddable;
use VitesseCms\Admin\Traits\TraitAdminModelCopyable;
use VitesseCms\Admin\Traits\TraitAdminModelDeletable;
use VitesseCms\Admin\Traits\TraitAdminModelEditable;
use VitesseCms\Admin\Traits\TraitAdminModelList;
use VitesseCms\Admin\Traits\TraitAdminModelPublishable;
use VitesseCms\Admin\Traits\TraitAdminModelSave;
use VitesseCms\Block\Enum\BlockEnum;
use VitesseCms\Block\Repositories\BlockRepository;
use VitesseCms\Core\AbstractControllerAdmin;
use VitesseCms\Database\AbstractCollection;
use VitesseCms\Database\Models\FindOrder;
use VitesseCms\Database\Models\FindOrderIterator;
use VitesseCms\Database\Models\FindValueIterator;
use VitesseCms\Datafield\Enum\DatafieldEnum;
use VitesseCms\Datafield\Repositories\DatafieldRepository;
use VitesseCms\Datagroup\Enums\DatagroupEnum;
use VitesseCms\Datagroup\Repositories\DatagroupRepository;
use VitesseCms\Mustache\Enum\LayoutEnum;
use VitesseCms\Mustache\Enum\ViewEnum;
use VitesseCms\Mustache\Forms\LayoutForm;
use VitesseCms\Mustache\Models\Layout;
use VitesseCms\Mustache\Repositories\LayoutRepository;

class AdminlayoutController extends AbstractControllerAdmin implements
    AdminModelListInterface,
    AdminModelPublishableInterface,
    AdminModelEditableInterface,
    AdminModelCopyableInterface,
    AdminModelDeletableInterface,
    AdminModelAddableInterface
{
    use TraitAdminModelList,
        TraitAdminModelPublishable,
        TraitAdminModelEditable,
        TraitAdminModelSave,
        TraitAdminModelCopyable,
        TraitAdminModelDeletable,
        TraitAdminModelAddable;

    private LayoutRepository $layoutRepository;
    private DatagroupRepository $datagroupRepository;
    private DatafieldRepository $datafieldRepository;
    private BlockRepository $blockRepository;

    public function OnConstruct()
    {
        parent::OnConstruct();

        $this->layoutRepository = $this->eventsManager->fire(LayoutEnum::GET_REPOSITORY->value,new \stdClass());
        $this->datagroupRepository = $this->eventsManager->fire(DatagroupEnum::GET_REPOSITORY->value, new \stdClass());
        $this->datafieldRepository = $this->eventsManager->fire(DatafieldEnum::GET_REPOSITORY->value, new \stdClass());
        $this->blockRepository = $this->eventsManager->fire(BlockEnum::LISTENER_GET_REPOSITORY->value, new \stdClass());
    }

    public function getModel(string $id): ?AbstractCollection
    {
        return match ($id) {
            'new' => new Layout(),
            default => $this->getExistingModel($id)
        };
    }

    private function getExistingModel(string $id): Layout
    {
        $model = $this->layoutRepository->getById($id, false);

        if($model->getDatagroup() !== null):
            $datagroup = $this->datagroupRepository->getById($model->getDatagroup());
            $availableFields = [];
            foreach( $datagroup->getDatafields() as $datafield) :
                $availableFields[] = $this->datafieldRepository->getById($datafield['id']);
            endforeach;
            $this->addFormParams('availableFields', $availableFields);
        endif;

        $this->addFormParams('model', $model);
        $this->addFormParams('availableBlocks', $this->blockRepository->findAll());

        return $model;
    }

    public function getModelList( ?FindValueIterator $findValueIterator): \ArrayIterator
    {
        return $this->layoutRepository->findAll(
            $findValueIterator,
            false,
            99999,
            new FindOrderIterator([new FindOrder('createdAt', -1)])
        );
    }

    public function getModelForm(): AdminModelFormInterface
    {
        $this->assets->setEventLoader(ViewEnum::ASSETS_LOAD_GRID_EDITOR);

        return new LayoutForm();
    }

    protected function getTemplate(): string
    {
        return 'editForm';
    }

    protected function getTemplatePath(): string
    {
        return 'mustache/src/Resources/admin/views/';
    }
}