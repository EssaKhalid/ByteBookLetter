<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostImageFactory extends Factory
{
    protected $model = PostImage::class;

    public function definition(): array
    {
        $techImages = [
            "https://images.unsplash.com/photo-1555066931-4365d14bab8c", // Neon code on dark monitor
            "https://images.unsplash.com/photo-1542831371-29b0f74f9713", // Developer coding on split screen
            "https://images.unsplash.com/photo-1504639725590-34d0984388bd", // Minimal neon desk setup
            "https://images.unsplash.com/photo-1618384887929-16ec33fab9ef", // Sleek mechanical keyboard closeup
            "https://images.unsplash.com/photo-1585776245991-cf89dd7fc73a", // Minimalist clean office setup
            "https://images.unsplash.com/photo-1517694712202-14dd9538aa97", // Coding on a MacBook in a cafe
            "https://images.unsplash.com/photo-1607799279861-4dd421887fb3", // Bright IDE code layout
            "https://images.unsplash.com/photo-1531403009284-440f080d1e12", // UI/UX design wireframes on screen
            "https://images.unsplash.com/photo-1515879218367-8466d910aaa4", // Python code on dark background
            "https://images.unsplash.com/photo-1562813733-b31f71025d54", // Cybersecurity/terminal matrix layout
            "https://images.unsplash.com/photo-1498050108023-c5249f4df085", // Modern design workstation
            "https://images.unsplash.com/photo-1510519138101-570d1dca3d66"  // Futuristic server rack systems
        ];

        return [
            'post_id' => Post::factory(),
            'path' => fake()->randomElement($techImages),
        ];
    }
}
