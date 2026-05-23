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

    @if($posts->hasMorePages())
        <div x-intersect:enter="$wire.loadMore()"
             wire:loading.remove
             wire:target="loadMore"
             class="h-12 w-full"></div>
        <div wire:loading
             wire:target="loadMore"
             class="w-full py-8">
            <div class="mx-auto flex items-center justify-center gap-3">
                <svg class="animate-spin w-7 h-7 text-indigo-400 drop-shadow-[0_0_10px_rgba(99,102,241,0.5)]" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-90" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <span class="text-[10px] font-black text-indigo-400/80 uppercase tracking-widest animate-pulse">Loading more…</span>
            </div>
        </div>
    @endif
</div>
