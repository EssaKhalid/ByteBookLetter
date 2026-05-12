<div>
    @if (session()->has('message'))
        <div style="color: green;">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="save">
        <textarea wire:model="body" placeholder="What's on your mind?"></textarea>
        @error('body') <span style="color: red;">{{ $message }}</span> @enderror

        <button type="submit">Post to ByteBookLetter</button>
    </form>
</div>
