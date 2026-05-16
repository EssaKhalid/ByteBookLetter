<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\Posts\PostForm;
use Livewire\Component;
use Livewire\WithFileUploads;


class Create extends Component
{
    public Postform $form;
    use WithFileUploads;

    public function save()
    {
        $this->form->save();
        $this->dispatch('post-created');
        session()->flash('success_CreatedPost', 'Your post has been shared with the world!');
        return $this->redirectRoute('feed', navigate: true);
    }

    public function removeImage($index)
    {
        $this->form->removeImage($index);
    }

    public function render()
    {
        return view('livewire.posts.create');
    }
}
