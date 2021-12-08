<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Listeners;

use Phalcon\Events\Event;
use VitesseCms\Media\Services\AssetsService;

class AssetsListener
{
    /**
     * @var string
     */
    private $vendorBaseDir;

    /**
     * @var bool
     */
    private $isAdmin;

    public function __construct(string $vendorBaseDir, bool $isAdmin)
    {
        $this->vendorBaseDir = $vendorBaseDir;
        $this->isAdmin = $isAdmin;
    }

    public function load(Event $event, AssetsService $assetsService): void
    {
        if ($this->isAdmin) :
            $assetsService->addInlineJs(
                file_get_contents($this->vendorBaseDir . 'mustache/src/Resources/js/jquery.grideditor.js')
            );
            $assetsService->addInlineCss(
                file_get_contents($this->vendorBaseDir . 'mustache/src/Resources/css/grideditor.css')
            );
        endif;
    }
}