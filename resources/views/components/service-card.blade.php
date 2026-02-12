@props([
    'icon' => 'analytics',
    'title' => 'Service Title',
    'description' => '',
    'link' => '#',
    'linkText' => 'Explore'
])

<div class="bg-white dark:bg-surface-dark p-8 rounded border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition">
    <div class="w-14 h-14 bg-primary-50 dark:bg-gray-800 rounded-lg flex items-center justify-center mb-6 text-primary">
        <span class="material-icons-outlined text-4xl">{{ $icon }}</span>
    </div>
    <h3 class="text-xl font-bold font-display text-gray-900 dark:text-white mb-3">
        {{ $title }}
    </h3>
    <p class="text-gray-600 dark:text-gray-400 text-sm mb-6 leading-relaxed">
        {!! Str::limit(strip_tags($description), 150) !!}
    </p>
    <a class="text-primary font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all" href="{{ $link }}">
        {{ $linkText }}
        <span class="material-icons-outlined text-sm">arrow_forward</span>
    </a>
</div>
