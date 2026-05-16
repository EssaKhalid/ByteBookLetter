<?php

namespace App\Livewire\Posts;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Isolate;
use Livewire\Attributes\On;
use Livewire\Component;

#[Isolate]
class Comments extends Component
{
    public ?int $postId = null;

    public ?int $replyingTo = null;

    public string $newComment = '';

    public int $commentsCount = 0;

    #[On('open-comment-modal')]
    public function openModal(int|array $postId = 0): void
    {
        if (is_array($postId)) {
            $postId = (int) ($postId['postId'] ?? 0);
        }

        if (! $postId) {
            return;
        }

        $this->postId = $postId;
        $this->replyingTo = null;
        $this->newComment = '';
        $this->loadComments();
    }

    public function close(): void
    {
        $this->postId = null;
        $this->replyingTo = null;
        $this->newComment = '';
    }

    public function setReply(int $commentId): void
    {
        $this->replyingTo = $commentId;
    }

    public function cancelReply(): void
    {
        $this->replyingTo = null;
    }

    public function deleteComment(int $commentId): void
    {
        $comment = Comment::findOrFail($commentId);

        if ($comment->user_id !== auth()->id()) {
            return;
        }

        $comment->delete();
        $this->loadComments();
    }

    public function postComment(): void
    {
        if (! $this->postId) {
            return;
        }

        $this->validate(['newComment' => 'required|string|min:1|max:1255']);

        auth()->user()->comments()->create([
            'post_id' => $this->postId,
            'parent_id' => $this->replyingTo,
            'body' => trim($this->newComment),
        ]);

        $this->reset(['newComment', 'replyingTo']);
        $this->loadComments();
        $this->dispatch('comment-posted', postId: $this->postId);
    }

    protected function loadComments(): void
    {
        if (! $this->postId) {
            return;
        }

        $post = Post::query()
            ->withCount('comments')
            ->with([
                'comments' => fn ($query) => $query
                    ->whereNull('parent_id')
                    ->latest()
                    ->with(['user', 'replies' => fn ($q) => $q->latest()->with(['user', 'replies' => fn ($q2) => $q2->latest()->with('user')])]),
            ])
            ->find($this->postId);

        $this->commentsCount = $post?->comments_count ?? 0;
    }

    public function render()
    {
        $post = null;
        $replyingToUser = null;

        if ($this->postId) {
            $post = Post::query()
                ->withCount('comments')
                ->with([
                    'comments' => fn ($query) => $query
                        ->whereNull('parent_id')
                        ->latest()
                        ->with(['user', 'replies' => fn ($q) => $q->latest()->with(['user', 'replies' => fn ($q2) => $q2->latest()->with('user')])]),
                ])
                ->find($this->postId);

            $this->commentsCount = $post?->comments_count ?? 0;

            if ($this->replyingTo) {
                $parent = Comment::with('user')->find($this->replyingTo);
                $replyingToUser = $parent?->user;
            }
        }

        return view('livewire.posts.comments', [
            'post' => $post,
            'replyingToUser' => $replyingToUser,
        ]);
    }
}
