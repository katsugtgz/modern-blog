@extends('layouts.app')

@section('title', 'Home')

@section('content')
    @php($lead = $latestPosts->first())

    {{-- Masthead / lead story --}}
    <section class="border-b border-ink/10 bg-paper">
        <div class="mx-auto max-w-6xl px-4 pt-14 pb-16 sm:px-6 lg:px-8 lg:pt-20">
            <div class="grid items-end gap-12 lg:grid-cols-[minmax(0,5fr)_minmax(0,6fr)]">
                <div>
                    <h1 class="font-serif text-5xl leading-[1.05] tracking-tight text-ink sm:text-6xl lg:text-7xl">
                        Writing worth<em class="not-italic text-forest"> your</em> morning.
                    </h1>
                    <p class="mt-6 max-w-[52ch] text-lg leading-relaxed text-ink/70">
                        Discover insightful articles, tutorials, and stories from our community of writers.
                    </p>
                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <a href="{{ route('posts.index') }}"
                           class="inline-flex items-center bg-forest px-6 py-3 text-base font-medium text-paper transition-colors hover:bg-forest-deep">
                            Explore Blog
                        </a>
                        @guest
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center border-b-2 border-forest px-1 py-2 text-base font-medium text-forest transition-colors hover:border-ink hover:text-ink">
                                Join the Community
                            </a>
                        @endguest
                    </div>
                </div>

                @if($lead)
                    <article>
                        <a href="{{ route('posts.show', $lead->slug) }}" class="block">
                            <div class="aspect-[16/10] overflow-clip bg-ink/5">
                                <img class="h-full w-full object-cover"
                                     src="{{ $lead->featured_image ? asset('storage/' . $lead->featured_image) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=70' }}"
                                     alt="{{ $lead->title }}" width="1200" height="750"
                                     fetchpriority="high" decoding="async">
                            </div>
                        </a>
                        <div class="mt-5 flex items-baseline justify-between gap-4 border-t border-ink/15 pt-4 text-sm text-ink/60">
                            <span class="font-medium text-forest">{{ $lead->category->name }}</span>
                            <time datetime="{{ $lead->published_at->toDateTimeString() }}">{{ $lead->published_at->format('F j, Y') }}</time>
                        </div>
                        <a href="{{ route('posts.show', $lead->slug) }}" class="block">
                            <h2 class="mt-2 font-serif text-3xl leading-snug text-ink sm:text-4xl">
                                {{ $lead->title }}
                            </h2>
                            <p class="mt-3 max-w-[60ch] leading-relaxed text-ink/70">
                                {{ $lead->excerpt ?? Str::limit(strip_tags($lead->content), 180) }}
                            </p>
                            <p class="mt-4 text-sm text-ink/60">
                                By <span class="font-medium text-ink">{{ $lead->user->name }}</span>
                            </p>
                        </a>
                    </article>
                @endif
            </div>
        </div>
    </section>

    {{-- Latest posts: editorial columns, hairline rules --}}
    <section class="cv-auto border-b border-ink/10 bg-paper-raised">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-baseline justify-between gap-4 border-b-2 border-ink pb-4">
                <h2 class="font-serif text-3xl text-ink sm:text-4xl">Fresh content for you</h2>
                <a href="{{ route('posts.index') }}" class="text-sm font-medium text-forest underline-offset-4 hover:text-ink hover:underline">
                    View all posts
                </a>
            </div>

            <div class="mt-10 grid gap-x-10 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($latestPosts->skip(1) as $post)
                    <article class="flex flex-col border-t border-ink/15 pt-5">
                        <div class="mb-3 overflow-clip bg-ink/5">
                            <img class="aspect-[3/2] w-full object-cover transition-transform duration-500 ease-out hover:scale-[1.03] motion-reduce:transition-none"
                                 src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=60' }}"
                                 alt="{{ $post->title }}" width="800" height="533"
                                 loading="lazy" decoding="async">
                        </div>
                        <div class="flex items-baseline justify-between gap-3 text-sm text-ink/60">
                            <span class="font-medium text-forest">{{ $post->category->name }}</span>
                            <time datetime="{{ $post->published_at->toDateTimeString() }}">{{ $post->published_at->format('M d, Y') }}</time>
                        </div>
                        <a href="{{ route('posts.show', $post->slug) }}" class="mt-2">
                            <h3 class="font-serif text-xl leading-snug text-ink underline-offset-4 hover:text-forest hover:underline">
                                {{ $post->title }}
                            </h3>
                        </a>
                        <p class="mt-2 text-sm leading-relaxed text-ink/70">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 140) }}
                        </p>
                        <p class="mt-auto pt-4 text-sm text-ink/60">
                            By <span class="font-medium text-ink">{{ $post->user->name }}</span>
                        </p>
                    </article>
                @empty
                    <p class="col-span-full py-12 text-center text-ink/60">No posts found. Check back soon!</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Popular: ranked by views, so the numerals are a real sequence --}}
    <section class="cv-auto border-b border-ink/10 bg-paper">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="border-b-2 border-ink pb-4">
                <h2 class="font-serif text-3xl text-ink sm:text-4xl">Community favorites</h2>
            </div>

            <ol class="mt-2 divide-y divide-ink/10">
                @forelse($popularPosts as $i => $post)
                    <li>
                        <a href="{{ route('posts.show', $post->slug) }}"
                           class="group grid grid-cols-[auto_minmax(0,1fr)] items-baseline gap-x-5 py-6 sm:grid-cols-[auto_minmax(0,1fr)_auto]">
                            <span class="font-serif text-3xl leading-none text-forest/90 tabular-nums" aria-hidden="true">{{ sprintf('%02d', $i + 1) }}</span>
                            <span>
                                <span class="block font-serif text-2xl leading-snug text-ink underline-offset-4 group-hover:text-forest group-hover:underline">
                                    {{ $post->title }}
                                </span>
                                <span class="mt-2 block max-w-[70ch] text-sm leading-relaxed text-ink/70">
                                    {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}
                                </span>
                                <span class="mt-2 block text-sm text-ink/60">
                                    {{ $post->category->name }} &middot; {{ $post->published_at->format('M d, Y') }} &middot; by {{ $post->user->name }}
                                </span>
                            </span>
                            <span class="col-start-2 mt-3 text-sm text-ink/50 sm:col-start-3 sm:mt-0 sm:justify-self-end sm:text-right">
                                {{ number_format($post->view_count) }} views
                            </span>
                        </a>
                    </li>
                @empty
                    <li class="py-12 text-center text-ink/60">Nothing popular yet. Be the first reader!</li>
                @endforelse
            </ol>
        </div>
    </section>

    {{-- Browse by category and tag --}}
    <section class="cv-auto border-b border-ink/10 bg-paper-raised">
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="border-b-2 border-ink pb-4">
                <h2 class="font-serif text-3xl text-ink sm:text-4xl">Browse by</h2>
            </div>

            <div class="mt-8 grid gap-12 md:grid-cols-2">
                <div>
                    <h3 class="text-sm font-medium text-ink/60">Popular categories</h3>
                    <ul class="mt-4 divide-y divide-ink/10">
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('categories.show', $category->slug) }}"
                                   class="flex items-baseline justify-between gap-4 py-3 text-ink underline-offset-4 hover:text-forest hover:underline">
                                    <span class="font-serif text-lg">{{ $category->name }}</span>
                                    <span class="text-sm text-ink/50 tabular-nums">{{ $category->posts_count }} posts</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-ink/60">Popular tags</h3>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <a href="{{ route('tags.show', $tag->slug) }}"
                               class="border border-ink/20 px-3 py-1.5 text-sm text-ink/80 transition-colors hover:border-forest hover:text-forest">
                                #{{ $tag->name }} <span class="text-ink/40 tabular-nums">{{ $tag->posts_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Closing call to action --}}
    <section class="bg-forest">
        <div class="mx-auto flex max-w-6xl flex-col gap-8 px-4 py-16 sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
            <h2 class="max-w-[24ch] font-serif text-3xl leading-tight text-paper sm:text-4xl">
                Ready to dive in? Start your blogging journey today.
            </h2>
            <div class="flex flex-wrap gap-4">
                @guest
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center bg-paper px-6 py-3 text-base font-medium text-ink transition-colors hover:bg-white">
                        Create an Account
                    </a>
                @else
                    <a href="{{ route('posts.create') }}"
                       class="inline-flex items-center bg-paper px-6 py-3 text-base font-medium text-ink transition-colors hover:bg-white">
                        Create a Post
                    </a>
                @endguest
                <a href="{{ route('posts.index') }}"
                   class="inline-flex items-center border border-paper/40 px-6 py-3 text-base font-medium text-paper transition-colors hover:border-paper hover:bg-forest-deep">
                    Explore Posts
                </a>
            </div>
        </div>
    </section>
@endsection
