<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="min-h-screen flex flex-col bg-zinc-950 text-zinc-100 antialiased">
    <x-navigation/>

    <main class="flex-grow w-full">
        {{ $slot }}
    </main>

    @livewireScripts

    <livewire:posts.comments />

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
         x-show="open"
         x-cloak
         @click.self="open = false"
         class="fixed inset-0 z-[200] flex items-center justify-center bg-zinc-950/95 backdrop-blur-xl"
         x-on:keydown.right.window="next()"
         x-on:keydown.left.window="prev()"
         x-on:keydown.escape.window="open = false">

        <button @click="open = false" class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors z-[210]">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <template x-if="images.length > 1">
            <div class="absolute inset-x-8 flex justify-between items-center pointer-events-none">
                <button @click="prev()" type="button" class="pointer-events-auto p-4 rounded-full bg-white/5 hover:bg-white/10 text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button @click="next()" type="button" class="pointer-events-auto p-4 rounded-full bg-white/5 hover:bg-white/10 text-white transition-all">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>
        </template>

        <div class="relative max-w-5xl max-h-[85vh] flex flex-col items-center px-4">
            <img :src="images[index]" alt="" class="max-w-full max-h-full object-contain shadow-2xl rounded-lg">
            <div class="mt-6 px-4 py-2 bg-white/5 rounded-full text-[10px] font-black text-white/40 uppercase tracking-[0.3em]">
                Byte <span x-text="index + 1" class="text-indigo-400"></span> of <span x-text="images.length"></span>
            </div>
        </div>
    </div>
</body>
</html>
