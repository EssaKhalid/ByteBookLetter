<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }

        html {
            scrollbar-width: thin;
            scrollbar-color: #334155 #0f172a;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #09090b;
            color: #e2e8f0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
    @livewireStyles
</head>

<body class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100">
    <x-navigation/>

    <main class="flex-grow flex flex-col items-center w-full">
        <div class="w-full {{ Route::is('home') ? '' : 'max-w-2xl px-4 py-12' }}">
            {{ $slot }}
        </div>
    </main>



@livewireScripts

    <livewire:posts.comments />

    <!-- GLOBAL MEDIA GALLERY -->
    <div x-data="{
    open: false,
    images: [],
    index: 0,
    show(imgArray, startAt) {
        this.images = imgArray;
        this.index = startAt;
        this.open = true;
    },
    next() { this.index = (this.index + 1) % this.images.length },
    prev() { this.index = (this.index - 1 + this.images.length) % this.images.length }
}"
         @open-gallery.window="show($event.detail.images, $event.detail.index)"
         x-show="open" x-cloak @click.self="open = false" class="fixed inset-0 z-[200] flex items-center justify-center bg-zinc-950/95 backdrop-blur-xl transition-all"
         x-on:keydown.right.window="next()" x-on:keydown.left.window="prev()" x-on:keydown.escape.window="open = false">

        <button @click="open = false" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors z-[210]">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Navigation Arrows -->
        <template x-if="images.length > 1">
            <div class="absolute inset-x-8 flex justify-between items-center pointer-events-none">
                <button @click="prev()" class="pointer-events-auto p-4 rounded-full bg-white/5 hover:bg-white/10 text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" class="pointer-events-auto p-4 rounded-full bg-white/5 hover:bg-white/10 text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </template>

        <!-- High Res Image -->
        <div class="relative max-w-5xl max-h-[85vh] flex flex-col items-center">
            <img :src="images[index]" class="max-w-full max-h-full object-contain shadow-2xl rounded-lg animate-in zoom-in-95 duration-300">
            <div class="mt-6 px-4 py-2 bg-white/5 rounded-full text-[10px] font-black text-white/40 uppercase tracking-[0.3em]">
                Byte <span x-text="index + 1" class="text-indigo-400"></span> of <span x-text="images.length"></span>
            </div>
        </div>
    </div>
</body>
</html>
