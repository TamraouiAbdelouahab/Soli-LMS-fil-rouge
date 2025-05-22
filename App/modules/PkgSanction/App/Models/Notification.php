<?php

namespace Modules\PkgSanction\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\PkgApprenant\App\Models\Apprenant;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'sanction_absence_id',
        'user_id',
        'message',
    ];

    public function sanctionAbsence()
    {
        return $this->belongsTo(SanctionAbsence::class);
    }

    public function apprenant()
    {
        return $this->belongsTo(Apprenant::class);
    }
}
