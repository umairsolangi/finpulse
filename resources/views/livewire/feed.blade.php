<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-6" style="font-family:'Plus Jakarta Sans',sans-serif;">

    <style>
        .fp-post-card {
            background:#fff; border:1px solid rgba(226,232,240,0.8);
            box-shadow:0 1px 4px rgba(0,0,0,0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .fp-post-card:hover { box-shadow:0 6px 24px rgba(57,229,84,0.12); border-color:rgba(57,229,84,0.25); }
        .fp-feed-tab-active { background:linear-gradient(135deg,#39E554,#32d44b); color:#0F172A; box-shadow:0 4px 14px rgba(57,229,84,0.3); }
        .fp-feed-tab { background:#f1f5f9; color:#64748b; border:1px solid transparent; }
        .fp-feed-tab:hover { background:#e2e8f0; color:#1e293b; }
        .section-label { font-size:0.65rem; font-weight:800; letter-spacing:0.15em; text-transform:uppercase; color:#28a04a; }
    </style>

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 fp-animate-in">
        <div>
            <p class="section-label mb-1">Community</p>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Community <span class=" bg-clip-text" style="background:linear-gradient(135deg,#39E554,#28a04a);">Feed</span>
            </h1>
            <p class="text-sm text-slate-500 mt-1 font-medium">Discuss financial insights, stocks, mutual funds, and market news.</p>
        </div>
    </div>

    {{-- Create Post Form --}}
    @if(auth()->user()?->can('post.create'))
        <div class="bg-white rounded-2xl p-5 sm:p-6 space-y-4 fp-animate-in"
            style="border:1px solid rgba(226,232,240,0.8); box-shadow:0 1px 4px rgba(0,0,0,0.04);">
            <h2 class="text-base font-black text-slate-900">Share an Update</h2>
            <form wire:submit="createPost" class="space-y-4">
                <div>
                    <label for="category" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Category</label>
                    <select id="category" wire:model="category"
                        class="w-full sm:w-64 rounded-xl border-slate-200 text-sm focus:border-[#39E554] focus:ring-[#39E554] transition-colors">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->value }}">{{ str_replace('_', ' ', ucfirst($cat->value)) }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="body" class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Post Content</label>
                    <textarea id="body" wire:model="body" rows="3" placeholder="What's on your financial radar today?"
                        class="w-full rounded-xl border-slate-200 text-sm focus:border-[#39E554] focus:ring-[#39E554] transition-colors"></textarea>
                    @error('body')
                        <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-5 py-2.5 text-slate-950 font-bold text-sm rounded-xl transition-all hover:-translate-y-0.5 shadow hover:shadow-lg"
                        style="background:linear-gradient(135deg,#39E554,#28a04a);">
                        Post Update
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Category Filter Tabs --}}
    <div class="flex items-center gap-2 overflow-x-auto pb-1 fp-animate-in" style="border-bottom:1px solid rgba(226,232,240,0.8);">
        <button type="button" wire:click="selectCategory('all')"
            class="px-4 py-2 text-sm rounded-xl font-bold whitespace-nowrap transition-all duration-200 {{ $selectedCategory === 'all' ? 'fp-feed-tab-active' : 'fp-feed-tab' }}">
            All Categories
        </button>
        @foreach($categories as $cat)
            <button type="button" wire:click="selectCategory('{{ $cat->value }}')"
                class="px-4 py-2 text-sm rounded-xl font-bold whitespace-nowrap transition-all duration-200 {{ $selectedCategory === $cat->value ? 'fp-feed-tab-active' : 'fp-feed-tab' }}">
                {{ str_replace('_', ' ', ucfirst($cat->value)) }}
            </button>
        @endforeach
    </div>

    {{-- Posts Stream --}}
    <div class="space-y-4 fp-stagger-grid">
        @forelse($posts as $post)
            <div class="fp-post-card rounded-2xl p-5 sm:p-6 space-y-4 group">
                {{-- Post Header --}}
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-black text-base shrink-0 text-slate-950 group-hover:scale-110 transition-transform duration-300"
                            style="background:linear-gradient(135deg,#39E554,#28a04a);">
                            {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-slate-900 text-sm sm:text-base">{{ $post->user->name ?? 'User' }}</span>
                                @if($post->user && $post->user->badges->isNotEmpty())
                                    @foreach($post->user->badges as $badge)
                                        <span title="{{ $badge->name }}: {{ $badge->description }}"
                                            class="inline-flex items-center gap-1 text-xs font-bold px-2 py-0.5 rounded-full border hover:scale-105 transition-transform"
                                            style="background:rgba(57,229,84,0.1); border-color:rgba(57,229,84,0.25); color:#28a04a;">
                                            <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            {{ $badge->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-400 mt-0.5 font-medium">
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        @php
                            $categoryStyle = match ($post->category->value ?? $post->category) {
                                'stocks'       => 'bg-blue-50 text-blue-700 border-blue-200',
                                'mutual_funds' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'basics'       => 'border-[#39E554]/25 text-[#28a04a]',
                                'news'         => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                default        => 'bg-slate-50 text-slate-600 border-slate-200',
                            };
                            $categoryBg = ($post->category->value ?? $post->category) === 'basics'
                                ? 'style="background:rgba(57,229,84,0.1);"'
                                : '';
                        @endphp
                        <span class="text-xs font-bold px-2.5 py-1 rounded-full border {{ $categoryStyle }}" {!! $categoryBg !!}>
                            {{ str_replace('_', ' ', ucfirst($post->category->value ?? $post->category)) }}
                        </span>

                        @if(auth()->user()?->can('post.moderate'))
                            <button type="button" wire:click="deletePost({{ $post->id }})"
                                wire:confirm="Are you sure you want to delete this post and all its comments?"
                                class="p-1 text-slate-400 hover:text-red-500 rounded transition-colors hover:bg-red-50"
                                title="Delete Post (Moderator)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Post Body --}}
                <div class="text-slate-700 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                    {{ $post->body }}
                </div>

                {{-- Actions Footer --}}
                <div class="pt-2 flex items-center gap-6" style="border-top:1px solid #f1f5f9;">
                    @php $hasReacted = $post->reactions->isNotEmpty(); @endphp
                    <button type="button" wire:click="toggleReaction({{ $post->id }})"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold transition-all duration-200 {{ $hasReacted ? 'text-red-500 font-bold' : 'text-slate-400 hover:text-red-400' }}"
                        title="React to post">
                        <svg class="w-4 h-4 {{ $hasReacted ? 'fill-current text-red-500' : 'fill-none stroke-current' }} {{ $hasReacted ? 'fp-react-pop' : '' }}"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.293l.318-.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                        </svg>
                        <span>{{ $post->reactions_count }}</span>
                    </button>

                    <button type="button" wire:click="toggleComments({{ $post->id }})"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-semibold text-slate-400 hover:text-[#28a04a] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>{{ $post->comments_count }} {{ Str::plural('Comment', $post->comments_count) }}</span>
                    </button>
                </div>

                {{-- Comments --}}
                @if(in_array($post->id, $openComments))
                    <div class="mt-4 pt-4 space-y-3 rounded-2xl p-4 fp-page-enter"
                        style="border-top:1px solid #f1f5f9; background:#f8fafc;">
                        <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Comments</h3>
                        <div class="space-y-3">
                            @forelse($post->comments as $comment)
                                <div class="bg-white rounded-xl p-3 text-xs sm:text-sm space-y-1 hover:shadow-sm transition-shadow"
                                    style="border:1px solid rgba(226,232,240,0.8);">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-bold text-slate-900">{{ $comment->user->name ?? 'User' }}</span>
                                            @if($comment->user && $comment->user->badges->isNotEmpty())
                                                @foreach($comment->user->badges as $badge)
                                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-1.5 py-0.5 rounded-full border"
                                                        style="background:rgba(57,229,84,0.1); border-color:rgba(57,229,84,0.2); color:#28a04a;">
                                                        🏆 {{ $badge->name }}
                                                    </span>
                                                @endforeach
                                            @endif
                                            <span class="text-[11px] text-slate-400 font-medium">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if(auth()->user()?->can('post.moderate'))
                                            <button type="button" wire:click="deleteComment({{ $comment->id }})"
                                                wire:confirm="Are you sure you want to delete this comment?"
                                                class="text-slate-400 hover:text-red-500 p-0.5 rounded transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    <p class="text-slate-600 whitespace-pre-line font-medium">{{ $comment->body }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 italic font-medium">No comments yet. Be the first to reply!</p>
                            @endforelse
                        </div>

                        @if(auth()->user()?->can('post.comment'))
                            <form wire:submit="addComment({{ $post->id }})" class="mt-3 flex gap-2">
                                <input type="text" wire:model="commentBody.{{ $post->id }}" placeholder="Write a comment..."
                                    class="flex-1 rounded-xl border-slate-200 text-xs sm:text-sm focus:border-[#39E554] focus:ring-[#39E554] transition-colors" />
                                <button type="submit"
                                    class="px-4 py-2 text-slate-950 font-bold text-xs sm:text-sm rounded-xl transition-all hover:-translate-y-0.5 shadow shrink-0"
                                    style="background:linear-gradient(135deg,#39E554,#28a04a);">
                                    Reply
                                </button>
                            </form>
                            @error("commentBody.{$post->id}")
                                <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-2xl p-8 text-center space-y-2 fp-animate-in"
                style="border:1px solid rgba(226,232,240,0.8);">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4"
                    style="background:rgba(57,229,84,0.1);">
                    <svg class="w-8 h-8 text-[#39E554]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <p class="text-base font-black text-slate-900">No posts found</p>
                <p class="text-sm text-slate-500 font-medium">There are no updates in this category yet. Be the first to share one!</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="pt-4">
        {{ $posts->links() }}
    </div>
</div>