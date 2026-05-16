<div x-data="{ magneticX: 0, magneticY: 0 }">
    <button
        wire:click="toggleFollow"
        @mousemove="
            let rect = $el.getBoundingClientRect();
            magneticX = ($event.clientX - rect.left - rect.width/2) * 0.3;
            magneticY = ($event.clientY - rect.top - rect.height/2) * 0.3;
        "
        @mouseleave="magneticX = 0; magneticY = 0"
        :style="`transform: translate(${magneticX}px, ${magneticY}px)`"
        class="relative px-8 py-2.5 rounded-full font-black text-[10px] uppercase tracking-[0.2em] transition-all duration-200 shadow-lg active:scale-95
        {{ $this->isFollowing ? 'bg-zinc-800 text-zinc-400 border border-white/5' : 'bg-white text-zinc-950 hover:shadow-[0_0_30px_rgba(255,255,255,0.2)]' }}">

        <span wire:loading.remove>
            {{ $this->isFollowing ? 'Following' : 'Follow Identity' }}
        </span>

        <span wire:loading class="flex items-center space-x-2">
            <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            <span>Syncing...</span>
        </span>
    </button>
</div>
