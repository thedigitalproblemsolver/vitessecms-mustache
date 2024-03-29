<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Enum;

use VitesseCms\Core\AbstractEnum;

class ViewEnum extends AbstractEnum
{
    public const RENDER_TEMPLATE_EVENT = 'view:renderTemplate';
    public const RENDER_PARTIAL_EVENT = 'view:renderPartial';
    public const VIEW_LISTENER = 'view';
    public const RENDER_LAYOUT_EVENT = 'view:renderLayout';
    public const ASSETS_LOAD_GRID_EDITOR = 'assets:loadGridEditor';
    public const ASSETS_LOAD_LAZY_LOADING = 'assets:loadLazyLoading';
    public const ASSETS_LOAD_FONT_AWESOME = 'assets:loadFontAwesome';
    public const MODULE = 'Mustache';
}
