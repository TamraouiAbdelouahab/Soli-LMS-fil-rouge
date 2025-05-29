<?php

namespace Modules\PkgAbsence\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PkgSanction\App\Models\SanctionAbsencePrevisionnelle;
use Modules\PkgSanction\App\Models\SanctionAbsence;
use Modules\PkgApprenant\App\Models\Apprenant;
use App\Models\Seance;
use Modules\Core\App\Models\User;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // 👤 surveillant qui saisit l’absence
        'apprenant_id', // 👨‍🎓 apprenant concerné par l’absence
        'seance_id',
        'justifie',
        'sanction_absence_id',
        'sanction_absence_previsionnelle_id',
    ];

    protected $casts = [
        'justifie' => 'boolean',
    ];

    // 👤 Utilisateur (surveillant) qui saisit l’absence
    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 👨‍🎓 Apprenant concerné par l’absence
    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class, 'apprenant_id');
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class, 'seance_id');
    }

    public function sanctionAbsence()
    {
        return $this->belongsTo(SanctionAbsence::class, 'sanction_absence_id');
    }

    public function sanctionPrevisionnelle()
    {
        return $this->belongsTo(SanctionAbsencePrevisionnelle::class, 'sanction_absence_previsionnelle_id');
    }
}
