<?php

namespace Module\pkgJustificatif\App\Models;

use Illuminate\Database\Eloquent\Model;

class Justificatif extends Model
{
    protected $fillable = [
        'titre',
        'date_depot',
        'date_debut',
        'date_fin',
        'fichier',
        'descrition',
        'raison_id',
        'statut'
    ];
}
