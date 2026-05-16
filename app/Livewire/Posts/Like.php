<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Isolate;
use Livewire\Component;

#[Isolate]
class Like extends Component
{
    public Post $post;

    public function mount(Post $post): void
    {
        $this->post = $post->loadCount('likes');
    }

    #[Computed]
    public function isLiked(): bool
    {
        if (! auth()->check()) {
            return false;
        }

        return auth()->user()->likes()
            ->where('post_id', $this->post->id)
            ->exists();
    }

    public function toggleLike(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'), navigate: true);

            return;
        }

        $like = auth()->user()->likes()->where('post_id', $this->post->id);

        if ($like->exists()) {
            $like->delete();
        } else {
            auth()->user()->likes()->create([
                'post_id' => $this->post->id,
            ]);
        }

        $this->post->loadCount('likes');
        unset($this->isLiked);
    }

    public function render()
    {
        return view('livewire.posts.like');
    }
}
