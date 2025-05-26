<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\PkgAbsence\App\Models\Absence;

class JustificationAbsence extends Model
{
    protected $fillable = [
        'absence_id',
        'type',
        'description',
        'date_justified',
        'justification_file',
    ];
    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
