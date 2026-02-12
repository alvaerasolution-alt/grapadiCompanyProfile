@props([
    'title' => 'Ready to work with us?',
    'description' => '',
    'primaryText' => 'Contact Us',
    'primaryUrl' => '/contact',
    'secondaryText' => null,
    'secondaryUrl' => '#',
    'showWhatsapp' => true,
    'background' => 'navy' // navy, primary, white
])

@php
$bgClasses = match($background) {
    'navy' => 'bg-navy-brand text-white',
    'primary' => 'bg-primary text-white',
    'white' => 'bg-white dark:bg-background-dark text-gray-900 dark:text-white',
    default => 'bg-navy-brand text-white'
};
@endphp

<section class="{{ $bgClasses }} py-20">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-5xl font-bold font-display mb-6">
            {{ $title }}
        </h2>
        @if($description)
        <p class="@if($background == 'white') text-gray-600 dark:text-gray-400 @else text-gray-300 @endif mb-10 text-xl">
            {{ $description }}
        </p>
        @endif
        <div class="flex flex-col sm:flex-row justify-center gap-4">
            @if($showWhatsapp)
            <x-whatsapp-cta style="inline" text="Chat WhatsApp" />
            @endif
            @if($secondaryText)
            <a class="bg-transparent border @if($background == 'white') border-gray-300 text-gray-700 hover:bg-gray-100 @else border-white hover:bg-white hover:text-navy-brand text-white @endif font-bold py-3 px-8 rounded shadow-lg transition flex items-center justify-center gap-2" href="{{ $secondaryUrl }}">
                {{ $secondaryText }}
            </a>
            @endif
        </div>
    </div>
</section>

