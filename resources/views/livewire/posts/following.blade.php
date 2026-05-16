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
</div>
