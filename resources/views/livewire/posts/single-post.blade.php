<div class="bg-zinc-900/40 border border-white/10 rounded-[2.5rem] p-6 backdrop-blur-xl mb-8 hover:border-white/20 transition-all duration-500 group mx-auto w-full max-w-2xl">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('profile.show', $post->user) }}" class="w-12 h-12 rounded-2xl overflow-hidden border border-white/5 bg-zinc-800 flex items-center justify-center">
                @if($post->user->avatar)
                    <img src="{{ Storage::url($post->user->avatar) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-indigo-400 font-bold italic">{{ substr($post->user->name, 0, 1) }}</span>
                @endif
            </a>
            <div class="flex flex-col">
                <a href="{{ route('profile.show', $post->user) }}" class="text-zinc-100 font-black tracking-tighter text-base hover:text-indigo-400 transition-colors uppercase italic">
                    {{ $post->user->name }}
                </a>
                <span class="text-[10px] text-zinc-600 font-black uppercase tracking-widest">{{ $post->created_at->diffForHumans() }}</span>
            </div>
        </div>

        @if(auth()->id() === $post->user_id)
            <button @click="$dispatch('open-edit-modal', { postId: {{ $post->id }} })" class="p-2.5 rounded-xl bg-zinc-800/50 text-zinc-500 hover:text-white transition-all opacity-0 group-hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </button>
        @endif
    </div>

    <!-- BODY -->
    <p class="text-lg text-zinc-200 leading-relaxed tracking-tight px-2 mb-6">{{ $post->body }}</p>

    <!-- MEDIA GRID (Gallery Wired) -->
    @if($post->images->count())
        @php $imgUrls = $post->images->map(fn($i) => Storage::url($i->path))->toArray(); @endphp
        <div class="grid {{ $post->images->count() == 1 ? 'grid-cols-1' : 'grid-cols-2' }} gap-2 rounded-3xl overflow-hidden border border-white/5 shadow-2xl">
            @foreach($post->images->take(4) as $index => $img)
                <div class="relative aspect-square cursor-zoom-in group/img overflow-hidden"
                     @click="$dispatch('open-gallery', { images: {{ json_encode($imgUrls) }}, index: {{ $index }} })">
                    <img src="{{ Storage::url($img->path) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover/img:scale-110">

                    @if($loop->index == 3 && $post->images->count() > 4)
                        <div class="absolute inset-0 bg-zinc-950/60 backdrop-blur-sm flex items-center justify-center">
                            <span class="text-white text-2xl font-black italic tracking-tighter">+{{ $post->images->count() - 4 }} Bytes</span>
                        </div>
                    @else
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover/img:opacity-100 transition-opacity"></div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    <!-- ACTIONS: BIGGER BUTTONS -->
    <div class="mt-8 pt-6 border-t border-white/5 flex items-center justify-between gap-4 px-2">
        <div class="flex-1">
            <livewire:posts.like :post="$post" :key="'like-'.$post->id" />
        </div>

        <button @click="$dispatch('open-comment-modal', { postId: {{ $post->id }} })"
                class="flex-1 flex items-center justify-center space-x-3 py-3 rounded-2xl bg-zinc-800/30 hover:bg-zinc-800/80 border border-white/5 text-zinc-500 hover:text-white transition-all group shadow-sm">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            <span class="text-xs font-black uppercase tracking-widest">{{ $post->comments()->count() }} Threads</span>
        </button>
    </div>
</div>
