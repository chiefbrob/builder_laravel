<?php

namespace App\Traits;

use App\Models\Blog;
use App\Models\Team;
use App\Models\TeamUser;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanTeamUp
{
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function teamUsers(): HasMany
    {
        return $this->hasMany(TeamUser::class);
    }

}
