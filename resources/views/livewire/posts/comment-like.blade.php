<div>
    <button type="button" wire:click.stop="toggleLike"
            class="group flex items-center space-x-1.5 px-2 py-1 rounded-lg transition-all duration-200 active:scale-95 {{ $this->isLiked ? 'text-rose-400' : 'text-zinc-600 hover:text-zinc-400' }}">

        <svg class="w-3 h-3 transition-all duration-300 {{ $this->isLiked ? 'fill-rose-400 drop-shadow-[0_0_6px_rgba(251,113,133,0.4)]' : 'stroke-current' }}"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
        </svg>

        <span class="text-[9px] font-bold uppercase tracking-wider {{ $this->isLiked ? 'text-rose-400' : 'text-zinc-600 group-hover:text-zinc-400' }}">
            {{ $this->comment->likes_count ?? 0 }}
        </span>
    </button>
</div>
