<section id="nx-hero" class="nx-hero" aria-labelledby="nx-hero-title">
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

    <div class="nx-hero__inner">
        <nav id="nx-hero-nav" class="nx-nav" aria-label="Main navigation">
            <a class="nx-brand" href="{{ url('/') }}" aria-label="NexCash home">Fin<span>Pulse</span><sup>®</sup></a>
            <div class="nx-nav__links">
                <a href="#about">About Us</a>
                <a href="#features">Features</a>
                <a href="#benefits">Benefits</a>
                <a href="#faq">FAQ</a>
            </div>
            <a class="nx-button nx-button--nav" href="{{ route('login') }}">Sign In</a>
        </nav>

        <div id="nx-hero-content" class="nx-hero__content">
            <p class="nx-eyebrow" data-hero-eyebrow>The future of personal finance</p>
            <h1 id="nx-hero-title" data-hero-title>Empowering Your<br><em>Financial</em> Future</h1>
            <a class="nx-button" data-hero-cta href="#get-started">Get Started <span aria-hidden="true">↗</span></a>
        </div>

        <div id="nx-hero-footer" class="nx-hero__footer">
            <p>FinPulse seamlessly bridges innovative digital solutions with your everyday financial needs, simplifying, securing, and enhancing the management of money.</p>
            <span class="nx-scroll-note"><i></i> Scroll to explore</span>
        </div>
    </div>

    <!-- MotionPath decorative SVG -->
    <svg class="nx-hero__motionpath" width="200" height="400" viewBox="0 0 200 400" fill="none" xmlns="http://www.w3.org/2000/svg" style="position:absolute;right:8%;bottom:10%;opacity:0.25;pointer-events:none;" aria-hidden="true">
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
