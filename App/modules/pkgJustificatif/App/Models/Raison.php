<?php

namespace Module\pkgJustificatif\App\Models;

use Illuminate\Database\Eloquent\Model;

class Raison extends Model
{
    protected $fillable = [
        'code',
        'libelle',  // Exemple : "Maladie", "Déplacement", etc.
        'description',
    ];

    // Une raison peut être associée à plusieurs justificatifs

}
