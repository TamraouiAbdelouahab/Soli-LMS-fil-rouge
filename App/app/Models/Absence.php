<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PkgSanction\App\Models\SanctionAbsencePrevisionnelle;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'seance_id',
        'sanction_absence_id',
        'sanction_absence_previsionnelle_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class);
    }

    public function justification()
    {
        return $this->belongsTo(JustificationAbsence::class);
    }

    public function sanctionAbsence()
    {
        return $this->belongsTo(SanctionAbsence::class);
    }

    public function sanctionPrevisionnelle()
    {
        return $this->belongsTo(SanctionAbsencePrevisionnelle::class);
    }
}
