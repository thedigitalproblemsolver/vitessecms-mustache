<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Enum;

enum FrontendHtmlEnum: string
{
    case PARSE_HEADER_EVENT = 'FrontendHtml:parseHeader';
    case FRONTEND_HTML_LISTENER = 'FrontendHtml';
}
