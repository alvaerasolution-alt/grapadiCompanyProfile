@props([
    'title' => 'Grapadi Konsultan Indonesia',
    'subtitle' => 'Where Data Meets Insight',
    'ctaText' => null,
    'ctaUrl' => '#',
    'backgroundImage' => null,
    'showLogo' => true,
    'stats' => [],
    'showClientLogos' => false,
    'clientLogos' => [],
    'clientLogosTitle' => 'Trusted By Leading Brands',
    'clientLogosTitle2' => 'Our Technology Partners'
])

>
    {{-- Background Image (LCP Optimized) --}}
    @if($backgroundImage)
    <img src="{{ $backgroundImage }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover" fetchpriority="high" loading="eager">
    @else
    <img src="{{ asset('image/background/image.png') }}" alt="Hero Background" class="absolute inset-0 w-full h-full object-cover" fetchpriority="high" loading="eager">
    @endif
    
    {{-- Gradient Overlay --}}
    <div class="absolute inset-0" style="background: linear-gradient(180deg, rgba(60, 97, 66, 0.9) 0%, rgba(0, 0, 0, 0.85) 80%);"></div>
    {{-- Main Content - Centered --}}
    <div class="flex-1 flex items-center justify-center">
        <div class="max-w-5xl mx-auto px-4 text-center relative z-10">
            {{-- Logo --}}
            @if($showLogo)
            <div class="flex justify-center mb-8 pt-8">
                <img 
                    src="{{ asset('image/logo/image.png') }}" 
                    alt="Grapadi Logo" 
                    class="w-44 h-44 md:w-56 md:h-56 lg:w-64 lg:h-64 object-contain"
                    width="256"
                    height="256"
                    fetchpriority="high"
                >
            </div>
            @endif

            {{-- Title --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-display leading-tight mb-6 text-white">
                {!! $title !!}
            </h1>
            
            {{-- Tagline/Subtitle --}}
            @if($subtitle)
            <p class="text-xl md:text-2xl text-gray-300 mb-8">{{ $subtitle }}</p>
            @endif

            @if($ctaText)
            <div class="flex justify-center">
                <a class="bg-primary hover:bg-primary-800 text-white font-bold py-4 px-10 rounded flex items-center gap-2 transition shadow-lg text-xl mb-8" href="{{ $ctaUrl }}">
                    {{ $ctaText }}
                    <span class="material-icons-outlined">arrow_forward</span>
                </a>
            </div>
            @endif
        </div>
    </div>
    {{-- Stats --}}
    @if(count($stats) > 0)
    <div class="w-full px-4 pb-8">
        <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-gray-700 pt-8 text-center">
            @foreach($stats as $stat)
            <div class="flex flex-col items-center">
                @if(isset($stat['icon']))
                <span class="material-icons-outlined text-5xl mb-3 text-white/80">{{ $stat['icon'] }}</span>
                @endif
                <p class="text-base text-gray-300">{!! $stat['label'] !!}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif


    {{-- Client Logos --}}
    @if($showClientLogos)
    <div class="w-full py-8 border-t border-gray-700/50">
        @if($clientLogosTitle)
        <p class="text-center text-base text-gray-400 mb-6 uppercase tracking-wider">{{ $clientLogosTitle }}</p>
        @endif
        
        {{-- Row 1 - Scroll Left --}}
        <div class="relative overflow-hidden mb-4">
            <div class="flex animate-scroll-hero">
                <div class="flex items-center gap-16 px-8 shrink-0">
                    <img alt="Google" class="h-8 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg">
                    <img alt="Microsoft" class="h-6 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg">
                    <img alt="Amazon" class="h-7 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg">
                    <img alt="Meta" class="h-6 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Meta_Platforms_Inc._logo.svg">
                    <img alt="Apple" class="h-8 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg">
                    <img alt="Netflix" class="h-6 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg">
                </div>
                <div class="flex items-center gap-16 px-8 shrink-0">
                    <img alt="Google" class="h-8 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/2/2f/Google_2015_logo.svg">
                    <img alt="Microsoft" class="h-6 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/9/96/Microsoft_logo_%282012%29.svg">
                    <img alt="Amazon" class="h-7 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/a/a9/Amazon_logo.svg">
                    <img alt="Meta" class="h-6 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/7/7b/Meta_Platforms_Inc._logo.svg">
                    <img alt="Apple" class="h-8 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg">
                    <img alt="Netflix" class="h-6 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/0/08/Netflix_2015_logo.svg">
                </div>
            </div>
        </div>
        
        {{-- Row 2 - Scroll Right --}}
        @if($clientLogosTitle2)
        <p class="text-center text-base text-gray-400 mb-4 mt-6 uppercase tracking-wider">{{ $clientLogosTitle2 }}</p>
        @endif
        <div class="relative overflow-hidden">
            <div class="flex animate-scroll-hero-reverse">
                <div class="flex items-center gap-16 px-8 shrink-0">
                    <img alt="Spotify" class="h-7 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg">
                    <img alt="IBM" class="h-8 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg">
                    <img alt="Oracle" class="h-6 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/5/50/Oracle_logo.svg">
                    <img alt="SAP" class="h-7 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/5/59/SAP_2011_logo.svg">
                    <img alt="Adobe" class="h-7 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/8/8d/Adobe_Corporate_Logo.svg">
                    <img alt="Intel" class="h-8 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/7/7d/Intel_logo_%282006-2020%29.svg">
                </div>
                <div class="flex items-center gap-16 px-8 shrink-0">
                    <img alt="Spotify" class="h-7 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/1/19/Spotify_logo_without_text.svg">
                    <img alt="IBM" class="h-8 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/5/51/IBM_logo.svg">
                    <img alt="Oracle" class="h-6 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/5/50/Oracle_logo.svg">
                    <img alt="SAP" class="h-7 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/5/59/SAP_2011_logo.svg">
                    <img alt="Adobe" class="h-7 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/8/8d/Adobe_Corporate_Logo.svg">
                    <img alt="Intel" class="h-8 object-contain brightness-0 invert opacity-70" src="https://upload.wikimedia.org/wikipedia/commons/7/7d/Intel_logo_%282006-2020%29.svg">
                </div>
            </div>
        </div>
    </div>
    @endif
</section>

@push('styles')
<style>
    @keyframes scroll-hero {
        0% { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    @keyframes scroll-hero-reverse {
        0% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }
    .animate-scroll-hero {
        animation: scroll-hero 20s linear infinite;
    }
    .animate-scroll-hero-reverse {
        animation: scroll-hero-reverse 20s linear infinite;
    }
    .animate-scroll-hero:hover,
    .animate-scroll-hero-reverse:hover {
        animation-play-state: paused;
    }
</style>
@endpush
