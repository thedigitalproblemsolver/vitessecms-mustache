<?php declare(strict_types=1);

namespace VitesseCms\Mustache\Enum;

enum LayoutEnum: string
{
    case LISTENER = 'LayoutListener';
    case GET_REPOSITORY = 'LayoutListener:getRepository';
}