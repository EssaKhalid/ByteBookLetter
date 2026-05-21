<div class="relative" x-data="{ focused: false, tab: 'users', query: '' }"
     x-init="$watch('$wire.query', value => { query = value; if(value.length >= 2) focused = true; else focused = false; })"
     @click.away="focused = false">
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <input type="text"
               placeholder="Search users or posts..."
               wire:model.live.debounce.300ms="query"
               @focus="focused = true"
               class="w-48 sm:w-56 bg-white/[0.03] border border-white/5 rounded-xl pl-9 pr-8 py-2 text-xs text-white placeholder-zinc-600 outline-none focus:ring-1 focus:ring-indigo-500/50 focus:border-indigo-500/30 transition-all"
        >
        <button x-show="query.length >= 2" wire:click="clear" @click="focused = false; $wire.clear()"
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-600 hover:text-white transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <div x-show="focused && query.length >= 2" x-cloak
         class="absolute top-full right-0 mt-2 w-80 sm:w-96 bg-zinc-900/95 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl overflow-hidden z-50"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">

        <!-- Tabs -->
        <div class="flex border-b border-white/5">
            <button @click="tab = 'users'"
                    :class="tab === 'users' ? 'text-white border-indigo-500' : 'text-zinc-500 border-transparent hover:text-zinc-300'"
                    class="flex-1 px-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] border-b-2 transition-all">
                Users
            </button>
            <button @click="tab = 'posts'"
                    :class="tab === 'posts' ? 'text-white border-indigo-500' : 'text-zinc-500 border-transparent hover:text-zinc-300'"
                    class="flex-1 px-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] border-b-2 transition-all">
                Posts
            </button>
        </div>

        <div class="max-h-96 overflow-y-auto custom-scrollbar">
            <!-- Users Tab -->
            <div x-show="tab === 'users'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @if($this->users->isNotEmpty())
                    @foreach($this->users as $user)
                        <a href="{{ route('profile.show', $user->name) }}" wire:navigate
                           class="flex items-center gap-3 px-4 py-3 hover:bg-white/5 transition-colors">
                            <img src="{{ $user->avatarUrl() }}" alt="" class="w-9 h-9 rounded-xl object-cover border border-white/10 shrink-0">
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                                @if($user->bio)
                                    <p class="text-[10px] text-zinc-500 truncate">{{ Str::limit($user->bio, 40) }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="px-4 py-12 text-center">
                        <svg class="w-8 h-8 text-zinc-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-zinc-600 text-xs font-medium">No users found</p>
                    </div>
                @endif
            </div>

            <!-- Posts Tab -->
            <div x-show="tab === 'posts'" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @if($this->posts->isNotEmpty())
                    @foreach($this->posts as $post)
                        <a href="{{ route('profile.show', $post->user->name) }}" wire:navigate
                           class="flex items-start gap-3 px-4 py-3 hover:bg-white/5 transition-colors">
                            <img src="{{ $post->user->avatarUrl() }}" alt="" class="w-7 h-7 rounded-lg object-cover border border-white/10 shrink-0 mt-0.5">
                            <div class="min-w-0">
                                <p class="text-[10px] font-black text-zinc-500 uppercase tracking-wider">{{ $post->user->name }}</p>
                                <p class="text-xs text-zinc-400 truncate mt-0.5">{{ Str::limit($post->body, 60) }}</p>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="px-4 py-12 text-center">
                        <svg class="w-8 h-8 text-zinc-700 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        <p class="text-zinc-600 text-xs font-medium">No posts found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
