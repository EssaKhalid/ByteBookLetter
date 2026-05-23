<?php

namespace App\Livewire\Forms\Posts;

use App\Enums\PostPrivacy;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Isolate;
use Livewire\Attributes\On;
use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Form;

#[Isolate]
class PostForm extends Form
{

    public ?Post $post;

    #[Validate('required_without:images|max:1255')]
    #[Session]
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

    public function cyclePrivacy()
    {
        $next = match($this->privacy) {
            'public' => 'friends',
            'friends' => 'private',
            'private' => 'public',
            default => 'public',
        };

        $this->privacy = $next;
    }

    public function cyclePrivacyOnPost(Post $post)
    {
        Gate::authorize('update', $post);

        $current = $post->privacy;

        $next = match($current) {
            PostPrivacy::PUBLIC => PostPrivacy::FRIENDS,
            PostPrivacy::FRIENDS => PostPrivacy::PRIVATE,
            PostPrivacy::PRIVATE => PostPrivacy::PUBLIC,
        };

        $post->update(['privacy' => $next]);
    }

    public function removeImage($index)
    {
        $this->images = collect($this->images) // converts it to a laravel array
            ->forget($index) // 1. Remove the image at the selected position
            ->values()       // 2. Reset the list numbers so there are no gaps (e.g., 0, 2 becomes 0, 1)
            ->all();         // 3. Convert it back to a standard PHP array
    }

    public function deleteExistingImage($imageId)
    {
        $image = PostImage::findOrFail($imageId);
        Gate::authorize('delete', $image->post);
        Storage::disk('public')->delete($image->path);
        $image->delete();
    }

    public function setPost(Post $post)
    {
        $this->post = $post;
        $this->body = $post->body;
        $this->privacy = $post->privacy->value;
    }

    public function destroy()
    {
        Gate::authorize('delete', $this->post);

        foreach ($this->post->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $this->post->delete();
    }

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
