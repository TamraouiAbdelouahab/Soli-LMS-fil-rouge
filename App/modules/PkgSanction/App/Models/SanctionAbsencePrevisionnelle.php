<?php

namespace Modules\PkgSanction\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PkgAbsence\App\Models\Absence;

class SanctionAbsencePrevisionnelle extends Model
{
    use HasFactory;

    protected $table = 'sanction_absences_previsionnelles';

    protected $fillable = [
        'regle_de_sanction_id',
    ];

    public function regle()
    {
        return $this->belongsTo(ReglesDeSanction::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }
}
