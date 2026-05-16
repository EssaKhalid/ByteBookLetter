{{--<div x-data="{ liked: @entangle('isLiked') }" class="flex items-center space-x-2">--}}
{{--    <button--}}
{{--        wire:click="toggleLike"--}}
{{--        @click="liked = !liked"--}}
{{--        class="group relative flex items-center justify-center transition-all duration-500 active:scale-75"--}}
{{--    >--}}
{{--        <!-- The Electric Logo Icon -->--}}
{{--        <div :class="liked ? 'bg-indigo-500 shadow-[0_0_20px_rgba(99,102,241,0.8)] border-indigo-400 scale-110' : 'bg-zinc-800 border-white/5'"--}}
{{--             class="w-8 h-8 rounded-lg border flex items-center justify-center transition-all duration-500">--}}

{{--            <svg :class="liked ? 'text-white fill-current' : 'text-zinc-500'"--}}
{{--                 class="w-5 h-5 transition-colors duration-500"--}}
{{--                 fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>--}}
{{--            </svg>--}}
{{--        </div>--}}

{{--        <!-- Particles Effect (Alpine) -->--}}
{{--        <template x-if="liked">--}}
{{--            <div class="absolute inset-0 pointer-events-none">--}}
{{--                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-1 h-4 bg-indigo-400 rounded-full animate-ping"></div>--}}
{{--            </div>--}}
{{--        </template>--}}
{{--    </button>--}}
{{--    <span :class="liked ? 'text-indigo-400' : 'text-zinc-500'" class="text-[10px] font-black uppercase tracking-widest transition-colors duration-500">--}}
{{--        {{ $post->likes()->count() }} Bytes--}}
{{--    </span>--}}
{{--</div>--}}
<div>
    <button type="button" wire:click.stop="toggleLike"
            class="group flex items-center space-x-3 px-5 py-3 rounded-2xl transition-all duration-300 active:scale-95 border {{ $this->isLiked ? 'bg-indigo-500/10 border-indigo-500/30' : 'bg-zinc-800/20 border-white/5 hover:bg-zinc-800/40' }}">

        <svg class="w-4 h-4 transition-all duration-500 {{ $this->isLiked ? 'fill-indigo-500 text-indigo-500 drop-shadow-[0_0_10px_rgba(99,102,241,0.5)]' : 'text-zinc-500 group-hover:text-white' }}"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
        </svg>

        <span class="text-[9px] font-black uppercase tracking-[0.2em] {{ $this->isLiked ? 'text-white' : 'text-zinc-500 group-hover:text-white' }}">
            {{ $post->likes_count }} <span class="hidden sm:inline ml-1">Bytes</span>
        </span>
    </button>
</div>

