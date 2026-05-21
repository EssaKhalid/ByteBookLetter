<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    protected static ?string $password;

    public function definition(): array
    {
        $techBios = [
            "Full-stack engineer. Building scalable systems with Laravel and Vue.",
            "I write code, drink coffee, and complain about light theme users.",
            "SRE at a startup. I make sure servers don't crash on Friday afternoons.",
            "Frontend designer obsessed with animations, CSS variables, and clean UI.",
            "PHP enthusiast & open source contributor. Laravel is my playground.",
            "Typescript survivor. Currently learning Rust. Yes, I will tell you about it.",
            "Self-taught developer. I turn caffeine into working software systems.",
            "DevOps engineer. If it works on your machine, I will containerize it."
        ];

        // Curated pool of high-quality, male-presenting tech workspace/developer avatars
        $avatars = [
            "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&h=150", // Male developer in glasses
            "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=150&h=150", // Male tech engineer portrait
            "https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=150&h=150", // Male workspace/business casual
            "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=150&h=150", // Male software engineer profile
            "https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=150&h=150"  // Male creator portrait
        ];

        $banners = [
            "https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=800&h=300", // Aesthetic wave background
            "https://images.unsplash.com/photo-1579546929518-9e396f3cc809?auto=format&fit=crop&w=800&h=300", // Dark gradient mesh
            "https://images.unsplash.com/photo-1508739773434-c26b3d09e071?auto=format&fit=crop&w=800&h=300"  // Cyberpunk city background
        ];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'bio' => fake()->randomElement($techBios),
            'avatar' => fake()->randomElement($avatars),
            'banner' => fake()->randomElement($banners),
        ];
    }
}
