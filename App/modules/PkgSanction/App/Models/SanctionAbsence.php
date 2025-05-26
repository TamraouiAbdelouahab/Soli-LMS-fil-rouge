<?php

namespace Modules\PkgSanction\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PkgAbsence\App\Models\Absence;

class SanctionAbsence extends Model
{
    use HasFactory;

    protected $fillable = [
        'regle_de_sanction_id',
        'date_debut',
        'date_fin',
    ];

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function regle()
    {
        return $this->belongsTo(ReglesDeSanction::class, 'regle_de_sanction_id');
    }
}
