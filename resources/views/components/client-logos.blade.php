@props([
    'brands' => collect([]),
    'title' => 'Trusted By',
    'direction' => 'left',
    'speed' => 5,
])

@php
    // Default logos to show when no brands in database
    $defaultLogos = [
        ['name' => 'Google', 'url' => 'https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg', 'height' => 'h-8'],
        ['name' => 'Microsoft', 'url' => 'https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg', 'height' => 'h-6'],
        ['name' => 'Amazon', 'url' => 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg', 'height' => 'h-7'],
        ['name' => 'Meta', 'url' => 'https://upload.wikimedia.org/wikipedia/commons/7/7b/Meta_Platforms_Inc._logo.svg', 'height' => 'h-6'],
        ['name' => 'Apple', 'url' => 'https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg', 'height' => 'h-8'],
        ['name' => 'Netflix', 'url' => 'https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg', 'height' => 'h-6'],
    ];
    
    $hasBrands = $brands && $brands->count() > 0;
    
    // Helper function to get logo URL
    $getLogoUrl = function($brand) {
        if (!empty($brand->logo)) {
            if (str_starts_with($brand->logo, 'http')) {
                return $brand->logo;
            }
            return asset('storage/' . $brand->logo);
        }
        return null;
    };
@endphp

<div class="bg-white dark:bg-surface-dark py-12 border-b border-gray-200 dark:border-gray-800 overflow-hidden">
    {{-- Title --}}
    @if($title)
    <p class="text-center text-sm text-gray-500 dark:text-gray-400 mb-8 uppercase tracking-wider font-medium">{{ $title }}</p>
    @endif
    
    <div class="relative {{ $direction === 'static' ? '' : 'overflow-hidden' }}">
        <div class="flex {{ $direction === 'static' ? 'flex-wrap justify-center' : ($direction === 'right' ? 'animate-scroll-reverse' : 'animate-scroll') }}">
            {{-- First set --}}
            <div class="flex items-center gap-16 px-8 shrink-0">
                @if($hasBrands)
                    @foreach($brands as $brand)
                        @php $logoUrl = $getLogoUrl($brand); @endphp
                        @if($logoUrl)
                            @if($brand->url)
                                <a href="{{ $brand->url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-28 h-16">
                                    <img 
                                        alt="{{ $brand->name }}" 
                                        class="max-h-full max-w-full object-contain opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300" 
                                        src="{{ $logoUrl }}"
                                    >
                                </a>
                            @else
                                <div class="flex items-center justify-center w-28 h-16">
                                    <img 
                                        alt="{{ $brand->name }}" 
                                        class="max-h-full max-w-full object-contain opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300" 
                                        src="{{ $logoUrl }}"
                                    >
                                </div>
                            @endif
                        @endif
                    @endforeach
                @else
                    @foreach($defaultLogos as $logo)
                        <img 
                            alt="{{ $logo['name'] }}" 
                            class="{{ $logo['height'] }} object-contain opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300" 
                            src="{{ $logo['url'] }}"
                        >
                    @endforeach
                @endif
            </div>
            
            {{-- Duplicate for seamless scroll (hidden when static) --}}
            @if($direction !== 'static')
            <div class="flex items-center gap-16 px-8 shrink-0">
                @if($hasBrands)
                    @foreach($brands as $brand)
                        @php $logoUrl = $getLogoUrl($brand); @endphp
                        @if($logoUrl)
                            @if($brand->url)
                                <a href="{{ $brand->url }}" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center w-28 h-16">
                                    <img 
                                        alt="{{ $brand->name }}" 
                                        class="max-h-full max-w-full object-contain opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300" 
                                        src="{{ $logoUrl }}"
                                    >
                                </a>
                            @else
                                <div class="flex items-center justify-center w-28 h-16">
                                    <img 
                                        alt="{{ $brand->name }}" 
                                        class="max-h-full max-w-full object-contain opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300" 
                                        src="{{ $logoUrl }}"
                                    >
                                </div>
                            @endif
                        @endif
                    @endforeach
                @else
                    @foreach($defaultLogos as $logo)
                        <img 
                            alt="{{ $logo['name'] }}" 
                            class="{{ $logo['height'] }} object-contain opacity-60 grayscale hover:grayscale-0 hover:opacity-100 transition-all duration-300" 
                            src="{{ $logo['url'] }}"
                        >
                    @endforeach
                @endif
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes scroll {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    @keyframes scroll-reverse {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }
    .animate-scroll {
        animation: scroll {{ $speed }}s linear infinite;
    }
    .animate-scroll-reverse {
        animation: scroll-reverse {{ $speed }}s linear infinite;
    }
    .animate-scroll:hover,
    .animate-scroll-reverse:hover {
        animation-play-state: paused;
    }
</style>
@endpush
