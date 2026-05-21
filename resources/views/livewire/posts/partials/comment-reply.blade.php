@php
    $padding = $depth > 1 ? 'pl-8' : 'pl-4';
    $avatarSize = $depth > 1 ? 'w-7 h-7 rounded-lg' : 'w-8 h-8 rounded-lg';
@endphp
<div wire:key="reply-{{ $reply->id }}" class="mt-4 flex gap-3 border-l-2 border-indigo-500/20 {{ $padding }}">
    <a href="{{ route('profile.show', $reply->user->name) }}" wire:navigate class="shrink-0">
        <img src="{{ $reply->user->avatarUrl() }}" alt="" class="{{ $avatarSize }} object-cover border border-white/10">
    </a>
    <div class="flex-1 min-w-0">
        <div class="bg-indigo-500/5 p-3 rounded-2xl border border-indigo-500/10">
            <div class="flex items-start justify-between gap-2 mb-1">
                <a href="{{ route('profile.show', $reply->user->name) }}" wire:navigate
                   class="text-[10px] font-black text-white uppercase hover:text-indigo-400 transition-colors">{{ $reply->user->name }}</a>
                <div class="flex items-center gap-2 shrink-0">
                    <span class="text-[9px] font-bold text-zinc-600 uppercase">{{ $reply->created_at->diffForHumans() }}</span>
                    @if(auth()->id() === $reply->user_id)
                        <button type="button" wire:click="deleteComment({{ $reply->id }})"
                                wire:confirm="Delete this comment?"
                                class="text-[9px] font-bold text-red-400/80 hover:text-red-400 uppercase">Delete</button>
                    @endif
                </div>
            </div>
            <p class="text-xs text-zinc-400 leading-relaxed whitespace-pre-wrap">{{ $reply->body }}</p>
        </div>

        <div class="mt-2 ml-1 flex items-center gap-3">
            <livewire:posts.comment-like :comment="$reply" :wire:key="'clike-'.$reply->id" />
            <button type="button" wire:click="setReply({{ $reply->id }})"
                    class="text-[9px] font-black text-indigo-400 uppercase tracking-widest hover:text-white transition-colors">
                Reply
            </button>
        </div>

        @foreach($reply->replies as $nested)
            @include('livewire.posts.partials.comment-reply', ['reply' => $nested, 'depth' => $depth + 1])
        @endforeach
    </div>
</div>
