<div class="w-full max-w-2xl mx-auto">
    <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('feed') }}" wire:navigate
       class="text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-white transition-colors">
        ← Back
    </a>

    <h1 class="mt-4 text-3xl font-black text-white italic uppercase tracking-tighter mb-8">
        Refine <span class="text-indigo-500">Byte</span>
    </h1>

    @if (session()->has('success_EditedPost'))
        <div class="mb-6 bg-indigo-500/10 border border-indigo-500/30 text-indigo-200 text-sm font-semibold px-5 py-4 rounded-2xl">
            {{ session('success_EditedPost') }}
        </div>
    @endif

    <form wire:submit.prevent="update" class="space-y-6 bg-zinc-900/40 border border-white/10 rounded-[2.5rem] p-8">
        <div>
            <label class="text-[9px] font-black text-zinc-500 uppercase tracking-[0.3em] mb-3 block">Body</label>
            <textarea wire:model="form.body"
                      class="w-full bg-zinc-950 border border-white/5 rounded-3xl p-5 text-lg text-zinc-200 placeholder-zinc-700 resize-none min-h-[180px] focus:ring-1 focus:ring-indigo-500/50 outline-none"
                      placeholder="What's on your mind?"></textarea>
            @error('form.body') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="text-[9px] font-black text-zinc-500 uppercase tracking-[0.3em] mb-3 block">Privacy</label>
            <button type="button" wire:click="cyclePrivacy"
                    class="flex items-center space-x-2 px-5 py-3 bg-zinc-950 border border-white/5 rounded-2xl text-sm text-white hover:border-white/20 transition-all">
                <svg class="w-4 h-4 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <span>{{ $form->privacy === 'public' ? 'Public' : ($form->privacy === 'friends' ? 'Friends Only' : 'Only Me') }}</span>
            </button>
        </div>

        <div>
            <label class="text-[9px] font-black text-zinc-500 uppercase tracking-[0.3em] mb-3 block">Images</label>

            @if($post->images->isNotEmpty() || ($form->images && count($form->images) > 0))
                <div class="grid grid-cols-2 gap-2 mb-4">
                    @foreach($post->images as $image)
                        <div class="relative aspect-square rounded-xl overflow-hidden border border-white/10 group">
                            <img src="{{ $image->url() }}" alt="" class="w-full h-full object-cover">
                            <button type="button"
                                    wire:click="deleteExistingImage({{ $image->id }})"
                                    wire:confirm="Delete this image?"
                                    class="absolute top-2 right-2 bg-black/60 backdrop-blur-md p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 text-white z-10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforeach
                    @if($form->images)
                        @foreach($form->images as $index => $img)
                            @if($img && is_object($img) && method_exists($img, 'temporaryUrl'))
                                <div class="relative aspect-square rounded-xl overflow-hidden border border-white/10 group">
                                    <img src="{{ $img->temporaryUrl() }}" alt="" class="w-full h-full object-cover">
                                    <button type="button"
                                            wire:click="removeImage({{ $index }})"
                                            class="absolute top-2 right-2 bg-black/60 backdrop-blur-md p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 text-white z-10">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            @endif

            <label class="flex flex-col items-center justify-center w-full p-6 border-2 border-dashed border-white/10 rounded-2xl cursor-pointer hover:border-indigo-500/50 hover:bg-indigo-500/5 transition-all group">
                <input type="file" wire:model="form.images" multiple accept="image/*" class="hidden">
                <svg class="w-8 h-8 text-zinc-600 group-hover:text-indigo-400 transition-colors mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <span class="text-[10px] font-black uppercase tracking-widest text-zinc-500 group-hover:text-indigo-400 transition-colors">Add Images</span>
            </label>
            @error('form.images.*') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end gap-4 pt-2">
            <a href="{{ route('feed') }}" wire:navigate class="text-[10px] font-black uppercase tracking-widest text-zinc-500 hover:text-white py-3">Cancel</a>
            <button type="submit"
                    class="px-10 py-3 bg-white text-zinc-950 rounded-full font-black text-[10px] uppercase tracking-widest hover:scale-105 active:scale-95 transition-all">
                <span wire:loading.remove wire:target="update">Save Changes</span>
                <span wire:loading wire:target="update">Saving…</span>
            </button>
        </div>
    </form>
</div>
