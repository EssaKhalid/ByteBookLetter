<div>
    @if($post)
        <div class="fixed inset-0 z-[250] flex items-center justify-center p-4"
             wire:keydown.escape.window="close">

            <button type="button" wire:click="close" class="absolute inset-0 bg-zinc-950/90 backdrop-blur-xl cursor-default" aria-label="Close thread"></button>

            <div class="relative w-full max-w-2xl bg-zinc-900/95 border border-white/10 rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col max-h-[85vh] z-10"
                 wire:click.stop>

                <div class="p-6 sm:p-8 border-b border-white/5 flex items-center justify-between shrink-0">
                    <div>
                        <h2 class="text-xl font-black text-white italic uppercase tracking-tighter">Byte<span class="text-indigo-500">Thread</span></h2>
                        <p class="text-[9px] font-bold text-zinc-500 uppercase tracking-widest mt-1">{{ $commentsCount }} in this thread</p>
                    </div>
                    <button type="button" wire:click="close" class="w-10 h-10 flex items-center justify-center bg-white/5 hover:bg-white/10 rounded-full text-zinc-400 hover:text-white transition-all" aria-label="Close">✕</button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-6 custom-scrollbar min-h-0">
                    @forelse($post->comments as $comment)
                        <div wire:key="comment-{{ $comment->id }}" class="flex gap-4">
                            <a href="{{ route('profile.show', $comment->user->name) }}" wire:navigate class="shrink-0">
                                <img src="{{ $comment->user->avatarUrl() }}" alt="" class="w-10 h-10 rounded-xl object-cover border border-white/10">
                            </a>
                            <div class="flex-1 min-w-0">
                                <div class="bg-zinc-950/60 border border-white/5 p-4 rounded-3xl rounded-tl-none">
                                    <div class="flex items-start justify-between gap-2 mb-2">
                                        <a href="{{ route('profile.show', $comment->user->name) }}" wire:navigate
                                           class="text-xs font-black text-white uppercase tracking-tight hover:text-indigo-400 transition-colors truncate">
                                            {{ $comment->user->name }}
                                        </a>
                                        <div class="flex items-center gap-2 shrink-0">
                                            <span class="text-[9px] font-bold text-zinc-600 uppercase">{{ $comment->created_at->diffForHumans() }}</span>
                                            @if(auth()->id() === $comment->user_id)
                                                <button type="button" wire:click="deleteComment({{ $comment->id }})"
                                                        wire:confirm="Delete this comment?"
                                                        class="text-[9px] font-bold text-red-400/80 hover:text-red-400 uppercase">Delete</button>
                                            @endif
                                        </div>
                                    </div>
                                    <p class="text-sm text-zinc-300 leading-relaxed whitespace-pre-wrap">{{ $comment->body }}</p>
                                </div>

                                <button type="button" wire:click="setReply({{ $comment->id }})"
                                        class="mt-2 ml-1 text-[9px] font-black text-indigo-400 uppercase tracking-widest hover:text-white transition-colors">
                                    Reply
                                </button>

                                @foreach($comment->replies as $reply)
                                    @include('livewire.posts.partials.comment-reply', ['reply' => $reply, 'depth' => 1])
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="py-16 text-center">
                            <p class="text-zinc-400 text-sm">No comments yet. Say something first.</p>
                        </div>
                    @endforelse
                </div>

                <div class="p-5 sm:p-6 bg-zinc-950/80 border-t border-white/5 shrink-0">
                    @if($replyingTo)
                        <div class="flex items-center justify-between mb-3 px-1">
                            <span class="text-[9px] font-black text-indigo-400 uppercase tracking-widest">
                                Replying to {{ $replyingToUser?->name ?? 'comment' }}
                            </span>
                            <button type="button" wire:click="cancelReply" class="text-[9px] font-bold text-zinc-600 hover:text-white uppercase tracking-widest">Cancel</button>
                        </div>
                    @endif

                    <form wire:submit.prevent="postComment" class="relative">
                        <textarea wire:model="newComment"
                                  rows="2"
                                  class="w-full bg-zinc-900 border border-white/5 rounded-3xl p-4 pr-16 text-sm text-white placeholder-zinc-600 outline-none focus:ring-1 focus:ring-indigo-500/50 resize-none"
                                  placeholder="Write a reply…"></textarea>
                        @error('newComment') <p class="text-red-400 text-xs mt-2">{{ $message }}</p> @enderror
                        <button type="submit" wire:loading.attr="disabled" wire:target="postComment"
                                class="absolute right-2 bottom-2 p-3 bg-white text-zinc-950 rounded-2xl hover:bg-indigo-500 hover:text-white transition-all disabled:opacity-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
