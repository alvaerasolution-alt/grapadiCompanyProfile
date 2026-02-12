@props([
    'title' => 'Article Title',
    'image' => null,
    'date' => null,
    'link' => '#',
    'category' => null,
    'categorySlug' => null,
    'excerpt' => null,
    'readingTime' => null,
    'viewsCount' => null,
])

<article class="bg-white dark:bg-background-dark rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col">
    <div class="h-48 overflow-hidden relative">
        @if($image)
        <img alt="{{ $title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500" src="{{ $image }}">
        @else
        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
            <span class="material-icons-outlined text-4xl text-gray-400">article</span>
        </div>
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        @if($category)
        @if($categorySlug)
        <a href="{{ route('blog', ['category' => $categorySlug]) }}" class="absolute top-3 left-3 bg-primary hover:bg-primary-800 text-white text-xs font-bold px-2 py-1 rounded transition">
            {{ $category }}
        </a>
        @else
        <span class="absolute top-3 left-3 bg-primary text-white text-xs font-bold px-2 py-1 rounded">{{ $category }}</span>
        @endif
        @endif
    </div>
    <div class="p-5 flex flex-col flex-grow">
        <a href="{{ $link }}">
            <h3 class="font-bold text-lg mb-2 text-gray-900 dark:text-white line-clamp-2 hover:text-primary transition">
                {{ $title }}
            </h3>
        </a>
        
        @if($excerpt)
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2 flex-grow">
            {{ $excerpt }}
        </p>
        @endif

        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400 mt-auto pt-4 border-t border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                @if($date)
                <span class="flex items-center gap-1">
                    <span class="material-icons-outlined text-sm">calendar_today</span>
                    {{ $date }}
                </span>
                @endif
            </div>
            <div class="flex items-center gap-3">
                @if($readingTime)
                <span class="flex items-center gap-1">
                    <span class="material-icons-outlined text-sm">schedule</span>
                    {{ $readingTime }} min
                </span>
                @endif
                @if($viewsCount !== null && $viewsCount > 0)
                <span class="flex items-center gap-1">
                    <span class="material-icons-outlined text-sm">visibility</span>
                    {{ number_format($viewsCount) }}
                </span>
                @endif
            </div>
        </div>
    </div>
</article>
