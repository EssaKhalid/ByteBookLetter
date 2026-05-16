<?php

namespace App\Livewire\Users;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Isolate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts::wide')]
class Edit extends Component
{
    use WithFileUploads;

    #[Validate('nullable|image|mimes:jpeg,png,jpg,gif,svg|max:16767')]
    public $newAvatar;
    #[Validate('nullable|image|mimes:jpeg,png,jpg,gif,svg|max:16767')]
    public $newBanner;
    #[Validate('nullable|string|max:1255')]
    public $newBio;


    public function mount()
    {
        $this->newBio = auth()->user()->bio;
    }

    #[Isolate]
    public function update()
    {
        $user = auth()->user();
        $this->validate();
        /**
         * THE BACK-END BRIDGE (PHP Closure Logic)
         *
         * 1. function () -> This creates a "Bubble" (Closure). Code inside cannot see
         *    the outside world by default.
         *
         * 2. use ($user) -> This is the "Bridge." It pulls the $user variable from
         *    the component's neighborhood into the bubble so the logic can use it.
         *
         * 3. Why? -> We wrap the code in this "Bubble" so Laravel's DB engine can
         *    hold it and only "Execute" it when the database connection is secure.
         */
        DB::transaction(function () use ($user) {
            if ($this->newAvatar) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $avatarPath = $this->newAvatar->store('avatars', 'public');
                $user->avatar = $avatarPath;
            }

            if ($this->newBanner) {
                if ($user->banner) {
                    Storage::disk('public')->delete($user->banner);
                }
                $bannerPath = $this->newBanner->store('banners', 'public');
                $user->banner = $bannerPath;
            }

            $user->bio = $this->newBio;

            $user->save();
        });

        $this->reset(['newAvatar', 'newBanner']);
        session()->flash('success', 'Profile identity updated!');
        return $this->redirectRoute('profile.show', $user, navigate: true);
    }

    public function render()
    {
        return view('livewire.users.edit');
    }
}
