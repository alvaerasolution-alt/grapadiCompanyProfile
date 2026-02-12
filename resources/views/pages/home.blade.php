@extends('layouts.app')

@section('title', 'Home - Grapadi')
@section('description', 'Market Intelligence & Consulting - Be The Top 1% Businesses')

@section('content')
    {{-- Hero Section --}}
    <x-hero-section 
        :title="$hero['title']"
        :subtitle="$hero['subtitle']"
        :showLogo="$hero['show_logo']"
        :ctaText="$hero['cta_text']"
        :ctaUrl="$hero['cta_url']"
        :showClientLogos="false"
        :stats="$hero['stats']"
    />

    
    {{-- About Us / Director Section --}}
    <section class="bg-surface-light dark:bg-surface-dark py-20">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div class="order-2 lg:order-2 relative h-[500px] rounded-2xl overflow-hidden shadow-lg group" data-animate="fade-in-right" data-delay="200">
                @php
                $directorImage = $director['image'];
                    if ($directorImage && !str_starts_with($directorImage, 'http')) {
                        $directorImageUrl = str_starts_with($directorImage, 'image/') 
                            ? asset($directorImage) 
                            : asset('storage/' . $directorImage);
                        } else {
                        $directorImageUrl = $directorImage;
                    }
                    @endphp
                <img alt="{{ $director['name'] }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-500" src="{{ $directorImageUrl }}">
                <div class="absolute inset-0 bg-navy-brand/0"></div>
            </div>
            <div class="order-1 lg:order-1" data-animate="fade-in-left">
                <h3 class="text-xl font-bold text-gray-600 dark:text-gray-400 mb-2">
                    {{ $director['title'] }}
                </h3>
                <h2 class="text-3xl md:text-4xl font-bold font-display text-navy-brand dark:text-white mb-4">
                    {{ $director['name'] }}
                </h2>
                
                @if($director['linkedin'])
                <div class="mb-6">
                    <a href="{{ $director['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="text-[#0077b5] hover:text-[#005582] transition">
                        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>
                </div>
                @endif
                
                <p class="text-gray-600 dark:text-gray-300 mb-6 leading-relaxed text-lg">
                    {{ $director['description'] }}
                </p>
            </div>
        </div>
    </section>
    
    
    {{-- Services Section --}}
    <section class="py-20 bg-surface-light dark:bg-background-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 max-w-3xl mx-auto" data-animate="fade-in-up">
                <h2 class="text-3xl md:text-4xl font-bold font-display text-gray-900 dark:text-white mb-4">
                    {{ $servicesSection['title'] }}
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($services as $index => $service)
                <div data-animate="fade-in-up" data-delay="{{ $index * 100 }}">
                <x-service-card 
                :icon="$service->icon_url ?? 'analytics'"
                :title="$service->service_name"
                :description="$service->description ?? ''"
                    :link="'/services/' . $service->slug"
                    />
                </div>
                @endforeach
            </div>
            
            {{-- CTA Card - Centered --}}
            <div class="mt-8 flex justify-center" data-animate="scale-in" data-delay="400">
                <div class="bg-primary p-8 rounded shadow-lg flex flex-col justify-center items-center text-white relative overflow-hidden group max-w-md w-full">
                    <div class="absolute inset-0 bg-primary-700 opacity-0 group-hover:opacity-20 transition duration-300"></div>
                    <h3 class="text-2xl font-bold font-display mb-4 relative z-10 text-center">
                        {{ $servicesSection['cta_title'] }}
                    </h3>
                    <div class="flex flex-col sm:flex-row gap-3 relative z-10">
                        <a class="bg-white text-primary font-bold py-3 px-6 rounded inline-flex items-center gap-2 hover:bg-gray-100 transition" href="{{ $servicesSection['cta_url'] }}">
                            {{ $servicesSection['cta_text'] }}
                            <span class="material-icons-outlined">arrow_forward</span>
                        </a>
                </div>
            </div>
        </div>
    </section>
    
    {{-- Software Bisnis Plan Section --}}
    @if($softwareBisnisPlan['is_active'])
    <x-software-bisnis-plan 
    :tagline="$softwareBisnisPlan['tagline']"
    :title="$softwareBisnisPlan['title']"
    :highlightedTitle="$softwareBisnisPlan['highlighted_title']"
        :description="$softwareBisnisPlan['description']"
        :callout="$softwareBisnisPlan['callout']"
        :primaryButtonText="$softwareBisnisPlan['primary_button_text']"
        :primaryButtonUrl="$softwareBisnisPlan['primary_button_url']"
        :secondaryButtonText="$softwareBisnisPlan['secondary_button_text']"
        :secondaryButtonUrl="$softwareBisnisPlan['secondary_button_url']"
        :image="$softwareBisnisPlan['image']"
        :imageAlt="$softwareBisnisPlan['image_alt']"
        :showLaptopFrame="$softwareBisnisPlan['show_laptop_frame']"
    />
    @endif

    {{-- Client Logos --}}
    <x-client-logos title="Trusted By" :brands="$trustedBrands" />
    <x-client-logos title="Media Covered" :brands="$mediaBrands" direction="right" />
    
    {{-- Quote Section --}}
    @php
        $quoteBackground = $quote['background'];
        if ($quoteBackground && !str_starts_with($quoteBackground, 'http')) {
            $quoteBackground = asset('storage/' . $quoteBackground);
        }
    @endphp
    <x-quote-section 
        :quote="$quote['text']"
        :backgroundImage="$quoteBackground"
    />
    {{-- Insights Section --}}
    <section class="py-20 bg-surface-light dark:bg-surface-dark">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16" data-animate="fade-in-up">
                <h2 class="text-3xl md:text-4xl font-bold font-display text-gray-900 dark:text-white">
                    {{ $insightsSection['title'] }}
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $index => $article)
                <div data-animate="fade-in-up" data-delay="{{ $index * 150 }}">
                <x-article-card 
                    :title="$article->title"
                    :image="$article->image_display"
                    :date="$article->created_at->format('F d, Y')"
                    :link="route('blog.show', $article->slug)"
                />
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <x-cta-section 
        :title="$ctaSection['title']"
        :description="$ctaSection['description']"
        :primaryText="$ctaSection['primary_text']"
        :primaryUrl="$ctaSection['primary_url']"
        :secondaryText="$ctaSection['secondary_text']"
        :secondaryUrl="$ctaSection['secondary_url']"
        background="navy"
    />
@endsection

@push('styles')
<style>
    .scrolling-wrapper::-webkit-scrollbar {
        display: none;
    }
    .scrolling-wrapper {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endpush
