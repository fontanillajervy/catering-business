@extends('layouts.app')

@section('title', '3YOS Catering | Exceptional celebrations')

@section('content')
<section class="hero">
    <div class="container py-5 py-lg-0">
        <div class="row align-items-center min-vh-75 g-5">
            <div class="col-lg-7 py-lg-5">
                <div class="eyebrow mb-3">Catering · Styling · Celebration</div>
                <h1 class="hero-title mb-4">Every gathering deserves a beautiful table.</h1>
                <p class="hero-copy mb-4">From family milestones to polished corporate occasions, 3YOS creates generous menus and warm, seamless experiences built around your celebration.</p>
                <div class="d-flex flex-column flex-sm-row gap-3"><a href="{{ route('reservation') }}" class="btn btn-primary">Start planning your event</a><a href="{{ route('packages') }}" class="btn btn-outline-primary">Explore packages</a></div>
            </div>
            <div class="col-lg-5">
                <div class="hero-art"><div class="hero-art__label"><span>Made for your moment</span><strong>Menus with heart.<br>Service with ease.</strong></div></div>
            </div>
        </div>
    </div>
</section>

<section class="py-5 py-lg-6 bg-paper">
    <div class="container">
        <div class="row align-items-end mb-4 mb-lg-5"><div class="col-lg-7"><div class="eyebrow mb-2">What we do best</div><h2 class="section-title mb-0">A considered experience, from first call to final toast.</h2></div><div class="col-lg-4 ms-auto"><p class="text-muted mb-0">We pair flavorful food with thoughtful details so you can focus on being present with your guests.</p></div></div>
        <div class="row g-3 g-lg-4">
            <div class="col-md-4"><article class="service-tile h-100"><div class="service-number">01</div><h3>Weddings</h3><p>Graceful service and celebratory menus crafted for the people you love most.</p><a href="{{ route('services') }}">Discover wedding catering <span>→</span></a></article></div>
            <div class="col-md-4"><article class="service-tile h-100"><div class="service-number">02</div><h3>Private celebrations</h3><p>Easy, generous entertaining for birthdays, debuts, reunions, and everything in between.</p><a href="{{ route('services') }}">Celebrate beautifully <span>→</span></a></article></div>
            <div class="col-md-4"><article class="service-tile h-100"><div class="service-number">03</div><h3>Corporate events</h3><p>Reliable catering that helps meetings, launches, and company milestones run smoothly.</p><a href="{{ route('services') }}">Plan your event <span>→</span></a></article></div>
        </div>
    </div>
</section>

<section class="py-5 py-lg-6">
    <div class="container"><div class="occasion-panel"><div class="row align-items-center g-4"><div class="col-lg-7"><div class="eyebrow mb-2">Your celebration, your way</div><h2 class="section-title">Packages that make planning simpler.</h2><p class="text-muted mb-4">Begin with a package, then make it yours. We’ll help you shape the menu, guest experience, and finishing details around what matters to you.</p><a href="{{ route('packages') }}" class="btn btn-primary">See catering packages</a></div><div class="col-lg-5"><ul class="check-list mb-0"><li><span>✓</span>Flexible menus and guest counts</li><li><span>✓</span>Thoughtful setup and presentation</li><li><span>✓</span>Friendly, reliable event support</li></ul></div></div></div></div>
</section>

<style>
    .min-vh-75{min-height:68vh}.hero{background:linear-gradient(115deg,#f5eee3 0%,#fbf8f2 60%,#e8d9c6 100%)}.hero-title{font-size:clamp(3rem,6vw,5.35rem);line-height:.98;letter-spacing:-.045em;max-width:740px}.hero-copy{color:#625e57;font-size:1.13rem;line-height:1.7;max-width:590px}.hero-art{min-height:390px;position:relative;overflow:hidden;background:radial-gradient(circle at 40% 25%,#e8bd78 0 10%,transparent 10.5%),radial-gradient(circle at 70% 75%,#ac5e3f 0 17%,transparent 17.5%),linear-gradient(145deg,#7c3d2d,#d38a5e);box-shadow:18px 18px 0 #ded2c0}.hero-art:before,.hero-art:after{content:'';position:absolute;border:1px solid rgba(255,255,255,.45);border-radius:50%}.hero-art:before{width:315px;height:315px;top:35px;left:48px}.hero-art:after{width:210px;height:210px;bottom:-65px;right:-35px}.hero-art__label{position:absolute;z-index:1;bottom:28px;left:28px;color:#fff}.hero-art__label span{display:block;font-size:.7rem;font-weight:800;letter-spacing:.16em;text-transform:uppercase;margin-bottom:.45rem}.hero-art__label strong{font-family:'Playfair Display',serif;font-size:1.65rem;line-height:1.1}.py-lg-6{padding-top:6rem!important;padding-bottom:6rem!important}.bg-paper{background:#fffdf9}.section-title{font-size:clamp(2.2rem,4vw,3.5rem);line-height:1.05;letter-spacing:-.03em}.service-tile{padding:2.1rem;border:1px solid var(--line);background:var(--paper)}.service-number{font-size:.75rem;font-weight:800;color:var(--terracotta);letter-spacing:.14em;margin-bottom:3rem}.service-tile h3{font-size:1.8rem}.service-tile p{color:var(--muted);line-height:1.65}.service-tile a{color:var(--wine);font-weight:800;text-decoration:none;font-size:.88rem}.service-tile a span{margin-left:.35rem}.occasion-panel{padding:clamp(2rem,5vw,4.7rem);background:#ece3d5}.check-list{list-style:none;padding:0}.check-list li{padding:1rem 0;border-bottom:1px solid rgba(109,48,36,.16);font-weight:700}.check-list li:last-child{border-bottom:0}.check-list span{display:inline-grid;place-items:center;width:25px;height:25px;margin-right:.7rem;border-radius:50%;background:var(--wine);color:#fff;font-size:.75rem}@media(max-width:991px){.hero-art{min-height:300px}.min-vh-75{min-height:auto}.py-lg-6{padding-top:4rem!important;padding-bottom:4rem!important}}
</style>
@endsection
