<?php

namespace App\Traits;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanBlog
{
    /**
     * Users have roles
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
    }
}
