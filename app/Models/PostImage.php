<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostImage extends Model
{
    protected $fillable = ['post_id', 'path'];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function url(): string
    {
        if (Str::startsWith($this->path, ['http://', 'https://', '/'])) {
            return $this->path;
        }

        return Storage::disk('public')->url($this->path);
    }
}
