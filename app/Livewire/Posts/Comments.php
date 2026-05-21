<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use App\Models\Comment;
use Livewire\Attributes\Session;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Isolate;

#[Isolate]
class Comments extends Component
{
    #[Url (as: 'thread')]
    public ?int $postId = null;
    public ?int $replyingTo = null;
    public string $newComment = '';

    #[On('open-comment-modal')]
    public function openModal($postId)
    {
        $this->postId = $postId;
        $this->reset(['newComment', 'replyingTo']);
    }

    public function postComment()
    {
        $this->validate(
            ['newComment' => 'required|max:1255'],
            ['newComment.required' => 'Type something before sending!']
        );

        auth()->user()->comments()->create([
            'post_id' => $this->postId,
            'parent_id' => $this->replyingTo,
            'body' => trim($this->newComment),
        ]);

        $this->reset(['newComment', 'replyingTo']);
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->user_id === auth()->id()) {
            $comment->delete();
        }
    }

    public function setReply($commentId)
    {
        $this->replyingTo = $commentId;
    }

    public function cancelReply()
    {
        $this->replyingTo = null;
    }

    public function close()
    {
        $this->reset();
    }

    public function render()
    {
        $post = null;
        $comments = [];
        $commentsCount = 0;
        $replyingToUser = null;

        if ($this->postId) {
            $post = Post::withCount('comments')->find($this->postId);
            $commentsCount = $post?->comments_count ?? 0;

            $comments = Comment::query()
                ->where('post_id', $this->postId)
                ->whereNull('parent_id') // Get main comments
                ->withCount('likes')
                ->with([
                    'user',
                    // Level 1: Go inside the replies
                    'replies' => function ($q) {
                        $q->withCount('likes') // Count likes for the first replies
                        ->with('user')
                            ->with([
                                // Level 2: Go inside the replies of the replies!
                                'replies' => function ($q2) {
                                    $q2->withCount('likes')->with('user');
                                }
                            ]);
                    }
                ])
                ->latest()
                ->cursorPaginate(50);

            if ($this->replyingTo) {
                $replyingComment = Comment::with('user')->find($this->replyingTo);
                $replyingToUser = $replyingComment?->user;
            }
        }

        return view('livewire.posts.comments', [
            'comments' => $comments,
            'post' => $post,
            'commentsCount' => $commentsCount,
            'replyingToUser' => $replyingToUser,
        ]);
    }
}
