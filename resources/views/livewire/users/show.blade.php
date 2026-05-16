<div x-data="{ followersOpen: false, followingOpen: false }" class="w-full min-h-screen bg-zinc-950">
  <div class="relative h-[280px] w-full overflow-hidden">
    @if($user->bannerUrl())
      <img src="{{ $user->bannerUrl() }}" alt="" class="w-full h-full object-cover">
    @else
      <div class="w-full h-full bg-gradient-to-br from-indigo-950 via-zinc-950 to-violet-950"></div>
    @endif
    <div class="absolute inset-0 bg-gradient-to-t from-zinc-950 via-zinc-950/40 to-transparent"></div>
  </div>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 -mt-24 relative z-10 pb-20">
    <div class="bg-zinc-900/40 backdrop-blur-xl border border-white/10 rounded-[2.5rem] p-8 sm:p-10 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)]">
      <div class="flex flex-col sm:flex-row sm:items-end gap-6 sm:justify-between">
        <div class="flex flex-col sm:flex-row sm:items-end gap-6">
          <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}"
               class="w-32 h-32 sm:w-36 sm:h-36 rounded-[2rem] object-cover border-4 border-zinc-950 shadow-2xl shrink-0">

          <div class="pb-1">
            <h1 class="text-4xl sm:text-5xl font-black text-white italic tracking-tighter uppercase">
              {{ $user->name }}
              <span class="inline-block w-2.5 h-2.5 bg-indigo-500 rounded-full animate-pulse ml-2 align-middle"></span>
            </h1>
            <p class="text-zinc-400 mt-2 max-w-md font-medium leading-relaxed">
              {{ $user->bio ?? 'No bio signature yet.' }}
            </p>
          </div>
        </div>

        <div class="shrink-0">
          @if(auth()->id() === $user->id)
            <a href="{{ route('profile.edit') }}" wire:navigate
               class="inline-flex px-6 py-3 bg-white/10 hover:bg-white/15 border border-white/10 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all active:scale-95">
              Adjust Identity
            </a>
          @else
            <livewire:users.follow :targetId="$user->id" />
          @endif
        </div>
      </div>

      <div class="flex items-center gap-10 sm:gap-12 mt-10 pt-8 border-t border-white/5">
        <div>
          <span class="block text-2xl font-black text-white tracking-tighter">{{ $user->posts_count }}</span>
          <span class="text-[10px] font-black text-zinc-500 uppercase tracking-[0.3em]">Bytes</span>
        </div>
        <button type="button" @click="followersOpen = true" class="text-left group">
          <span class="block text-2xl font-black text-white tracking-tighter group-hover:text-indigo-400 transition-colors">{{ $user->followers_count }}</span>
          <span class="text-[10px] font-black text-zinc-500 uppercase tracking-[0.3em] group-hover:text-indigo-400/80 transition-colors">Followers</span>
        </button>
        <button type="button" @click="followingOpen = true" class="text-left group">
          <span class="block text-2xl font-black text-white tracking-tighter group-hover:text-indigo-400 transition-colors">{{ $user->following_count }}</span>
          <span class="text-[10px] font-black text-zinc-500 uppercase tracking-[0.3em] group-hover:text-indigo-400/80 transition-colors">Following</span>
        </button>
      </div>
    </div>

    <div class="mt-10 space-y-6">
      @forelse($posts as $post)
        <x-post-card :post="$post" />
      @empty
        <div class="py-16 text-center bg-zinc-900/40 border border-white/10 rounded-[2.5rem] px-6">
          @if(auth()->id() === $user->id)
            <p class="text-zinc-300 text-base">You haven't posted anything yet.</p>
            <p class="text-zinc-500 text-sm mt-2">Share something whenever you feel like it.</p>
            <a href="{{ route('post.create') }}" wire:navigate
               class="mt-5 inline-block text-indigo-400 text-sm font-semibold hover:text-white transition-colors">
              Write a post →
            </a>
          @else
            <p class="text-zinc-300 text-base">{{ $user->name }} hasn't posted anything yet.</p>
            <p class="text-zinc-500 text-sm mt-2">Check back another time.</p>
          @endif
        </div>
      @endforelse
    </div>
  </div>

  {{-- Followers modal --}}
  <div x-show="followersOpen" x-cloak @keydown.escape.window="followersOpen = false"
       class="fixed inset-0 z-[240] flex items-center justify-center p-4">
    <button type="button" @click="followersOpen = false" class="absolute inset-0 bg-zinc-950/90 backdrop-blur-xl" aria-label="Close"></button>
    <div class="relative w-full max-w-md bg-zinc-900/95 border border-white/10 rounded-[2rem] shadow-2xl max-h-[70vh] flex flex-col z-10" @click.stop>
      <div class="p-6 border-b border-white/5 flex items-center justify-between shrink-0">
        <h2 class="text-lg font-black text-white italic uppercase tracking-tighter">Followers</h2>
        <button type="button" @click="followersOpen = false" class="w-8 h-8 flex items-center justify-center bg-white/5 rounded-full text-zinc-400 hover:text-white">✕</button>
      </div>
      <div class="overflow-y-auto p-4 space-y-2 custom-scrollbar">
        @forelse($followersList as $follower)
          <a href="{{ route('profile.show', $follower->name) }}" wire:navigate @click="followersOpen = false"
             class="flex items-center gap-3 p-3 rounded-2xl hover:bg-white/5 transition-colors">
            <img src="{{ $follower->avatarUrl() }}" alt="" class="w-10 h-10 rounded-xl object-cover border border-white/10">
            <span class="text-sm font-black text-white uppercase tracking-tight">{{ $follower->name }}</span>
          </a>
        @empty
          <p class="text-center text-zinc-500 text-sm py-8">No followers yet.</p>
        @endforelse
      </div>
    </div>
  </div>

  {{-- Following modal --}}
  <div x-show="followingOpen" x-cloak @keydown.escape.window="followingOpen = false"
       class="fixed inset-0 z-[240] flex items-center justify-center p-4">
    <button type="button" @click="followingOpen = false" class="absolute inset-0 bg-zinc-950/90 backdrop-blur-xl" aria-label="Close"></button>
    <div class="relative w-full max-w-md bg-zinc-900/95 border border-white/10 rounded-[2rem] shadow-2xl max-h-[70vh] flex flex-col z-10" @click.stop>
      <div class="p-6 border-b border-white/5 flex items-center justify-between shrink-0">
        <h2 class="text-lg font-black text-white italic uppercase tracking-tighter">Following</h2>
        <button type="button" @click="followingOpen = false" class="w-8 h-8 flex items-center justify-center bg-white/5 rounded-full text-zinc-400 hover:text-white">✕</button>
      </div>
      <div class="overflow-y-auto p-4 space-y-2 custom-scrollbar">
        @forelse($followingList as $followed)
          <a href="{{ route('profile.show', $followed->name) }}" wire:navigate @click="followingOpen = false"
             class="flex items-center gap-3 p-3 rounded-2xl hover:bg-white/5 transition-colors">
            <img src="{{ $followed->avatarUrl() }}" alt="" class="w-10 h-10 rounded-xl object-cover border border-white/10">
            <span class="text-sm font-black text-white uppercase tracking-tight">{{ $followed->name }}</span>
          </a>
        @empty
          <p class="text-center text-zinc-500 text-sm py-8">Not following anyone yet.</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
