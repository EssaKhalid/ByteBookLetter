<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Like;
use App\Models\Post;
use App\Models\PostImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Create your main test account (Alex)
        $me = User::create([
            'name' => 'Alex',
            'email' => 'alex@bytebook.com',
            'password' => 'password',
            'bio' => 'Full-stack developer. Building ByteBookLetter with Laravel and Livewire.',
        ]);

        // 2. Create "plex" (Lin Kuei / Sub-Zero blue ice aesthetic)
        $plex = User::create([
            'name' => 'plex',
            'email' => 'plex@bytebook.com',
            'password' => 'passaziz',
            'bio' => 'Grandmaster of the Lin Kuei. Frozen code blocks only. ❄️',
            'avatar' => 'https://images.unsplash.com/photo-1509198397868-475647b2a1e5?auto=format&fit=crop&w=150&h=150', // Deep cold blue graphic setup
            'banner' => 'https://images.unsplash.com/photo-1518156677180-95a2893f3e9f?auto=format&fit=crop&w=800&h=300', // Frosty neon abstract
        ]);

        // 3. Create "SyntaxFlow" (Shirai Ryu / Scorpion fire aesthetic)
        $syntaxFlow = User::create([
            'name' => 'SyntaxFlow',
            'email' => 'syntaxflow@bytebook.com',
            'password' => 'passessa',
            'bio' => 'Get over here! Igniting the web with clean Laravel syntax. 🔥',
            'avatar' => 'https://images.unsplash.com/photo-1541701494587-cb58502866ab?auto=format&fit=crop&w=150&h=150', // Vibrant neon yellow-orange graphic setup
            'banner' => 'https://images.unsplash.com/photo-1550684848-fac1c5b4e853?auto=format&fit=crop&w=800&h=300', // Dark glowing orange abstract
        ]);

        // 4. Create 30 random users
        $others = User::factory(30)->create();

        // Merge everyone into the global user pool
        $allUsers = collect([$me, $plex, $syntaxFlow])->merge($others);

        // 5. Establish mutual follow relationships
        foreach ($allUsers as $user) {
            $usersToFollow = $allUsers
                ->where('id', '!=', $user->id)
                ->random(random_int(5, 12));

            $user->following()->attach($usersToFollow);
        }

        // 6. Define Curated "Aligned" Scenarios (Post + Matching Image + Matching Comments)
        $scenarios = [
            [
                'body' => "Just spent 3 hours debugging a typo. Yes, it was a semicolon. No, I am not okay.",
                'image' => "https://images.unsplash.com/photo-1542831371-29b0f74f9713", // Neon code on dark monitor
                'comments' => [
                    "Classic. This is why I have trust issues with my compiler.",
                    "Have you tried turning your monitor off and on again?",
                    "IDE auto-formatters should be mandatory by law.",
                    "Wait, you actually compiled your code before pushing? Bold move.",
                    "I feel personally attacked by this post."
                ]
            ],
            [
                'body' => "Livewire 4 is seriously changing the game. Writing SPA-like interfaces in pure PHP feels like cheating.",
                'image' => "https://images.unsplash.com/photo-1555066931-4365d14bab8c", // Sleek modern desk and monitor
                'comments' => [
                    "Totally agree! Version 4 is blazing fast.",
                    "No more writing custom API endpoints just to handle a basic search dropdown!",
                    "Does the wire:navigate feature play nice with your custom JS scripts?",
                    "Honestly, I haven't written a line of React since switching to Livewire."
                ]
            ],
            [
                'body' => "Hot take: Dark mode isn't just a preference, it's a developer's survival tool. Light themes hurt my soul.",
                'image' => "https://images.unsplash.com/photo-1504639725590-34d0984388bd", // Dark tech setup with neon accents
                'comments' => [
                    "People who use light mode in pitch-black rooms belong in jail.",
                    "My eyes started watering just reading the phrase 'light theme'.",
                    "I use light theme at noon and dark theme at night. Am I a psychopath?",
                    "Dark theme saves battery and my retinas."
                ]
            ],
            [
                'body' => "Finally finished building my custom mechanical keyboard. Gateron brown switches, custom keycaps. The sound is pure ASMR.",
                'image' => "https://images.unsplash.com/photo-1618384887929-16ec33fab9ef", // Mechanical keyboard closeup
                'comments' => [
                    "That looks incredible. Are those tactile switches or linear?",
                    "RIP to your wallet. Mechanical keyboard building is a dangerous hobby.",
                    "We need an audio file of those typing sounds immediately!",
                    "Drop the link to the keycaps! Those colors are perfect."
                ]
            ],
            [
                'body' => "Deploying to production on a Friday afternoon because I too like to live dangerously. Wish me luck. 🚀",
                'image' => "https://images.unsplash.com/photo-1597852074816-d933c4d2b988", // Code deploy screen
                'comments' => [
                    "You are a brave soul. I am praying for your weekend.",
                    "Friday deploys are strictly banned in my engineering team.",
                    "Please tell me you have a database backup ready...",
                    "Rule #1 of engineering: Never deploy on a Friday!"
                ]
            ],
            [
                'body' => "Cleaned up my home office setup. Cable management took forever, but the minimalist result is worth every second.",
                'image' => "https://images.unsplash.com/photo-1585776245991-cf89dd7fc73a", // Aesthetic clean desk setup
                'comments' => [
                    "Show us the cables under the desk! That is the true test of cable management.",
                    "Minimalist setups are great until you actually need to plug in a second monitor.",
                    "What dual monitor stand are you using? Looks super sturdy.",
                    "This workspace setup is pure peace."
                ]
            ],
            [
                'body' => "Currently digging through a legacy codebase written 6 years ago. It feels less like coding and more like archaeology.",
                'image' => "https://images.unsplash.com/photo-1517694712202-14dd9538aa97", // Laptop with blurred code
                'comments' => [
                    "Did you find any comments explaining why they did what they did?",
                    "Sometimes you find bad architecture decisions, sometimes you find pure magic.",
                    "My favorite legacy comment is: 'I do not know why this works, do not touch it.'",
                    "Good luck. Don't pull too hard on any single thread or the whole house of cards collapses."
                ]
            ],
        ];

        // 7. Run the Scenario Seeding Engine (Matching Posts, Images, Comments, and Likes)
        foreach ($scenarios as $data) {
            // Pick a random author for this post
            $author = $allUsers->random();

            // Create the post
            $post = Post::create([
                'user_id' => $author->id,
                'body' => $data['body'],
                'privacy' => 'public',
            ]);

            // Create the matching image
            PostImage::create([
                'post_id' => $post->id,
                'path' => $data['image'],
            ]);

            // Add the context-aware comments
            foreach ($data['comments'] as $commentText) {
                // Commenter must not be the author of the post
                $commenter = $allUsers->where('id', '!=', $author->id)->random();

                $comment = Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $commenter->id,
                    'body' => $commentText,
                    'parent_id' => null,
                ]);

                // Seed some random Likes on this Comment
                $likers = $allUsers->random(random_int(1, 10));
                foreach ($likers as $liker) {
                    CommentLike::create([
                        'comment_id' => $comment->id,
                        'user_id' => $liker->id,
                    ]);
                }
            }

            // Seed some random Likes on the Post itself
            $postLikers = $allUsers->random(random_int(5, 20));
            foreach ($postLikers as $liker) {
                Like::create([
                    'post_id' => $post->id,
                    'user_id' => $liker->id,
                ]);
            }
        }

        // 8. Fill up extra generic posts WITH likes and comments distributed to make them look active
        foreach ($others as $user) {
            // Generate 1 or 2 posts for this user
            $userPosts = Post::factory()
                ->count(random_int(1, 2))
                ->create(['user_id' => $user->id]);

            foreach ($userPosts as $post) {
                // A. Add a random amount of Likes (between 2 and 15) to every single factory post
                $likers = $allUsers->random(random_int(2, 15));
                foreach ($likers as $liker) {
                    Like::create([
                        'post_id' => $post->id,
                        'user_id' => $liker->id,
                    ]);
                }

                // B. 75% chance that this post also receives between 1 and 3 comments
                if (random_int(1, 100) <= 75) {
                    $commenters = $allUsers->where('id', '!=', $user->id)->random(random_int(1, 3));
                    foreach ($commenters as $commenter) {
                        $comment = Comment::factory()->create([
                            'post_id' => $post->id,
                            'user_id' => $commenter->id,
                        ]);

                        // Seed 1 to 5 likes on these generic comments too!
                        $commentLikers = $allUsers->random(random_int(1, 5));
                        foreach ($commentLikers as $cliker) {
                            CommentLike::create([
                                'comment_id' => $comment->id,
                                'user_id' => $cliker->id,
                            ]);
                        }
                    }
                }
            }
        }
    }
}
