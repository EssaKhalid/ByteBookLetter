<x-app-layout title="Home">
    <div x-data="{
            scrolled: false,
            wakingUp: false
        }"
         x-init="
            setTimeout(() => wakingUp = true, 100);
            window.addEventListener('scroll', () => scrolled = window.scrollY > 20)
        "
         class="relative min-h-screen">

        <!-- THE LIGHTING: Floating Clouds -->
        <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
            <div class="absolute -top-[10%] -left-[10%] w-[60%] h-[60%] animate-cloud-indigo blur-[120px]"></div>
            <div class="absolute top-[30%] -right-[10%] w-[50%] h-[50%] animate-cloud-violet blur-[120px]"></div>
        </div>

        <!-- THE CURTAIN: Page Entry Transition -->
        <div x-show="!wakingUp"
             class="fixed inset-0 bg-zinc-950 z-[100] transition-opacity duration-1000"></div>



        <!-- HERO SECTION -->
        <main class="relative z-10 pt-44 pb-32 px-8">
            <div class="max-w-5xl mx-auto text-center">

                <!-- Staggered Headline -->
                <h1 class="text-6xl md:text-8xl font-black tracking-tight leading-[0.9] mb-8">
                    @php $words = explode(' ', "Where every byte and letter meets."); @endphp
                    @foreach($words as $index => $word)
                        <span class="inline-block"
                              x-show="wakingUp"
                              x-transition:enter="transition ease-out duration-700"
                              x-transition:enter-start="opacity-0 translate-y-8"
                              x-transition:enter-end="opacity-100 translate-y-0"
                              style="transition-delay: {{ $index * 100 }}ms">
                            @if(in_array($word, ['byte', 'letter']))
                                <span class="text-indigo-500 pulse-glow">{{ $word }}</span>
                            @else
                                {{ $word }}
                            @endif
                        </span>
                    @endforeach
                </h1>

                <p x-show="wakingUp"
                   x-transition:enter="transition ease-out duration-1000 delay-700"
                   x-transition:enter-start="opacity-0"
                   x-transition:enter-end="opacity-100"
                   class="max-w-2xl mx-auto text-zinc-500 text-lg md:text-xl font-medium mb-12 tracking-tight">
                    The next generation of high-fidelity social networking.
                    Built for creators who value speed, privacy, and the poetry of data.
                </p>

                <!-- MAGNETIC BUTTON -->
                <div x-data="{ x: 0, y: 0 }"
                     @mousemove="
                        let rect = $el.getBoundingClientRect();
                        x = ($event.clientX - rect.left - rect.width/2) * 0.3;
                        y = ($event.clientY - rect.top - rect.height/2) * 0.3;
                     "
                     @mouseleave="x = 0; y = 0"
                     class="inline-block">
                    <a href="/post/create"
                       :style="`transform: translate(${x}px, ${y}px)`"
                       class="relative px-12 py-5 bg-white text-zinc-950 rounded-full font-black text-xs uppercase tracking-[0.2em] transition-all duration-200 shadow-[0_0_40px_rgba(255,255,255,0.1)] hover:shadow-[0_0_60px_rgba(255,255,255,0.2)] block">
                        Launch Universe
                        <div class="absolute inset-0 rounded-full bg-white/20 blur-xl opacity-0 hover:opacity-100 transition-opacity"></div>
                    </a>
                </div>
            </div>

            <!-- SCROLL REVEAL SECTION -->
            <!-- SCROLL REVEAL SECTION -->
            <div class="mt-48 max-w-screen-2xl mx-auto px-10 grid grid-cols-1 md:grid-cols-3 gap-10 pb-40">
                <!-- Card 1 -->
                <div x-intersect="$el.classList.add('reveal-active')"
                     class="group relative bg-zinc-900/30 border border-white/5 p-12 rounded-[3.5rem] backdrop-blur-xl transition-all duration-500 hover:-translate-y-2 hover:border-white/20 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)] reveal-hidden">
                    <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl mb-10 flex items-center justify-center text-indigo-400 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-3xl font-extrabold mb-6 tracking-tight italic uppercase text-white/90">Ghost Protocol</h3>
                    <p class="text-zinc-500 text-lg leading-relaxed font-medium">Post without the anxiety. Every letter you send is yours to keep, encrypted and clean. No algorithms telling you what to think.</p>
                </div>

                <!-- Card 2 -->
                <div x-intersect="$el.classList.add('reveal-active')"
                     class="group relative bg-zinc-900/30 border border-white/5 p-12 rounded-[3.5rem] backdrop-blur-xl transition-all duration-500 hover:-translate-y-2 hover:border-white/20 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)] reveal-hidden">
                    <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl mb-10 flex items-center justify-center text-indigo-400 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-3xl font-extrabold mb-6 tracking-tight italic uppercase text-white/90">Raw Velocity</h3>
                    <p class="text-zinc-500 text-lg leading-relaxed font-medium">We stripped away the junk. No bloat, no tracking. Just pure speed that makes other apps feel like they’re stuck in the mud.</p>
                </div>

                <!-- Card 3 -->
                <div x-intersect="$el.classList.add('reveal-active')"
                     class="group relative bg-zinc-900/30 border border-white/5 p-12 rounded-[3.5rem] backdrop-blur-xl transition-all duration-500 hover:-translate-y-2 hover:border-white/20 shadow-[inset_0_1px_1px_rgba(255,255,255,0.05)] reveal-hidden">
                    <div class="w-16 h-16 bg-indigo-500/10 rounded-2xl mb-10 flex items-center justify-center text-indigo-400 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-3xl font-extrabold mb-6 tracking-tight italic uppercase text-white/90">Human Pulse</h3>
                    <p class="text-zinc-500 text-lg leading-relaxed font-medium">Real threads, real people. We built this for the late-night talks and shared jokes. A place for your identity to breathe and grow.</p>
                </div>
            </div>


        </main>

        <style>
            /* Scroll Reveal Utility */
            .reveal-hidden {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
                transition: all 1s cubic-bezier(0.22, 1, 0.36, 1);
            }
            .reveal-active {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        </style>
    </div>
</x-app-layout>
