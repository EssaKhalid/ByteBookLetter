<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $techPosts = [
            "Writing tests feels slow at first, but sleeping peacefully through production releases makes it 100% worth it.",
            "Can we all agree that naming variables is officially the hardest part of software engineering?",
            "Me: *writes clean, self-documenting code*\nMe 2 weeks later: Who wrote this garbage and why are they still employed?",
            "Refactoring is just editing your past self's code while feeling deeply embarrassed.",
            "My computer has 64GB of RAM, and yet Google Chrome and Slack still find a way to eat 95% of it.",
            "The best feeling is deleting 200 lines of messy code and replacing it with a single, elegant native PHP helper.",
            "I love software development. It's the only job where you can say 'it works on my machine' and consider your task finished.",
            "Is there any greater feeling than clicking a green merge button on a massive pull request?",
            "AI assistants are great, but you still need to know how to ask the right questions. Bad input = bad output.",
            "There are 10 types of people in the world: those who understand binary, and those who don't.",
            "A SQL query walks into a bar, walks up to two tables and asks, 'Can I join you?'",
            "I have a joke about stack overflow, but it's a duplicate of another joke.",
            "Local environment: Works perfectly.\nStaging environment: Works perfectly.\nProduction: *Explodes into a thousand tiny pieces*",
            "Nothing makes me question my life choices quite like a merge conflict in a file I didn't even edit.",
            "If at first you don't succeed, call it version 1.0 and add it to your portfolio.",
            "We don't need more JavaScript frameworks. What we need is a framework to stop people from building more frameworks.",
            "My favorite programming language is whatever language gets the task done in the fewest lines of code.",
            "Documentation is like a love letter to your future self. Write it with affection.",
            "That moment when you solve a bug by deleting the code you spent all of yesterday writing.",
            "Every database query is fast until you run it against a table with 10 million rows. Index your foreign keys, friends!",
            "I spent 4 hours automating a task that takes me 5 seconds to do manually. Absolute peak engineering efficiency.",
            "There is nothing more permanent than a 'temporary' hotfix in a production environment.",
            "The code works, the tests pass, and the client is happy. Something is definitely wrong.",
            "Hardware is the part of a computer you can kick; software is the part you can only curse at.",
            "I'm not lazy. I'm just highly motivated to find the most efficient way to do absolutely nothing."
        ];

        return [
            'user_id' => User::factory(),
            'body' => fake()->randomElement($techPosts),
            'privacy' => fake()->randomElement(['public', 'friends']),
        ];
    }
}
