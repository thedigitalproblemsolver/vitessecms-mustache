<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners\Admin;

use Phalcon\Events\Event;
use VitesseCms\Core\AbstractController;
use VitesseCms\Core\AbstractEventController;
use VitesseCms\Media\Services\AssetsService;
use Yaf\Exception\LoadFailed\Action;

class AssetsListener
{
    /**
     * @var string
     */
    private $vendorBaseDir;

    public function __construct(string $vendorBaseDir)
    {
        $this->vendorBaseDir = $vendorBaseDir;
    }

    public function loadGridEditor(Event $event, AssetsService $assetsService): void
    {
        $assetsService->loadJqueryUI();
        $assetsService->loadSummerNote();
        $assetsService->addInlineJs(file_get_contents($this->vendorBaseDir . 'mustache/src/Resources/js/jquery.grideditor.js'));
        $assetsService->addInlineJs(file_get_contents($this->vendorBaseDir . 'mustache/src/Resources/js/jquery.grideditor.summernote.js'));
        $assetsService->addInlineJs(file_get_contents($this->vendorBaseDir . 'mustache/src/Resources/js/initGridUI.js'));
        $assetsService->addInlineCss(file_get_contents($this->vendorBaseDir . 'mustache/src/Resources/css/grideditor.css'));
    }
}