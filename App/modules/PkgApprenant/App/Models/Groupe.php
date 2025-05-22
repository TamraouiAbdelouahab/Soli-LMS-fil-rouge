<?php

namespace Modules\PkgApprenant\App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    protected $fillable = ['nom', 'description'];

    public function apprenants()
    {
        return $this->belongsToMany(Apprenant::class, 'apprenant_groupe');
    }

}
