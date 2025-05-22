<?php

namespace Modules\PkgSanction\App\Models;

use App\Models\Absence;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
