<?php

namespace Modules\PkgAbsence\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PkgApprenant\App\Models\Apprenant;
use Modules\PkgSanction\App\Models\SanctionAbsence;
use Modules\PkgSanction\App\Models\SanctionAbsencePrevisionnelle;
use Modules\PkgSanction\App\Models\SanctionAbsence;
use Modules\PkgApprenant\App\Models\Apprenant;
use App\Models\JustificationAbsence;
use App\Models\Seance; 

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seance_id',
        'sanction_absence_id',
        'sanction_absence_previsionnelle_id',
        'date_absence',
    ];

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }
}
