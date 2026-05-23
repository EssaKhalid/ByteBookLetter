<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Livewire\Forms\Posts\PostForm;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts::wide')]
class Show extends Component
{
    public User $user;

    public PostForm $form;

    use withPagination;

    public int $postsPerPage = 10;
    public int $followersPage = 1;
    public int $followingPage = 1;

    #[Url(as: 'view')]
    public string $tab = 'posts';

    public function mount(User $user)
    {
        $this->user = $user->loadCount(['posts', 'followers', 'following']);

    }

    public function loadMorePosts()
    {
        usleep(3500000);
        $this->postsPerPage += 10;
    }

    public function nextFollowersPage()
    {
        $this->followersPage++;
    }

    public function prevFollowersPage()
    {
        $this->followersPage = max(1, $this->followersPage - 1);
    }

    public function nextFollowingPage()
    {
        $this->followingPage++;
    }

    public function prevFollowingPage()
    {
        $this->followingPage = max(1, $this->followingPage - 1);
    }

    #[\Livewire\Attributes\On('delete-post')]
    public function handleDeletePost($postId)
    {
        $post = Post::findOrFail($postId);
        $this->form->setPost($post);
        $this->form->destroy();
        $this->dispatch('post-deleted');
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

        $followersList = $this->user->followers()->latest()->simplePaginate(50, ['*'], 'followers-page', $this->followersPage);
        $followingList = $this->user->following()->latest()->simplePaginate(50, ['*'], 'followings-page', $this->followingPage);

        $posts = $query->whereIn('privacy', $allowedPrivacy)->cursorPaginate($this->postsPerPage);

        return view('livewire.users.show', [
            'posts' => $posts,
            'followingList' => $followingList,
            'followersList' => $followersList,
        ]);
    }
}
