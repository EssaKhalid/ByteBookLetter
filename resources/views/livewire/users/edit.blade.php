<div x-data="{ avatarPreview: null, bannerPreview: null }" class="w-full min-h-screen bg-zinc-950 py-10 px-4 sm:px-6">
  <div class="max-w-2xl mx-auto">
    @if (session()->has('success'))
      <div class="mb-6 bg-indigo-500/10 border border-indigo-500/30 text-indigo-200 text-sm font-semibold px-5 py-4 rounded-2xl">
        {{ session('success') }}
      </div>
    @endif

    <div class="mb-8">
      <a href="{{ route('profile.show', auth()->user()->name) }}" wire:navigate
         class="text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-white transition-colors">
        ← Back to profile
      </a>
      <h1 class="mt-4 text-3xl font-black text-white italic uppercase tracking-tighter">
        Adjust <span class="text-indigo-500">Identity</span>
      </h1>
      <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mt-1">Update avatar, banner, and bio</p>
    </div>

    <form wire:submit.prevent="update" class="space-y-8 bg-zinc-900/40 border border-white/10 rounded-[2.5rem] p-8 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)]">
      <div class="relative group h-48 rounded-[2rem] overflow-hidden bg-zinc-950 border border-white/5">
        <template x-if="bannerPreview">
          <img :src="bannerPreview" alt="" class="w-full h-full object-cover">
        </template>
        <template x-if="!bannerPreview">
          @if(auth()->user()->bannerUrl())
            <img src="{{ auth()->user()->bannerUrl() }}" alt="" class="w-full h-full object-cover">
          @else
            <div class="w-full h-full bg-gradient-to-br from-indigo-950 via-zinc-950 to-violet-950"></div>
          @endif
        </template>
        <label class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
          <span class="bg-white text-zinc-950 px-6 py-3 rounded-xl font-black text-[10px] tracking-widest uppercase">Change Banner</span>
          <input type="file" wire:model="newBanner" class="hidden" accept="image/*"
                 @change="bannerPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
        </label>
        <div wire:loading wire:target="newBanner" class="absolute bottom-3 right-3 text-[10px] font-bold text-white/70 uppercase">Uploading…</div>
      </div>

      <div class="flex flex-col sm:flex-row items-start gap-8">
        <div class="relative w-32 h-32 rounded-3xl overflow-hidden bg-zinc-950 border border-white/10 shrink-0 group">
          <template x-if="avatarPreview">
            <img :src="avatarPreview" alt="" class="w-full h-full object-cover">
          </template>
          <template x-if="!avatarPreview">
            <img src="{{ auth()->user()->avatarUrl() }}" alt="" class="w-full h-full object-cover">
          </template>
          <label class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
            <input type="file" wire:model="newAvatar" class="hidden" accept="image/*"
                   @change="avatarPreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
          </label>
        </div>

        <div class="flex-1 w-full">
          <label class="text-[9px] font-black text-zinc-500 uppercase tracking-[0.3em] mb-3 block">Bio Signature</label>
          <textarea wire:model="newBio"
                    class="w-full bg-zinc-950 border border-white/5 rounded-2xl p-5 text-sm text-white focus:ring-1 focus:ring-indigo-500/50 outline-none h-32 resize-none"
                    placeholder="Enter your identity signature..."></textarea>
          @error('newBio') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
        </div>
      </div>

      @error('newAvatar') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror
      @error('newBanner') <p class="text-red-400 text-xs">{{ $message }}</p> @enderror

      <button type="submit"
              class="w-full py-4 bg-indigo-500 text-white rounded-2xl font-black uppercase tracking-[0.2em] text-xs hover:bg-indigo-600 transition-all active:scale-95 flex items-center justify-center gap-2">
        <span wire:loading.remove wire:target="update">Synchronize Identity</span>
        <span wire:loading wire:target="update" class="flex items-center gap-2">
          <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
          Processing…
        </span>
      </button>
    </form>
  </div>
</div>
