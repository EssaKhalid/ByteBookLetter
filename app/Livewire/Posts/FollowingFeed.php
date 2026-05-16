<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Component;

class FollowingFeed extends Component
{
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
                ->get();
        }

        return view('livewire.posts.following', [
            'posts' => $posts,
            'followsAnyone' => $followingIds->isNotEmpty(),
        ]);
    }
}
