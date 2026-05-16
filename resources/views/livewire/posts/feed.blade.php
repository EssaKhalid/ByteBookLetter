<div class="w-full space-y-6">
    <header class="mb-2">
        <h1 class="text-3xl font-black text-white italic uppercase tracking-tighter">Your <span class="text-indigo-500">Feed</span></h1>
        <p class="text-sm text-zinc-500 mt-1">Public posts from everyone</p>
    </header>

    @forelse($posts as $post)
        <x-post-card :post="$post" />
    @empty
        <div class="py-16 text-center bg-zinc-900/40 border border-white/10 rounded-[2.5rem] px-6">
            <p class="text-zinc-300 text-base">Nothing here yet.</p>
            <p class="text-zinc-500 text-sm mt-2">When people start posting, you'll see their stuff show up here.</p>
            <a href="{{ route('post.create') }}" wire:navigate class="mt-5 inline-block text-indigo-400 text-sm font-semibold hover:text-white transition-colors">
                Or share something yourself →
            </a>
        </div>
    @endforelse
</div>
