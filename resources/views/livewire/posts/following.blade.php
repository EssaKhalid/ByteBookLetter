<div class="w-full space-y-6">
    <header class="mb-2">
        <h1 class="text-3xl font-black text-white italic uppercase tracking-tighter">People you <span class="text-indigo-500">follow</span></h1>
        <p class="text-sm text-zinc-500 mt-1">Posts from accounts you follow</p>
    </header>

    @forelse($posts as $post)
        <x-post-card :post="$post" />
    @empty
        <div class="py-16 text-center bg-zinc-900/40 border border-white/10 rounded-[2.5rem] px-6">
            @if(! $followsAnyone)
                <p class="text-zinc-300 text-base">You're not following anyone yet.</p>
                <p class="text-zinc-500 text-sm mt-2">Browse profiles and follow people whose posts you want to see here.</p>
            @else
                <p class="text-zinc-300 text-base">Nothing new from people you follow.</p>
                <p class="text-zinc-500 text-sm mt-2">When they post, it'll show up on this page.</p>
            @endif
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
