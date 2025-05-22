<?php

namespace modules\PkgEntretienInscrition\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    protected $fillable = ['name'];

    public function interviews(): BelongsToMany
    {
        return $this->BelongsToMany(Interview::class, "interviews_branches");
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
