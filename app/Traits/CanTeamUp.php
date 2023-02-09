<?php

namespace App\Traits;

use App\Models\Blog;
use App\Models\Team;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanTeamUp
{
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

}
