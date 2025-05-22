<?php

namespace Modules\PkgApprenant\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\App\Models\User;

class Apprenant extends User
{
    protected $fillable = [
        'nom',
        'prenom',
        'prenom_arab',
        'nom_arab',
        'tele_num',
        'profile_image',
        'date_inscription',
        'cin',
        'adresse',
    ];

    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'apprenant_groupe');
    }
    
}
