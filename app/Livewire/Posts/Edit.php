<?php

namespace App\Livewire\Posts;

use App\Livewire\Forms\Posts\PostForm;
use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public PostForm $form;
    public Post $post;
    #[Url(as: 'back')]
    public string $previousurl = '';


    public function mount(Post $post)
    {
        $this->post = $post->load('images');
        $this->form->setPost($this->post);
        $this->previousurl = url()->previous();
    }

    public function update()
    {
        $this->form->update();
        $this->dispatch('post-updated');
        session()->flash('success_EditedPost', 'Your post has been edited.');

        return $this->redirect($this->previousurl, navigate: true);
    }

    public function cyclePrivacy()
    {
        $this->form->cyclePrivacy();
    }

    public function render()
    {
        return view('livewire.posts.edit');
    }
}
