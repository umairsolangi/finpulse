<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 fp-animate-in">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-finpulse-navy">Community Feed</h1>
            <p class="text-sm text-finpulse-gray mt-1">Discuss financial insights, stocks, mutual funds, and market
                news.</p>
        </div>
    </div>

    <!-- Create Post Form (Visible if user has post.create permission) -->
    @if(auth()->user()?->can('post.create'))
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 space-y-4 fp-animate-in">
            <h2 class="text-lg font-semibold text-finpulse-navy">Share an Update</h2>

            <form wire:submit="createPost" class="space-y-4">
                <div>
                    <label for="category"
                        class="block text-xs font-semibold text-finpulse-gray uppercase tracking-wider mb-1">
                        Category
                    </label>
                    <select id="category" wire:model="category"
                        class="w-full sm:w-64 rounded-lg border-gray-300 text-sm focus:border-finpulse-navy focus:ring-finpulse-navy transition-colors">
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->value }}">{{ str_replace('_', ' ', ucfirst($cat->value)) }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="body" class="block text-xs font-semibold text-finpulse-gray uppercase tracking-wider mb-1">
                        Post Content
                    </label>
                    <textarea id="body" wire:model="body" rows="3" placeholder="What's on your financial radar today?"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-finpulse-navy focus:ring-finpulse-navy transition-colors"></textarea>
                    @error('body')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="px-5 py-2.5 bg-finpulse-navy hover:bg-[#C89B3C] text-white hover:text-finpulse-navy font-semibold text-sm rounded-lg transition-all duration-300 shadow-sm hover:shadow-md hover:-translate-y-0.5">
                        Post Update
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Category Filter Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-gray-200 fp-animate-in">
        <button type="button" wire:click="selectCategory('all')"
            class="px-4 py-2 text-sm rounded-lg font-medium whitespace-nowrap transition-all duration-200 {{ $selectedCategory === 'all' ? 'bg-finpulse-navy text-white shadow-sm font-semibold' : 'bg-white text-gray-700 hover:bg-gray-100 hover:text-finpulse-navy border border-gray-200 hover:border-gray-300' }}">
            All Categories
        </button>
        @foreach($categories as $cat)
            <button type="button" wire:click="selectCategory('{{ $cat->value }}')"
                class="px-4 py-2 text-sm rounded-lg font-medium whitespace-nowrap transition-all duration-200 {{ $selectedCategory === $cat->value ? 'bg-finpulse-navy text-white shadow-sm font-semibold' : 'bg-white text-gray-700 hover:bg-gray-100 hover:text-finpulse-navy border border-gray-200 hover:border-gray-300' }}">
                {{ str_replace('_', ' ', ucfirst($cat->value)) }}
            </button>
        @endforeach
    </div>

    <!-- Posts Feed Stream -->
    <div class="space-y-4 fp-stagger-grid">
        @forelse($posts as $post)
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 sm:p-6 space-y-4 hover:shadow-lg hover:border-gray-300 transition-all duration-300 group">
                <!-- Post Header -->
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-finpulse-navy text-white flex items-center justify-center font-bold text-base shrink-0 shadow-sm group-hover:scale-110 transition-transform duration-300">
                            {{ strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <span
                                    class="font-semibold text-gray-900 text-sm sm:text-base">{{ $post->user->name ?? 'User' }}</span>

                                <!-- User Earned Badges Indicator -->
                                @if($post->user && $post->user->badges->isNotEmpty())
                                    @foreach($post->user->badges as $badge)
                                        <span title="{{ $badge->name }}: {{ $badge->description }}"
                                            class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-300 hover:scale-105 transition-transform">
                                            <svg class="w-3 h-3 text-amber-600 fill-current" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            {{ $badge->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>

                            <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Category Badge -->
                        @php
                            $categoryStyle = match ($post->category->value ?? $post->category) {
                                'stocks' => 'bg-blue-100 text-finpulse-navy border-blue-200',
                                'mutual_funds' => 'bg-amber-100 text-amber-800 border-amber-300',
                                'basics' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
                                'news' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
                                default => 'bg-gray-100 text-gray-800 border-gray-300',
                            };
                        @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $categoryStyle }}">
                            {{ str_replace('_', ' ', ucfirst($post->category->value ?? $post->category)) }}
                        </span>

                        <!-- Moderation Delete Post Button -->
                        @if(auth()->user()?->can('post.moderate'))
                            <button type="button" wire:click="deletePost({{ $post->id }})"
                                wire:confirm="Are you sure you want to delete this post and all its comments?"
                                class="p-1 text-gray-400 hover:text-red-600 rounded transition-colors hover:bg-red-50"
                                title="Delete Post (Moderator)">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Post Content Body -->
                <div class="text-gray-800 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                    {{ $post->body }}
                </div>

                <!-- Post Actions Footer -->
                <div class="pt-2 border-t border-gray-100 flex items-center gap-6">
                    <!-- Reaction Button -->
                    @php
                        $hasReacted = $post->reactions->isNotEmpty();
                    @endphp
                    <button type="button" wire:click="toggleReaction({{ $post->id }})"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium transition-all duration-200 {{ $hasReacted ? 'text-red-600 font-semibold' : 'text-finpulse-gray hover:text-red-500' }}"
                        title="React to post">
                        <svg class="w-4 h-4 {{ $hasReacted ? 'fill-current text-red-600' : 'fill-none stroke-current' }} {{ $hasReacted ? 'fp-react-pop' : '' }}"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.293l.318-.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                        </svg>
                        <span>{{ $post->reactions_count }}</span>
                    </button>

                    <!-- Comments Button -->
                    <button type="button" wire:click="toggleComments({{ $post->id }})"
                        class="inline-flex items-center gap-1.5 text-xs sm:text-sm font-medium text-finpulse-gray hover:text-finpulse-navy transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <span>{{ $post->comments_count }} {{ Str::plural('Comment', $post->comments_count) }}</span>
                    </button>
                </div>

                <!-- Expandable Comments Thread -->
                @if(in_array($post->id, $openComments))
                    <div class="mt-4 pt-4 border-t border-gray-100 space-y-3 bg-gray-50/50 rounded-lg p-4 fp-page-enter">
                        <h3 class="text-xs font-bold text-finpulse-navy uppercase tracking-wider">Comments</h3>

                        <!-- Existing Comments List (Chronological: Oldest First) -->
                        <div class="space-y-3">
                            @forelse($post->comments as $comment)
                                <div
                                    class="bg-white rounded-lg p-3 border border-gray-200 text-xs sm:text-sm space-y-1 hover:shadow-sm transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="font-semibold text-gray-900">{{ $comment->user->name ?? 'User' }}</span>

                                            <!-- Commenter Earned Badges -->
                                            @if($comment->user && $comment->user->badges->isNotEmpty())
                                                @foreach($comment->user->badges as $badge)
                                                    <span
                                                        class="inline-flex items-center gap-1 text-[10px] font-semibold px-1.5 py-0.2 rounded-full bg-amber-100 text-amber-900 border border-amber-200">
                                                        🏆 {{ $badge->name }}
                                                    </span>
                                                @endforeach
                                            @endif

                                            <span
                                                class="text-[11px] text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>

                                        <!-- Moderation Delete Comment Button -->
                                        @if(auth()->user()?->can('post.moderate'))
                                            <button type="button" wire:click="deleteComment({{ $comment->id }})"
                                                wire:confirm="Are you sure you want to delete this comment?"
                                                class="text-gray-400 hover:text-red-600 p-0.5 rounded transition-colors hover:bg-red-50"
                                                title="Delete Comment (Moderator)">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $comment->body }}</p>
                                </div>
                            @empty
                                <p class="text-xs text-gray-500 italic">No comments yet. Be the first to reply!</p>
                            @endforelse
                        </div>

                        <!-- Add Comment Form (Visible if user has post.comment permission) -->
                        @if(auth()->user()?->can('post.comment'))
                            <form wire:submit="addComment({{ $post->id }})" class="mt-3 flex gap-2">
                                <input type="text" wire:model="commentBody.{{ $post->id }}" placeholder="Write a comment..."
                                    class="flex-1 rounded-lg border-gray-300 text-xs sm:text-sm focus:border-finpulse-navy focus:ring-finpulse-navy transition-colors" />
                                <button type="submit"
                                    class="px-4 py-2 bg-finpulse-navy hover:bg-[#C89B3C] text-white hover:text-finpulse-navy font-semibold text-xs sm:text-sm rounded-lg transition-all duration-300 shadow-sm shrink-0 hover:shadow-md">
                                    Reply
                                </button>
                            </form>
                            @error("commentBody.{$post->id}")
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="bg-white rounded-xl p-8 text-center border border-gray-200 space-y-2 fp-animate-in">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
                <p class="text-base font-semibold text-finpulse-navy">No posts found</p>
                <p class="text-sm text-gray-500">There are no updates in this category yet. Be the first to share one!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="pt-4">
        {{ $posts->links() }}
    </div>
</div>