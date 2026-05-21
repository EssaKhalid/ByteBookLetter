<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\Posts\PostForm;
use App\Models\Post;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Feed extends Component
{
    use WithPagination;

    public PostForm $form;


    #[On('post-created')]
    #[On('post-updated')]
    #[On('post-deleted')]
    #[On('comment-added')]
    public function refreshFeed()
    {
        // No code is needed inside here.
        // The simple act of this function running
        // forces Livewire to run the render() method again!
    }

    #[On('delete-post')]
    public function handleDeletePost($postId)
    {
        $post = Post::findOrFail($postId);
        $this->form->setPost($post);
        $this->form->destroy();
        $this->dispatch('post-deleted');
    }

    public function deletePost(Post $post)
    {
        $this->form->setPost($post);
        $this->form->destroy();
        $this->dispatch('post-deleted');
    }

    public function render()
    {
        $followingIds = auth()->user()->following()->pluck('user_id');

        $posts = Post::query()->where(function ($query) use ($followingIds) {

            $query->where(function ($q) {
                $q->where('user_id', auth()->id())
                    ->whereIn('privacy', ['public', 'friends']);
            })
                ->orWhere('privacy', 'public')
                ->orWhere(function ($subQuery) use ($followingIds) {
                    $subQuery->whereIn('user_id', $followingIds)
                        ->whereIn('privacy', ['public', 'friends']);
                });
        })
            ->with(['user', 'images'])
            ->withCount('comments', 'likes')
            ->latest()
            ->cursorPaginate(50);

        return view('livewire.posts.feed', ['posts' => $posts]);
    }
}
