<?php

namespace App\Livewire;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class GlobalSearch extends Component
{
    public string $query = '';

    public function clear(): void
    {
        $this->reset('query');
    }

    #[Computed]
    public function users()
    {
        if (Str::length($this->query) < 2) {
            return collect();
        }
        return User::query()
            ->where('name', 'like', '%' . $this->query . '%')
            ->orWhere('bio', 'like', '%' . $this->query . '%')
            ->take(10)
            ->get();

    }


    #[Computed]
    public function posts()
    {
        if (Str::length($this->query) < 2) {
            return collect();
        }
        return Post::query()
            ->where('body', 'like', '%' . $this->query . '%')
            ->whereIn('privacy', ['public', 'friends'])
            ->with('user')
            ->take(10)
            ->get();
    }

    public function render()
    {
        return view('livewire.global-search');

    }
}


