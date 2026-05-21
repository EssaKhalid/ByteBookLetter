<?php

namespace App\Models;

use App\Enums\PostPrivacy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    protected $fillable = ['body', 'privacy', 'user_id',];

    use HasFactory;

    protected function casts(): array
    {
        return [
            'privacy' => PostPrivacy::class,
        ];
    }

    public function postUrl(): string
    {
        return route('profile.show', $this->user->name) . '#post-' . $this->id;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class);
    }

}
