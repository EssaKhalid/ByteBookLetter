<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;

class CreatePost extends Component
{
    #[Validate]
    public $body = '';

    public function save()
    {
        auth()->user->posts()->create([
            'body' => $this->body,
        ]);

        $this->reset('body');

        session()->flash('message', 'Post successfully created.');
    }
    public function render()
    {
        return view('livewire.create-post');
    }
}
