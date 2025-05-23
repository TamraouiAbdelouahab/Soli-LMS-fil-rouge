<?php

namespace Modules\PkgJustificatif\App\Models;

enum StatutJustificatif: string
{
    case EN_ATTENTE = 'EN_ATTENTE';
    case ACCEPTE = 'ACCEPTE';
    case REJETE = 'REJETE';
}