<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PkgAbsence\App\Models\Absence;

class Seance extends Model
{
    use HasFactory;

    protected $fillable = [
        'duree_seance_id',
        'date_debut',
        'date_fin',
    ];

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}