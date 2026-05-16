<?php

namespace App\Livewire\Forms\Posts;

use App\Enums\PostPrivacy;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Isolate;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PostForm extends Form
{

    public ?Post $post;

    #[Validate('required_without:images|max:1255')]
    public $body = '';

    #[Validate([

        'images' => 'nullable|array|max:100',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ])]
    public $images = [];

    #[Validate(['required', new Enum(PostPrivacy::class)])]
    public string $privacy = 'public';

    public function messages()
    {
        return [
            // Rule: property.rule_name => 'Your Custom Message'
            'body.required_without' => 'Please write something or upload a photo to share your post!',
            'body.max' => 'Wow, that is a long story! Please keep it under 1,255 characters.',
            'images.*.image' => 'One of your files is not a valid image.',
        ];
    }

    public function removeImage($index)
    {
        $this->images = collect($this->images)
            ->forget($index)
            ->values()
            ->all();
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
        $this->body = $post->body;
        $this->privacy = $post->privacy->value;
    }

    #[Isolate]
    public function update()
    {
        Gate::authorize('update', $this->post);

        $this->validate();

        DB::transaction(function () {
            $this->post->update([
                'body' => $this->body,
                'privacy' => $this->privacy,
            ]);
            if ($this->images) {
                foreach ($this->images as $image) {
                    $path = $image->store('posts', 'public');
                    $this->post->images()->create(['path' => $path]);
                }
            }
        });
        $this->reset('images');
    }

    #[Isolate]
    public function save()
    {
        Gate::authorize('create', Post::class);

        $this->validate();

        DB::transaction(function () {
           $newPost = auth()->user()->posts()->create([
                'body' => $this->body,
                'privacy' => $this->privacy,
            ]);

            if ($this->images) {
                foreach ($this->images as $image) {
                    $path = $image->store('posts', 'public');
                    $newPost->images()->create(['path' => $path]);
                }
            }
        });

        $this->reset(['body', 'images',]);

    }
}
