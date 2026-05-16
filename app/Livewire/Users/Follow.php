<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Component;

class Follow extends Component
{
    #[Locked] // Security: Browser can't touch this
    public $targetId;

    public function mount($targetId)
    {
        $this->targetId = $targetId;
    }

    #[Computed] // Performance: Caches the DB query
    public function isFollowing()
    {
        if (!auth()->check()) {
            return false;
        }
        return auth()->user()->following()->where('user_id', $this->targetId)->exists();
    }

    public function toggleFollow()
    {
        if (!auth()->check()) return $this->redirect('login');

        if (auth()->id() === $this->targetId) return; // Logic: Don't follow self
        $userToFollow = User::findOrFail($this->targetId);
        auth()->user()->following()->toggle($userToFollow);
    }

    public function render()
    {
        return view('livewire.users.follow');
    }
}
