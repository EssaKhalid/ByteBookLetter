<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;

class Feed extends Component
{
    public function render()
    {
        $posts = Post::query()
            ->with(['user', 'images'])
            ->withCount(['comments', 'likes'])
            ->where('privacy', 'public')
            ->latest()
            ->get();

        return view('livewire.posts.feed', compact('posts'));
    }
}
