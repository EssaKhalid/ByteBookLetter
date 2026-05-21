<div class="w-full max-w-4xl pt-12 px-4">
    <div x-data="{
        activeTool: null,
        content: @entangle('form.body'),
        previewImage: null,

        insertEmoji(emoji) {
            this.content += emoji;
            this.activeTool = null;
        },
        locSearch: '',
        locations: [],
        async fetchLocations() {
            if(this.locSearch.length < 3) return;
            const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${this.locSearch}`);
            this.locations = await res.json();
        }
    }" class="w-full space-y-8 relative">

        <!-- PRO SUCCESS CARD (Updated Flash Key) -->
        @if (session()->has('success_CreatedPost'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="bg-indigo-500/10 border border-indigo-500/50 p-4 rounded-2xl flex items-center justify-between shadow-[0_0_20px_rgba(99,102,241,0.2)]">
                <div class="flex items-center space-x-3">
                    <div class="bg-indigo-500 p-1.5 rounded-full">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-indigo-100 text-sm font-semibold">{{ session('success_CreatedPost') }}</span>
                </div>
                <button @click="show = false" type="button" class="text-indigo-300 hover:text-white">✕</button>
            </div>
        @endif

        <form wire:submit.prevent="save">
            <!-- Header: Drafting Post & Avatar -->
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 rounded-full overflow-hidden border border-white/10 shadow-lg">
                    <img src="{{ auth()->user()->avatarUrl() }}" alt="" class="w-full h-full object-cover">
                </div>
                <div class="flex flex-col">
                    <h3 class="text-gray-200 font-semibold text-base leading-none tracking-tight">{{ auth()->user()->name }}</h3>
                    <span class="text-[10px] font-bold text-indigo-500 uppercase tracking-[0.2em] mt-1.5">Drafting Post</span>
                </div>
            </div>

            <!-- Text Area (Bound to form.body) -->
            <div class="mt-8">
            <textarea x-model="content"
                      class="w-full bg-transparent border-none outline-none focus:ring-0 text-3xl md:text-4xl text-gray-100 placeholder-gray-800 resize-none min-h-[150px] caret-indigo-500 p-0 shadow-none"
                      placeholder="What's emerging today?"></textarea>

                @error('form.body')
                <p class="text-red-500 text-xs font-bold uppercase tracking-widest mt-4 animate-pulse">{{ $message }}</p>
                @enderror
            </div>

            <!-- IMAGE PREVIEWS (Bound to form.images) -->
            @if ($form->images)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                    @foreach($form->images as $index => $img)
                        @if($img && is_object($img) && method_exists($img, 'temporaryUrl'))
                            <div class="relative aspect-video rounded-xl overflow-hidden border border-white/10 group shadow-2xl">
                                <img @click="previewImage = '{{ $img->temporaryUrl() }}'"
                                     src="{{ $img->temporaryUrl() }}"
                                     class="w-full h-full object-cover cursor-zoom-in hover:scale-105 transition-transform">

                                <!-- Remove Button (Calling form.removeImage) -->
                                <button type="button"
                                        wire:click="removeImage({{ $index }})"
                                        class="absolute top-2 right-2 bg-black/60 backdrop-blur-md p-1.5 rounded-lg opacity-0 group-hover:opacity-100 transition-all hover:bg-red-500 text-white z-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            <div class="h-px w-full bg-gradient-to-r from-transparent via-white/5 to-transparent my-10"></div>

            <div class="flex items-center justify-between pt-4 relative">

                <!-- EMOJI POPOVER -->
                <div x-show="activeTool === 'emoji'" x-transition @click.away="activeTool = null" class="absolute bottom-20 left-10 w-64 bg-[#161b22] border border-white/10 rounded-2xl shadow-2xl p-4 z-50">
                    <div class="grid grid-cols-5 gap-3">
                        <template x-for="emoji in ['🔥','🚀','😂','❤️','✨','🙌','👀','✅','💻','📍','🌈','⭐','⚡']">
                            <button @click="insertEmoji(emoji)" type="button" class="text-2xl hover:bg-white/5 p-2 rounded-xl transition-all" x-text="emoji"></button>
                        </template>
                    </div>
                </div>

                <!-- LOCATION POPOVER -->
                <div x-show="activeTool === 'location'" x-transition @click.away="activeTool = null" class="absolute bottom-20 left-0 w-80 bg-[#161b22] border border-white/10 rounded-2xl shadow-2xl p-4 z-50">
                    <input x-model="locSearch" @input.debounce.500ms="fetchLocations()" type="text" placeholder="Search locations..." class="w-full bg-white/5 border-none rounded-xl text-sm text-white focus:ring-1 focus:ring-indigo-500 p-3 mb-2">
                    <div class="max-h-40 overflow-y-auto">
                        <template x-for="loc in locations">
                            <button @click="content += ' 📍 ' + loc.display_name.split(',')[0]; activeTool = null" type="button" class="w-full text-left p-3 hover:bg-indigo-600 rounded-xl text-[11px] text-gray-400 truncate" x-text="loc.display_name"></button>
                        </template>
                    </div>
                </div>

                <!-- TOOLBAR -->
                <div class="flex items-center space-x-1 bg-white/[0.03] p-1.5 rounded-2xl border border-white/5 shadow-inner">
                    <label class="p-2.5 text-gray-400 hover:text-indigo-400 hover:bg-white/5 rounded-xl cursor-pointer transition-all">
                        <input type="file" wire:model="form.images" multiple class="hidden">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </label>
                    <button type="button" @click="activeTool = (activeTool === 'emoji' ? null : 'emoji')" class="p-2.5 text-gray-400 hover:text-indigo-400 hover:bg-white/5 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>
                    <button type="button" @click="activeTool = (activeTool === 'location' ? null : 'location')" class="p-2.5 text-gray-400 hover:text-indigo-400 hover:bg-white/5 rounded-xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                    </button>
                </div>

                <div class="flex items-center space-x-6">
                    <button type="button" wire:click="cyclePrivacy"
                            class="flex items-center space-x-2 px-4 py-2.5 bg-white/[0.03] border border-white/5 rounded-full text-[10px] font-black uppercase tracking-[0.15em] text-zinc-500 hover:text-white hover:border-white/20 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <span>{{ $form->privacy === 'public' ? 'Public' : ($form->privacy === 'friends' ? 'Friends' : 'Only Me') }}</span>
                    </button>
                    <a href="{{ route('feed') }}" wire:navigate class="text-xs font-bold uppercase tracking-widest text-gray-600 hover:text-white transition-colors">Cancel</a>
                    <button type="submit" wire:loading.attr="disabled" class="px-10 py-3 bg-gradient-to-r from-indigo-600 to-violet-500 rounded-full text-[10px] font-black tracking-[0.2em] text-white uppercase shadow-[0_0_20px_rgba(99,102,241,0.3)] hover:scale-105 active:scale-95 transition-all">
                        <span wire:loading.remove>Publish Post</span>
                        <span wire:loading>Publishing...</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- FULL SCREEN IMAGE PREVIEW MODAL -->
        <div x-show="previewImage"
             @click.away="previewImage = null"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4"
             x-transition.opacity>
            <button @click="previewImage = null" type="button" class="absolute top-6 right-6 text-white text-4xl hover:text-red-500 transition-colors">&times;</button>
            <img :src="previewImage" class="max-w-full max-h-full rounded-lg shadow-2xl">
        </div>
    </div>
</div>
