<?php

namespace Modules\PkgSanction\App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
