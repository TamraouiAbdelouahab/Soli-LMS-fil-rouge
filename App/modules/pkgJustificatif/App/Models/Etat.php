<?php

namespace Module\PkgJustificatif\App\Enums;

enum StatutJustificatif: string
{
    case EN_ATTENTE = 'EN_ATTENTE';
    case ACCEPTE = 'ACCEPTE';
    case REJETE = 'REJETE';
}