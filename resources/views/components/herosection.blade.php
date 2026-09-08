<section class="nx-hero" aria-labelledby="nx-hero-title">
    <video class="nx-hero__video" autoplay muted loop playsinline poster="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/image-CsU1wpB24uCr6qEs9CQZiUqSpxKzFa.png" aria-hidden="true">
        <source src="{{ asset('herosectionvideo.mp4') }}" type="video/mp4">
    </video>

    <div class="nx-hero__wash" aria-hidden="true"></div>
    <div class="nx-hero__grid" aria-hidden="true"></div>

    <div class="nx-hero__inner">
        <nav class="nx-nav" aria-label="Main navigation">
            <a class="nx-brand" href="{{ url('/') }}" aria-label="NexCash home">Nex<span>Cash</span><sup>®</sup></a>
            <div class="nx-nav__links">
                <a href="#about">About Us</a>
                <a href="#features">Features</a>
                <a href="#benefits">Benefits</a>
                <a href="#faq">FAQ</a>
            </div>
            <a class="nx-button nx-button--nav" href="{{ route('login') }}">Sign In</a>
        </nav>

        <div class="nx-hero__content">
            <p class="nx-eyebrow">The future of personal finance</p>
            <h1 id="nx-hero-title">Empowering Your<br><em>Financial</em> Future</h1>
            <a class="nx-button" href="#get-started">Get Started <span aria-hidden="true">↗</span></a>
        </div>

        <div class="nx-hero__footer">
            <p>NexCash seamlessly bridges innovative digital solutions with your everyday financial needs, simplifying, securing, and enhancing the management of money.</p>
            <span class="nx-scroll-note"><i></i> Scroll to explore</span>
        </div>
    </div>
</section>
