<div x-data="{
        wakingUp: false,
        magneticX: 0,
        magneticY: 0
    }"
     x-init="setTimeout(() => wakingUp = true, 100)"
     class="relative min-h-screen flex items-center justify-center px-6 overflow-hidden">

    <!-- THE LIGHTING: Floating Clouds (Deep Indigo & Dark Violet) -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] animate-cloud-indigo blur-[120px]"></div>
        <div class="absolute bottom-0 -right-[10%] w-[50%] h-[50%] animate-cloud-violet blur-[120px]"></div>
    </div>

    <!-- LOGIN CARD -->
    <div x-show="wakingUp"
         x-transition:enter="transition ease-out duration-1000"
         x-transition:enter-start="opacity-0 scale-95 translate-y-10"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         class="relative z-10 w-full max-w-md bg-zinc-900/40 backdrop-blur-2xl border border-white/10 rounded-[2.5rem] p-10 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)]">

        <!-- Brand Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-white rounded-2xl mb-6 shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                <svg class="w-7 h-7 text-zinc-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h1 class="text-3xl font-black tracking-tighter text-white italic">Welcome <span class="text-indigo-400">Back</span></h1>
            <p class="text-zinc-500 text-sm mt-2 font-medium tracking-tight">Re-synchronizing your data universe.</p>
        </div>

        <form wire:submit.prevent="login" class="space-y-6">

            <!-- Field: Email (Staggered 1) -->
            <div x-show="wakingUp"
                 x-transition:enter="transition delay-[200ms] duration-700"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500 mb-2 ml-1">Identity (Email)</label>
                <input wire:model="email" type="email"
                       class="w-full bg-zinc-800/30 border-none outline-none focus:ring-1 focus:ring-indigo-500/50 rounded-2xl p-4 text-sm text-white placeholder-zinc-700 caret-indigo-500 transition-all shadow-inner"
                       placeholder="Enter your email">
                @error('email') <span class="text-[10px] text-red-500 font-bold mt-2 ml-1 block uppercase tracking-widest animate-pulse">{{ $message }}</span> @enderror
            </div>

            <!-- Field: Password (Staggered 2) -->
            <div x-show="wakingUp"
                 x-transition:enter="transition delay-[300ms] duration-700"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <div class="flex justify-between items-center mb-2 ml-1">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-zinc-500">Access Key</label>
                    <a href="#" class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest hover:text-white transition-colors">Forgot?</a>
                </div>
                <input wire:model="password" type="password"
                       class="w-full bg-zinc-800/30 border-none outline-none focus:ring-1 focus:ring-indigo-500/50 rounded-2xl p-4 text-sm text-white placeholder-zinc-700 caret-indigo-500 transition-all shadow-inner"
                       placeholder="••••••••">
                @error('password') <span class="text-[10px] text-red-500 font-bold mt-2 ml-1 block uppercase tracking-widest animate-pulse">{{ $message }}</span> @enderror
            </div>

            <!-- THE MAGNETIC LOGIN BUTTON (Staggered 3) -->
            <div class="pt-4"
                 x-show="wakingUp"
                 x-transition:enter="transition delay-[400ms] duration-700"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
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

                    <span wire:loading.remove>Enter Universe</span>
                    <span wire:loading class="flex items-center justify-center space-x-2">
                        <svg class="animate-spin h-4 w-4 text-zinc-950" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Verifying...</span>
                    </span>
                </button>
            </div>
        </form>

        <!-- Footer Navigation -->
        <div class="mt-8 text-center"
             x-show="wakingUp"
             x-transition:enter="transition delay-[500ms] duration-700"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <p class="text-zinc-600 text-[10px] font-bold uppercase tracking-widest">
                New to the platform?
                <a href="/register" class="text-indigo-400 hover:text-white transition-colors ml-1">Create Account</a>
            </p>
        </div>
    </div>
</div>
