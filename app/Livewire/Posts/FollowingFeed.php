<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class FollowingFeed extends Component
{


    use WithPagination;

    public function render()
    {
        $followingIds = auth()->user()->following()->pluck('users.id');

        $posts = collect();

        if ($followingIds->isNotEmpty()) {
            $posts = Post::query()
                ->with(['user', 'images'])
                ->withCount(['comments', 'likes'])
                ->whereIn('user_id', $followingIds)
                ->whereIn('privacy', ['public', 'friends'])
                ->latest()
                ->cursorPaginate(50);
        }

        return view('livewire.posts.following', [
            'posts' => $posts,
            'followsAnyone' => $followingIds->isNotEmpty(),
        ]);
    }
}
