<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Source extends Model
{
    /**
     * @return HasMany<Article, Source>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
