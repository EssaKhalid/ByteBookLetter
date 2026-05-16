<nav class="w-full border-b border-white/5 bg-zinc-950/80 backdrop-blur-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center">

        <div class="flex-1 flex justify-start">
            <a href="{{ auth()->check() ? route('feed') : '/' }}" wire:navigate class="flex-shrink-0 flex items-center group">
                <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-lg flex items-center justify-center shadow-[0_0_15px_rgba(99,102,241,0.4)] group-hover:scale-110 transition-all duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <span class="ml-3 text-lg font-black tracking-tighter text-white italic">
                    Byte<span class="text-indigo-400">Book</span>Letter
                </span>
            </a>
        </div>

        <div class="flex-1 flex justify-center">
            <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-zinc-400">
                @auth
                    <a href="{{ route('feed') }}" wire:navigate class="hover:text-indigo-400 transition-colors {{ request()->routeIs('feed') ? 'text-indigo-400' : '' }}">Feed</a>
                    <a href="{{ route('following') }}" wire:navigate class="hover:text-indigo-400 transition-colors {{ request()->routeIs('following') ? 'text-indigo-400' : '' }}">Following</a>
                    <a href="{{ route('post.create') }}" wire:navigate class="hover:text-indigo-400 transition-colors {{ request()->routeIs('post.create') ? 'text-indigo-400' : '' }}">Create</a>
                @endauth
            </div>
        </div>

        <div class="flex-1 flex justify-end items-center">
            @auth
                <a href="{{ route('profile.show', auth()->user()->name) }}" wire:navigate class="relative group" title="Your profile">
                    <img src="{{ auth()->user()->avatarUrl() }}" alt="{{ auth()->user()->name }}"
                         class="w-9 h-9 rounded-full border-2 border-zinc-700 object-cover group-hover:border-indigo-500 transition-all">
                </a>
            @endauth

            @guest
                <div class="flex items-center space-x-5">
                    <a href="{{ route('login') }}" wire:navigate class="text-sm font-semibold text-zinc-400 hover:text-white transition-colors">Log in</a>
                    <a href="{{ route('register') }}" wire:navigate class="relative group px-5 py-2">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-violet-600 rounded-lg blur-sm opacity-40 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <div class="relative bg-gradient-to-r from-indigo-500 to-violet-600 px-5 py-2 rounded-lg text-sm font-bold text-white shadow-lg active:scale-95 transition-all">
                            Get Started
                        </div>
                    </a>
                </div>
            @endguest
        </div>
    </div>
</nav>
