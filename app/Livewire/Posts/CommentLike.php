<?php

namespace App\Livewire\Posts;

use App\Models\Comment;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CommentLike extends Component
{
    public Comment $comment;

    public function mount(Comment $comment)
    {
        $this->comment = $comment->loadCount('likes');
    }

    #[Computed]
    public function isLiked()
    {
        if (!auth()->check())
            return false;

        return auth()->user()->commentLikes()
            ->where('comment_id', $this->comment->id)
            ->exists();
    }
    public function toggleLike()
    {
        if (!auth()->check()) return $this->redirectRoute('login');

        $like = auth()->user()->commentLikes()->where('comment_id', $this->comment->id);

        if ($like->exists()) {
            $like->delete();
        } else {
            auth()->user()->commentLikes()->create([
                'comment_id' => $this->comment->id,
            ]);
        }

        $this->comment->refresh()->loadCount('likes');
        unset($this->isLiked);
    }

    public function render()
    {
        return view('livewire.posts.comment-like');
    }
}
