<div x-data="{
        wakingUp: false,
        magneticX: 0,
        magneticY: 0
    }"
     x-init="setTimeout(() => wakingUp = true, 100)"
     class="relative min-h-screen flex items-center justify-center px-6 overflow-hidden">

    <!-- THE LIGHTING: Floating Clouds (Consistency with Home) -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] animate-cloud-indigo blur-[120px]"></div>
        <div class="absolute bottom-0 -right-[10%] w-[50%] h-[50%] animate-cloud-violet blur-[120px]"></div>
    </div>

    <!-- REGISTER CARD -->
    <div x-show="wakingUp"
         x-transition:enter="transition ease-out duration-1000"
         x-transition:enter-start="opacity-0 scale-95 translate-y-10"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="relative z-10 w-full max-w-md bg-zinc-900/40 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-10 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)]">

        <!-- Brand Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-2xl mb-6 shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                <svg class="w-7 h-7 text-zinc-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h1 class="text-3xl font-black tracking-tighter text-white italic">Join <span class="text-indigo-400">ByteBook</span></h1>
            <p class="text-zinc-500 text-sm mt-2 font-medium tracking-tight">Create your signature in the universe.</p>
        </div>

        <form wire:submit.prevent="register" class="space-y-6">

            <!-- Field: Name (Staggered 1) -->
            <div x-show="wakingUp" x-transition:enter="transition delay-[200ms] duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2 ml-1">Full Name</label>
                <input wire:model="name" type="text"
                       class="w-full bg-zinc-800/30 border-none outline-none focus:ring-1 focus:ring-indigo-500/50 rounded-2xl p-4 text-sm text-white placeholder-zinc-700 caret-indigo-500 transition-all shadow-inner"
                       placeholder="Alex River">
                @error('name') <span class="text-[10px] text-red-500 font-bold mt-2 ml-1 block uppercase tracking-widest animate-pulse">{{ $message }}</span> @enderror
            </div>

            <!-- Field: Email (Staggered 2) -->
            <div x-show="wakingUp" x-transition:enter="transition delay-[300ms] duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2 ml-1">Email Address</label>
                <input wire:model="email" type="email"
                       class="w-full bg-zinc-800/30 border-none outline-none focus:ring-1 focus:ring-indigo-500/50 rounded-2xl p-4 text-sm text-white placeholder-zinc-700 caret-indigo-500 transition-all shadow-inner"
                       placeholder="alex@bytebook.com">

                <!-- LIVE REAL-TIME COUNTDOWN ERROR BLOCK -->
                @error('email')
                <div x-data="{ seconds: @entangle('secondsRemaining') }"
                     x-init="if (seconds > 0) { setInterval(() => { if (seconds > 0) seconds-- }, 1000) }"
                     class="text-[10px] text-red-500 font-bold mt-2 ml-1 uppercase tracking-widest animate-pulse">

                    <span x-show="seconds > 0">Spam protection: Please wait <span x-text="seconds"></span> seconds.</span>
                    <span x-show="seconds <= 0">{{ $message }}</span>
                </div>
                @enderror
            </div>

            <!-- Field: Password (Staggered 3) -->
            <div x-show="wakingUp" x-transition:enter="transition delay-[400ms] duration-700" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2 ml-1">Password</label>
                <input wire:model="password" type="password"
                       class="w-full bg-zinc-800/30 border-none outline-none focus:ring-1 focus:ring-indigo-500/50 rounded-2xl p-4 text-sm text-white placeholder-zinc-700 caret-indigo-500 transition-all shadow-inner"
                       placeholder="••••••••">
                @error('password') <span class="text-[10px] text-red-500 font-bold mt-2 ml-1 block uppercase tracking-widest animate-pulse">{{ $message }}</span> @enderror
            </div>

            <!-- THE MAGNETIC REGISTER BUTTON -->
            <div class="pt-4"
                 @mousemove="
                    let rect = $el.getBoundingClientRect();
                    magneticX = ($event.clientX - rect.left - rect.width/2) * 0.4;
                    magneticY = ($event.clientY - rect.top - rect.height/2) * 0.4;
                 "
                 @mouseleave="magneticX = 0; magneticY = 0">

                <button type="submit"
                        wire:loading.attr="disabled"
                        :style="`transform: translate(${magneticX}px, ${magneticY}px)`"
                        class="relative w-full py-5 bg-white text-zinc-950 rounded-[1.2rem] font-black text-xs uppercase tracking-[0.2em] transition-all duration-200 hover:shadow-[0_0_40px_rgba(255,255,255,0.2)] active:scale-95 disabled:opacity-50">

                    <span wire:loading.remove>Initialize Account</span>
                    <span wire:loading class="flex items-center justify-center space-x-2">
                        <svg class="animate-spin h-4 w-4 text-zinc-950" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Processing...</span>
                    </span>
                </button>
            </div>
        </form>

        <div class="mt-8 text-center">
            <p class="text-zinc-600 text-[10px] font-bold uppercase tracking-widest">
                Already part of the network?
                <a href="{{ route('login') }}" wire:navigate class="text-indigo-400 hover:text-white transition-colors ml-1">Sign In</a>
            </p>
        </div>
    </div>
</div>
