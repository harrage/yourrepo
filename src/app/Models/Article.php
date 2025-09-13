<?php

namespace App\Models;

use App\Filters\ArticleFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $category_id
 * @property int $source_id
 * @property string $author
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $url
 * @property string $url_image
 * @property \DateTime $published_at
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Article extends Model
{

    public function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime'
        ];
    }
    /**
     * @return BelongsTo<Author, Article>
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * @return BelongsTo<Category, Article>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return BelongsTo<Source, Article>
     */
    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function sourceUsers()
    {
        return $this->belongsToMany(User::class, 'user_sources', 'source_id', 'user_id');
    }

    public function categoryUsers()
    {
        return $this->belongsToMany(User::class, 'user_categories', 'category_id', 'user_id');
    }

    public function authorUsers()
    {
        return $this->belongsToMany(User::class, 'user_authors', 'author_id', 'user_id');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return ArticleFilter::apply($query, $filters);
    }
}
