<?php

namespace App\Models;

use App\Enums\PostPrivacy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = ['body', 'privacy', 'user_id',];

    protected function casts(): array
    {
        return [
            'privacy' => PostPrivacy::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function images()
    {
        return $this->hasMany(PostImage::class);
    }
}
