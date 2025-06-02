<?php

namespace Modules\PkgSanction\App\Enum;

enum SanctionType: string
{
    case AVERTISSEMENT = 'avertissement';
    case BLAME = 'blame';
    case SUSPENSION = 'suspension';
    case EXCLUSION = 'exclusion';
}
