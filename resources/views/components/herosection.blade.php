<section id="nx-hero" class="nx-hero" aria-labelledby="nx-hero-title" x-data="{ heroNavOpen: false }">
    <video
        id="nx-hero-video"
        class="nx-hero__video"
        autoplay
        muted
        loop
        playsinline
        disablePictureInPicture
        disableremoteplayback
        oncontextmenu="return false;"
        poster="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-CsU1wpB24uCr6qEs9CQZiUqSpxKzFa.png"
        aria-hidden="true"
        tabindex="-1"
    >
        <source src="{{ asset('herosectionvideo.mp4') }}" type="video/mp4">
    </video>

    <div class="nx-hero__wash" aria-hidden="true"></div>
    <div id="nx-hero-grid" class="nx-hero__grid" aria-hidden="true"></div>

    <div class="nx-hero__inner relative z-20">
        <nav id="nx-hero-nav" class="nx-nav relative z-30" aria-label="Main navigation">
            <a class="nx-brand" href="{{ url('/') }}" aria-label="FinPulse home">Fin<span>Pulse</span><sup>®</sup></a>
            
            <div class="nx-nav__links hidden md:flex">
                <a href="#about">About Us</a>
                <a href="#how-it-works">How It Works</a>
                <a href="#features">Features</a>
                <a href="#faq">FAQ</a>
            </div>

            <a class="nx-button nx-button--nav hidden sm:inline-flex" href="{{ route('login') }}">Sign In</a>

            <!-- Mobile Menu Toggle Button -->
            <button
                @click="heroNavOpen = !heroNavOpen"
                class="md:hidden ml-auto p-1.5 text-[#aebaff] hover:text-white rounded-lg focus:outline-none transition-colors"
                aria-label="Toggle mobile navigation menu"
                :aria-expanded="heroNavOpen ? 'true' : 'false'"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!heroNavOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="heroNavOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </nav>

        <!-- Mobile Navigation Drawer Overlay -->
        <div
            x-show="heroNavOpen"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
            @click.away="heroNavOpen = false"
            class="md:hidden max-w-sm mx-auto mt-3 p-5 rounded-2xl border border-[#889eff]/30 bg-[#07113d]/95 backdrop-blur-2xl shadow-2xl flex flex-col gap-3 text-center relative z-40"
            x-cloak
        >
            <a href="#about" @click="heroNavOpen = false" class="text-sm font-semibold text-[#d2d8f4] hover:text-white py-2 border-b border-[#889eff]/15 transition-colors">About Us</a>
            <a href="#how-it-works" @click="heroNavOpen = false" class="text-sm font-semibold text-[#d2d8f4] hover:text-white py-2 border-b border-[#889eff]/15 transition-colors">How It Works</a>
            <a href="#features" @click="heroNavOpen = false" class="text-sm font-semibold text-[#d2d8f4] hover:text-white py-2 border-b border-[#889eff]/15 transition-colors">Features</a>
            <a href="#pricing" @click="heroNavOpen = false" class="text-sm font-semibold text-[#d2d8f4] hover:text-white py-2 border-b border-[#889eff]/15 transition-colors">Pricing</a>
            <a href="#faq" @click="heroNavOpen = false" class="text-sm font-semibold text-[#d2d8f4] hover:text-white py-2 border-b border-[#889eff]/15 transition-colors">FAQ</a>
            <a href="{{ route('login') }}" class="nx-button w-full justify-center mt-2 py-3 text-xs font-bold shadow-lg">Sign In</a>
        </div>

        <div id="nx-hero-content" class="nx-hero__content">
            <p class="nx-eyebrow" data-hero-eyebrow>The future of personal finance</p>
            <h1 id="nx-hero-title" data-hero-title>Empowering Your<br><em>Financial</em> Future</h1>
            <a class="nx-button" data-hero-cta href="#about">Get Started <span aria-hidden="true">↗</span></a>
        </div>

        <div id="nx-hero-footer" class="nx-hero__footer">
            <p>FinPulse seamlessly bridges innovative digital solutions with your everyday financial needs, simplifying, securing, and enhancing the management of money.</p>
            <span class="nx-scroll-note"><i></i> Scroll to explore</span>
        </div>
    </div>

    <!-- MotionPath decorative SVG (Desktop only) -->
    <svg class="nx-hero__motionpath hidden md:block" width="200" height="400" viewBox="0 0 200 400" fill="none" xmlns="http://www.w3.org/2000/svg" style="position:absolute;right:8%;bottom:10%;opacity:0.25;pointer-events:none;" aria-hidden="true">
        <path id="hero-path" d="M100 0 C150 80, 50 120, 100 200 C150 280, 50 320, 100 400" stroke="url(#heroGrad)" stroke-width="2" fill="none"/>
        <circle id="hero-dot" r="5" fill="#4e5bff"/>
        <defs>
            <linearGradient id="heroGrad" x1="0" y1="0" x2="0" y2="1">
                <stop offset="0%" stop-color="#4e5bff"/>
                <stop offset="100%" stop-color="#903dff"/>
            </linearGradient>
        </defs>
    </svg>
</section>
