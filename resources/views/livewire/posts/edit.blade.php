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
            <select wire:model="form.privacy" class="w-full bg-zinc-950 border border-white/5 rounded-2xl px-5 py-3 text-sm text-white">
                @foreach(\App\Enums\PostPrivacy::cases() as $privacy)
                    <option value="{{ $privacy->value }}">{{ $privacy->label() }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-[9px] font-black text-zinc-500 uppercase tracking-[0.3em] mb-3 block">Add images</label>
            <input type="file" wire:model="form.images" multiple accept="image/*"
                   class="block w-full text-sm text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-white/10 file:text-white file:font-bold file:text-[10px] file:uppercase">
            @error('form.images.*') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
        </div>

        @if($post->images->isNotEmpty())
            <div class="grid grid-cols-3 gap-2">
                @foreach($post->images as $image)
                    <img src="{{ $image->url() }}" alt="" class="rounded-xl aspect-square object-cover border border-white/10">
                @endforeach
            </div>
        @endif

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
