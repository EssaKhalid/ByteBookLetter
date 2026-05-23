<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class FollowingFeed extends Component
{
    use WithPagination;

    public int $perPage = 10;

    public function loadMore()
    {
        usleep(3500000);
        $this->perPage += 10;
    }

    public function render()
    {
        $followingIds = auth()->user()->following()->pluck('users.id');

        if ($followingIds->isEmpty()) {
            $posts = Post::query()->whereRaw('1 = 0')->cursorPaginate($this->perPage);
        } else {
            $posts = Post::query()
                ->with(['user', 'images'])
                ->withCount(['comments', 'likes'])
                ->whereIn('user_id', $followingIds)
                ->whereIn('privacy', ['public', 'friends'])
                ->latest()
                ->cursorPaginate($this->perPage);
        }

        return view('livewire.posts.following', [
            'posts' => $posts,
            'followsAnyone' => $followingIds->isNotEmpty(),
        ]);
    }
}
