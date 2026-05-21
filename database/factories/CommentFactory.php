<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $techComments = [
            "Which font and color theme is that in the setup?",
            "Classic. This is why I have absolute trust issues with my compiler.",
            "Have you tried turning it off and on again? Always works for me.",
            "Honestly, this post saved my afternoon. Thanks for sharing the insight!",
            "Wait, you guys are actually writing tests for your code?",
            "I feel personally attacked by this post.",
            "Can we get a link to the GitHub repository? This looks incredible.",
            "This is clean! Mind if I use a similar architecture in my startup?",
            "Ah, the legendary junior developer mistake. We have all been there.",
            "Does this scale well under a high-traffic load?",
            "PHP in 2026 is actually beautiful. People hating on it are stuck in 2012.",
            "That code looks extremely elegant. Nice refactoring job!"
        ];

        return [
            'post_id' => Post::factory(),
            'user_id' => User::factory(),
            'body' => fake()->randomElement($techComments),
            'parent_id' => null,
        ];
    }
}
