@php
$isHome = Request::is('/');
$currentRoute = Request::path();

// Get site settings
$companyName = site_setting('site_company_name');
$logo = site_setting('site_logo');
$logoDark = site_setting('site_logo_dark');
$logoOnly = site_setting('site_logo_only', false);
@endphp

<nav 
    x-data="{ 
        scrolled: false, 
        mobileMenuOpen: false,
        isHome: {{ $isHome ? 'true' : 'false' }},
        get isTransparent() { return this.isHome && !this.scrolled; }
    }"
    @scroll.window="scrolled = (window.pageYOffset > 20)"
    :class="isTransparent ? 'bg-transparent border-transparent' : 'bg-white dark:bg-background-dark border-b border-gray-200 dark:border-gray-800 shadow-sm'"
    class="fixed top-0 w-full z-50 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-8">
                <a class="flex-shrink-0 flex items-center gap-2" href="{{ url('/') }}">
                    @if($logo)
                    <div 
                        :class="isTransparent ? '' : 'bg-[#228B22]'"
                        class="p-2 rounded transition-all duration-300"
                    >
                        {{-- Use dark logo on transparent background if available --}}
                        <img 
                            x-show="!isTransparent || !{{ $logoDark ? 'true' : 'false' }}"
                            src="{{ $logo ? (str_starts_with($logo, 'http') ? $logo : asset('storage/' . $logo)) : asset('image/logo/image.png') }}" 
                            alt="{{ $companyName }} Logo"
                            class="h-8 w-auto"
                        >
                        @if($logoDark)
                        <img 
                            x-show="isTransparent"
                            x-cloak
                            src="{{ str_starts_with($logoDark, 'http') ? $logoDark : asset('storage/' . $logoDark) }}" 
                            alt="{{ $companyName }} Logo"
                            class="h-8 w-auto"
                        >
                        @endif
                    </div>
                    @if(!$logoOnly)
                    <span 
                        :class="isTransparent ? 'text-white' : 'text-gray-900 dark:text-white'"
                        class="font-bold text-lg font-display transition-colors duration-300"
                    >
                        {{ $companyName }}
                    </span>
                    @endif
                    @else
                    {{-- Fallback to default logo --}}
                    <div 
                        :class="isTransparent ? '' : 'bg-[#228B22]'"
                        class="p-2 rounded transition-all duration-300"
                    >
                        <img 
                            src="{{ asset('image/logo/image.png') }}" 
                            alt="{{ $companyName }} Logo"
                            class="h-8 w-auto"
                        >
                    </div>
                    @if(!$logoOnly)
                    <span 
                        :class="isTransparent ? 'text-white' : 'text-gray-900 dark:text-white'"
                        class="font-bold text-lg font-display transition-colors duration-300"
                    >
                        {{ $companyName }}
                    </span>
                    @endif
                    @endif
                </a>
                <div class="hidden md:flex space-x-6 text-sm font-medium">
                    <a 
                        :class="isTransparent ? 'text-white hover:text-gray-200' : 'text-gray-600 dark:text-gray-300 hover:text-primary'"
                        class="flex items-center gap-1 transition-colors duration-300 {{ $currentRoute == '/' ? 'font-semibold' : '' }}" 
                        href="{{ url('/') }}"
                    >
                        Home
                    </a>
                    <div x-data="{ aboutOpen: false }" @mouseenter="aboutOpen = true" @mouseleave="aboutOpen = false" class="relative">
                        <button 
                            :class="isTransparent ? 'text-white hover:text-gray-200' : 'text-gray-600 dark:text-gray-300 hover:text-primary'"
                            class="flex items-center gap-1 transition-colors duration-300 {{ in_array($currentRoute, ['about', 'timeline']) ? 'font-semibold' : '' }}" 
                        >
                            About
                            <span class="material-icons-outlined text-sm transition-transform duration-200" :class="aboutOpen ? 'rotate-180' : ''">expand_more</span>
                        </button>
                        <div 
                            x-show="aboutOpen"
                            x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 -translate-y-1"
                            class="absolute left-0 mt-2 w-44 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg py-1 z-50"
                            x-cloak
                        >
                            <a 
                                class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ $currentRoute == 'about' ? 'font-semibold text-primary' : '' }}" 
                                href="{{ url('/about') }}"
                            >
                                About Us
                            </a>
                            <a 
                                class="block px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ $currentRoute == 'timeline' ? 'font-semibold text-primary' : '' }}" 
                                href="{{ url('/timeline') }}"
                            >
                                Timeline
                            </a>
                        </div>
                    </div>
                    <a 
                        :class="isTransparent ? 'text-white hover:text-gray-200' : 'text-gray-600 dark:text-gray-300 hover:text-primary'"
                        class="flex items-center gap-1 transition-colors duration-300 {{ str_starts_with($currentRoute, 'services') ? 'font-semibold' : '' }}" 
                        href="{{ url('/services') }}"
                    >
                        Services
                    </a>
                    <a 
                        :class="isTransparent ? 'text-white hover:text-gray-200' : 'text-gray-600 dark:text-gray-300 hover:text-primary'"
                        class="flex items-center gap-1 transition-colors duration-300 {{ $currentRoute == 'portfolio' ? 'font-semibold' : '' }}" 
                        href="{{ url('/portfolio') }}"
                    >
                        Portfolio
                    </a>
                    <a 
                        :class="isTransparent ? 'text-white hover:text-gray-200' : 'text-gray-600 dark:text-gray-300 hover:text-primary'"
                        class="flex items-center gap-1 transition-colors duration-300 {{ str_starts_with($currentRoute, 'blog') ? 'font-semibold' : '' }}" 
                        href="{{ url('/blog') }}"
                    >
                        Blog
                    </a>
                    <a 
                        :class="isTransparent ? 'text-white hover:text-gray-200' : 'text-gray-600 dark:text-gray-300 hover:text-primary'"
                        class="flex items-center gap-1 transition-colors duration-300" 
                        href="https://strategix.grapadikonsultan.co.id"
                        target="_blank"
                    >
                        Strategix
                    </a>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-4 text-sm font-medium">
                {{-- Dark Mode Toggle --}}
                <button 
                    x-data="{ 
                        dark: localStorage.getItem('darkMode') === 'true',
                        toggle() {
                            this.dark = !this.dark;
                            localStorage.setItem('darkMode', this.dark);
                            document.documentElement.classList.toggle('dark', this.dark);
                            document.documentElement.classList.toggle('light', !this.dark);
                        }
                    }"
                    x-init="
                        dark = localStorage.getItem('darkMode') === 'true';
                        document.documentElement.classList.toggle('dark', dark);
                        document.documentElement.classList.toggle('light', !dark);
                    "
                    @click="toggle()"
                    :class="isTransparent ? 'text-white hover:text-gray-200' : 'text-gray-600 dark:text-gray-300 hover:text-primary'"
                    class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors duration-300"
                    title="Toggle Dark Mode"
                >
                    <span x-show="!dark" class="material-icons-outlined text-xl">dark_mode</span>
                    <span x-show="dark" class="material-icons-outlined text-xl" x-cloak>light_mode</span>
                </button>
                <a class="bg-primary hover:bg-primary-800 text-white px-4 py-2 rounded shadow-sm transition flex items-center gap-1" href="{{ url('/contact') }}">
                    Contact Us
                    <span class="material-icons-outlined text-sm">north_east</span>
                </a>
            </div>
            <div class="md:hidden flex items-center">
                <button 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    :class="isTransparent ? 'text-white' : 'text-gray-600 dark:text-gray-300'"
                    class="hover:text-primary focus:outline-none transition-colors duration-300"
                >
                    <span x-show="!mobileMenuOpen" class="material-icons-outlined">menu</span>
                    <span x-show="mobileMenuOpen" class="material-icons-outlined" x-cloak>close</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div 
        x-show="mobileMenuOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="md:hidden"
        x-cloak
    >
        <div class="px-4 pt-2 pb-4 space-y-1 bg-white dark:bg-background-dark border-t border-gray-200 dark:border-gray-800 shadow-lg">
            <a class="block py-3 px-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ $currentRoute == '/' ? 'bg-primary/10 text-primary font-semibold' : '' }}" href="{{ url('/') }}">
                <span class="flex items-center gap-3">
                    <span class="material-icons-outlined text-xl">home</span>
                    Home
                </span>
            </a>
            <div x-data="{ aboutMobileOpen: false }">
                <button 
                    @click="aboutMobileOpen = !aboutMobileOpen"
                    class="block w-full py-3 px-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ in_array($currentRoute, ['about', 'timeline']) ? 'bg-primary/10 text-primary font-semibold' : '' }}"
                >
                    <span class="flex items-center gap-3">
                        <span class="material-icons-outlined text-xl">info</span>
                        About
                        <span class="material-icons-outlined text-sm ml-auto transition-transform duration-200" :class="aboutMobileOpen ? 'rotate-180' : ''">expand_more</span>
                    </span>
                </button>
                <div x-show="aboutMobileOpen" x-collapse x-cloak class="pl-10 space-y-1 mt-1">
                    <a class="block py-2 px-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ $currentRoute == 'about' ? 'text-primary font-semibold' : '' }}" href="{{ url('/about') }}">
                        About Us
                    </a>
                    <a class="block py-2 px-3 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ $currentRoute == 'timeline' ? 'text-primary font-semibold' : '' }}" href="{{ url('/timeline') }}">
                        Timeline
                    </a>
                </div>
            </div>
            <a class="block py-3 px-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ str_starts_with($currentRoute, 'services') ? 'bg-primary/10 text-primary font-semibold' : '' }}" href="{{ url('/services') }}">
                <span class="flex items-center gap-3">
                    <span class="material-icons-outlined text-xl">design_services</span>
                    Services
                </span>
            </a>
            <a class="block py-3 px-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ $currentRoute == 'portfolio' ? 'bg-primary/10 text-primary font-semibold' : '' }}" href="{{ url('/portfolio') }}">
                <span class="flex items-center gap-3">
                    <span class="material-icons-outlined text-xl">work</span>
                    Portfolio
                </span>
            </a>
            <a class="block py-3 px-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors {{ str_starts_with($currentRoute, 'blog') ? 'bg-primary/10 text-primary font-semibold' : '' }}" href="{{ url('/blog') }}">
                <span class="flex items-center gap-3">
                    <span class="material-icons-outlined text-xl">article</span>
                    Blog
                </span>
            </a>
            <a class="block py-3 px-3 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" href="https://strategix.grapadikonsultan.co.id" target="_blank">
                <span class="flex items-center gap-3">
                    Strategix
                </span>
            </a>
            <div class="pt-3 mt-3 border-t border-gray-200 dark:border-gray-700 space-y-3">
                {{-- Dark Mode Toggle for Mobile --}}
                <button 
                    x-data="{ 
                        dark: localStorage.getItem('darkMode') === 'true',
                        toggle() {
                            this.dark = !this.dark;
                            localStorage.setItem('darkMode', this.dark);
                            document.documentElement.classList.toggle('dark', this.dark);
                            document.documentElement.classList.toggle('light', !this.dark);
                        }
                    }"
                    x-init="dark = localStorage.getItem('darkMode') === 'true'"
                    @click="toggle()"
                    class="block w-full py-3 px-4 rounded-lg text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex items-center justify-center gap-2"
                >
                    <span x-show="!dark" class="material-icons-outlined text-xl">dark_mode</span>
                    <span x-show="dark" class="material-icons-outlined text-xl" x-cloak>light_mode</span>
                    <span x-text="dark ? 'Light Mode' : 'Dark Mode'"></span>
                </button>
                <a class="block w-full bg-primary hover:bg-primary-800 text-white text-center py-3 px-4 rounded-lg shadow-sm transition flex items-center justify-center gap-2" href="{{ url('/contact') }}">
                    <span class="material-icons-outlined text-xl">mail</span>
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</nav>
