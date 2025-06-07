<?php

namespace Modules\PkgSanction\App\Enum;

enum SanctionType: string
{
    case MISE_EN_GARDE = 'Mise en garde';
    case AVERTISSEMENT = 'Avertissement';
    case BLAME = 'Blâme';
    case SUSPENSION = 'Suspension';
    case EXCLUSION = 'Exclusion';
}
