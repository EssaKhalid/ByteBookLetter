<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id', 'parent_id', 'body', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function parent()
    {
        // Logic: Find the ONE row where the "id" matches MY "parent_id"
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies()
    {
        // Logic: Find all rows where the "parent_id" matches MY "id"
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }
}
