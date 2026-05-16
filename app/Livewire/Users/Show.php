<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts::wide')]
class Show extends Component
{
    public User $user;

    public $followersList;

    public $followingList;

    public function mount(User $user)
    {
        $this->user = $user->loadCount(['posts', 'followers', 'following']);
        $this->followersList = $this->user->followers()->latest()->get();
        $this->followingList = $this->user->following()->latest()->get();
    }

    public function render()
    {
        $query = $this->user->posts()->with(['user', 'images'])->withCount(['comments', 'likes'])->latest();

        $allowedPrivacy = ['public'];
        if (auth()->check()) {
            $isOwner = auth()->id() === $this->user->id;
            $iFollowThem = auth()->user()->following()->where('user_id', $this->user->id)->exists();

            if ($isOwner) {
                $allowedPrivacy = ['public', 'friends', 'private'];
            } elseif ($iFollowThem) {
                $allowedPrivacy = ['public', 'friends'];
            }
        }

        $posts = $query->whereIn('privacy', $allowedPrivacy)->get();

        return view('livewire.users.show', [
            'posts' => $posts,
        ]);
    }
}
