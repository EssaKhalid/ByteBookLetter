@props(['post'])
@php
    $imageUrls = $post->images->map(fn ($image) => $image->url())->values()->all();
    $privacyIcon = match($post->privacy->value) {
        'public' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        'friends' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>',
        'private' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>',
    };
    $privacyLabel = $post->privacy->label();
@endphp
<div class="w-full mb-6" x-data="{ visible: false }" x-init="setTimeout(() => visible = true, 50)"
     x-show="visible"
     x-transition:enter="transition ease-out duration-500"
     x-transition:enter-start="opacity-0 translate-y-4 scale-[0.98]"
     x-transition:enter-end="opacity-100 translate-y-0 scale-100">
    <div class="bg-zinc-900/40 backdrop-blur-xl border border-white/10 rounded-[2.5rem] overflow-hidden shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)] transition-all hover:border-white/20">

        <div class="p-6 flex items-center justify-between gap-4">
            <a href="{{ route('profile.show', $post->user->name) }}" wire:navigate class="flex items-center space-x-4 group min-w-0">
                <img src="{{ $post->user->avatarUrl() }}" alt="{{ $post->user->name }}"
                     class="w-12 h-12 rounded-2xl object-cover border border-white/10 group-hover:scale-105 transition-transform shrink-0">
                <div class="min-w-0">
                    <h4 class="text-white font-black italic tracking-tighter uppercase truncate group-hover:text-indigo-400 transition-colors">{{ $post->user->name }}</h4>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-[0.2em]">{{ $post->created_at->diffForHumans() }}</span>
                        <span class="text-zinc-700">·</span>
                        <span class="flex items-center gap-1 text-[9px] font-bold uppercase tracking-wider {{ $post->privacy->value === 'public' ? 'text-emerald-500/60' : ($post->privacy->value === 'friends' ? 'text-amber-500/60' : 'text-rose-500/60') }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $privacyIcon !!}</svg>
                            {{ $privacyLabel }}
                        </span>
                    </div>
                </div>
            </a>

            @if(auth()->id() === $post->user_id)
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ route('post.edit', $post) }}" wire:navigate
                       title="Edit post"
                       class="p-2.5 bg-white/5 hover:bg-white/10 rounded-xl text-zinc-500 hover:text-white transition-all active:scale-90">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </a>
                    <button type="button"
                            x-on:click="if(confirm('Delete this post?')) Livewire.dispatch('delete-post', { postId: {{ $post->id }} })"
                            title="Delete post"
                            class="p-2.5 bg-white/5 hover:bg-rose-500/20 rounded-xl text-zinc-500 hover:text-rose-400 transition-all active:scale-90">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        <div class="px-6 sm:px-8 pb-6">
            <p class="text-zinc-200 text-lg leading-relaxed font-medium whitespace-pre-wrap">{{ $post->body }}</p>
        </div>

        @if($post->images->isNotEmpty())
            <div class="px-6 pb-6">
                <div class="grid gap-2 {{ $post->images->count() === 1 ? 'grid-cols-1' : 'grid-cols-2' }} rounded-[2rem] overflow-hidden">
                    @foreach($post->images->take(4) as $index => $image)
                        <div class="relative group cursor-zoom-in overflow-hidden {{ $post->images->count() === 1 ? 'max-h-[520px]' : 'aspect-square' }}"
                             @click="$dispatch('open-gallery', { images: {{ \Illuminate\Support\Js::from($imageUrls) }}, index: {{ $index }} })">
                            <img src="{{ $image->url() }}"
                                 alt=""
                                 class="w-full h-full object-cover hover:scale-[1.02] transition-transform duration-500 pointer-events-none">

                            @if($loop->iteration === 4 && $post->images->count() > 4)
                                <div class="absolute inset-0 bg-zinc-950/60 backdrop-blur-sm flex items-center justify-center pointer-events-none">
                                    <span class="text-2xl font-black text-white">+{{ $post->images->count() - 4 }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="px-6 py-4 bg-zinc-950/40 border-t border-white/5 flex items-center justify-between gap-4">
            <livewire:posts.like :post="$post" :wire:key="'like-'.$post->id" />

            <button type="button"
                    x-on:click="Livewire.dispatch('open-comment-modal', { postId: {{ $post->id }} })"
                    class="flex items-center space-x-2 px-5 py-3 bg-zinc-800/20 hover:bg-zinc-800/40 border border-white/5 rounded-2xl transition-all active:scale-95 group">
                <svg class="w-4 h-4 text-zinc-500 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-zinc-500 group-hover:text-white">
                    {{ $post->comments_count ?? 0 }} Thread{{ ($post->comments_count ?? 0) === 1 ? '' : 's' }}
                </span>
            </button>
        </div>
    </div>
</div>
