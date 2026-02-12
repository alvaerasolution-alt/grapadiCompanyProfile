@php
// Get site settings
$companyName = site_setting('site_company_name', 'Grapadi');
$email = site_setting('site_email', 'info@grapadi.com');
$logo = site_setting('site_logo', '');

// Footer content
$footerCopyright = site_setting('footer_copyright', '© {year} {company}. ALL RIGHTS RESERVED.');
$footerDescription = site_setting('footer_description', 'Grapadi adalah perusahaan Business Advisory dan Riset Strategis yang mendampingi pengambilan keputusan bisnis dan investasi melalui studi kelayakan berbasis riset.');

// Process copyright text
$copyrightText = str_replace(['{year}', '{company}'], [date('Y'), strtoupper($companyName)], $footerCopyright);
@endphp

<footer class="bg-background-dark text-gray-400 pt-32 pb-8 text-sm">
    <div class="max-w-6xl mx-auto px-6">
        {{-- Top Section: Logo, Description & Subscribe --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 mb-20">
            {{-- Left: Logo & Description --}}
            <div class="text-center lg:text-left">
                <div class="flex items-center justify-center lg:justify-start gap-3 mb-6">
                    @if($logo)
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <img src="{{ str_starts_with($logo, 'http') ? $logo : asset('storage/' . $logo) }}" alt="{{ $companyName }}" class="h-6 w-auto">
                    </div>
                    @else
                    <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">G</span>
                    </div>
                    @endif
                    <span class="text-white text-xl font-bold">{{ $companyName }}</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed max-w-md mx-auto lg:mx-0">
                    {{ $footerDescription }}
                </p>
            </div>

            {{-- Right: Subscribe Section --}}
            <div class="text-center lg:text-left">
                <h4 class="text-primary font-bold text-xs tracking-widest uppercase mb-6">Subscribe to News</h4>
                <form id="footer-newsletter-form" class="space-y-3 max-w-md mx-auto lg:mx-0" onsubmit="subscribeFooter(event)">
                    @csrf
                    <input 
                        type="email" 
                        name="email"
                        id="footer-newsletter-email"
                        placeholder="Enter your email address" 
                        required
                        class="w-full bg-gray-800/50 border border-gray-700 rounded-full px-5 py-3 text-white placeholder-gray-500 focus:outline-none focus:border-primary text-sm"
                    >
                    <button 
                        type="submit"
                        id="footer-newsletter-btn"
                        class="w-full bg-primary hover:bg-primary-700 text-white font-bold py-3 px-6 rounded-full flex items-center justify-center gap-2 transition"
                    >
                        <span id="footer-btn-text">Subscribe</span>
                        <span class="material-icons-outlined text-sm" id="footer-btn-icon">north_east</span>
                        <svg id="footer-spinner" class="hidden animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </button>
                </form>
                <p id="footer-newsletter-message" class="mt-3 text-sm hidden"></p>
            </div>
        </div>

        {{-- Middle Section: Links Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-8 mb-12">
            <div>
                <h5 class="text-gray-500 font-bold text-xs tracking-widest uppercase mb-4">Company</h5>
                <ul class="space-y-3">
                    <li><a href="{{ url('/about') }}" class="text-gray-300 hover:text-primary transition">About Us</a></li>
                    <li><a href="{{ url('/services') }}" class="text-gray-300 hover:text-primary transition">Services</a></li>
                    <li><a href="{{ url('/portfolio') }}" class="text-gray-300 hover:text-primary transition">Portfolio</a></li>
                    <li><a href="{{ url('/blog') }}" class="text-gray-300 hover:text-primary transition">Blog</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-gray-500 font-bold text-xs tracking-widest uppercase mb-4">Resources</h5>
                <ul class="space-y-3">
                    <li><a href="{{ url('/timeline') }}" class="text-gray-300 hover:text-primary transition">Timeline</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-gray-300 hover:text-primary transition">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h5 class="text-gray-500 font-bold text-xs tracking-widest uppercase mb-4">Contact</h5>
                @if($email)
                <div class="flex items-center gap-2 text-gray-300">
                    <span class="material-icons-outlined text-lg">mail_outline</span>
                    <span>{{ $email }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Bottom Section: Watermark & Copyright --}}
        <div class="border-t border-gray-800 pt-8">
            {{-- Watermark --}}
            <div class="overflow-hidden select-none pointer-events-none mb-4">
                <span class="text-6xl md:text-8xl lg:text-9xl font-black tracking-widest text-gray-800/30 uppercase font-display">
                    GRAPADI
                </span>
            </div>
            <p class="text-gray-600 text-xs text-center lg:text-left">
                {{ $copyrightText }}
            </p>
        </div>
    </div>
</footer>

<script>
function subscribeFooter(event) {
    event.preventDefault();
    
    const form = document.getElementById('footer-newsletter-form');
    const email = document.getElementById('footer-newsletter-email').value;
    const btn = document.getElementById('footer-newsletter-btn');
    const btnText = document.getElementById('footer-btn-text');
    const btnIcon = document.getElementById('footer-btn-icon');
    const spinner = document.getElementById('footer-spinner');
    const message = document.getElementById('footer-newsletter-message');
    const csrfToken = form.querySelector('input[name="_token"]').value;
    
    // Show loading state
    btn.disabled = true;
    btnText.textContent = 'Subscribing...';
    btnIcon.classList.add('hidden');
    spinner.classList.remove('hidden');
    message.classList.add('hidden');
    
    fetch('{{ route("newsletter.subscribe") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            email: email,
            source: 'footer',
        }),
    })
    .then(response => response.json())
    .then(data => {
        message.classList.remove('hidden');
        
        if (data.success) {
            message.textContent = data.message;
            message.className = 'mt-3 text-sm text-green-400';
            form.reset();
        } else {
            message.textContent = data.message;
            message.className = 'mt-3 text-sm text-red-400';
        }
    })
    .catch(error => {
        message.classList.remove('hidden');
        message.textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        message.className = 'mt-3 text-sm text-red-400';
    })
    .finally(() => {
        btn.disabled = false;
        btnText.textContent = 'Subscribe';
        btnIcon.classList.remove('hidden');
        spinner.classList.add('hidden');
    });
}
</script>
