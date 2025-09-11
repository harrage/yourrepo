<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return BelongsToMany<Source, User, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function sources(): BelongsToMany
    {
        return $this->belongsToMany(Source::class, 'user_sources')
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany<Category, User, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'user_categories')
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany<Author, User, \Illuminate\Database\Eloquent\Relations\Pivot>
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'user_authors')
            ->withTimestamps();
    }
}
