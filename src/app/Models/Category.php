<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Category extends Model
{
    /**
     * @return array{created_at: string, updated_at: string}
     */
    public function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<Article, Category>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
