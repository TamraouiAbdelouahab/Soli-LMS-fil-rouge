<?php

namespace Modules\PkgSanction\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReglesDeSanction extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'absences_max',
        'seuil_de_notification',
        'duree_sanction',
        'est_actif',
    ];

    public function sanctionsAbsences()
    {
        return $this->hasMany(SanctionAbsence::class);
    }

    public function sanctionsPrevisionnelles()
    {
        return $this->hasMany(SanctionAbsencePrevisionnelle::class);
    }
}
