@extends('layouts.school')

@section('title', 'Amiru International School | Learn, Lead, Thrive')

@section('content')
<main>
    <section class="hero">
        <div class="hero-copy">
            <div class="eyebrow"><span class="eyebrow-line"></span> A place to learn and belong</div>
            <h1>Curious minds.<br><em>Confident futures.</em></h1>
            <p class="hero-description">Welcome to Amiru International School, where every learner is encouraged to discover their strengths and build a bright future.</p>
            <div class="hero-actions">
                <a class="button button-green" href="{{ route('admissions.create') }}">Apply for admission <span aria-hidden="true">↗</span></a>
                <a class="text-link" href="#about">Discover Amiru <span aria-hidden="true">↓</span></a>
            </div>
            <div class="hero-note"><span class="note-dot"></span> Admissions are open for prospective students</div>
        </div>
        <div class="hero-art" role="img" aria-label="Illustration of books and a growing plant">
            <div class="art-sun"></div>
            <div class="art-orbit orbit-one"></div>
            <div class="art-orbit orbit-two"></div>
            <div class="book book-back"></div>
            <div class="book book-middle"></div>
            <div class="book book-front"><span></span><i></i></div>
            <div class="plant-stem"></div>
            <div class="leaf leaf-one"></div>
            <div class="leaf leaf-two"></div>
            <div class="leaf leaf-three"></div>
            <div class="art-caption"><span>01</span> Learn with purpose</div>
            <div class="art-spark spark-one">✳</div>
            <div class="art-spark spark-two">✦</div>
        </div>
        <div class="hero-index"><span>01</span><span class="index-divider"></span><span>03</span></div>
    </section>

    <section class="welcome-strip" id="about">
        <p class="eyebrow">WELCOME TO AMIRU</p>
        <h2>More than a school.<br><em>A community that helps you grow.</em></h2>
        <p class="welcome-copy">We bring learners, families, and educators together through supportive teaching, a caring school community, and opportunities to grow.</p>
    </section>

    <section class="learning-section" id="learning">
        <div class="section-heading">
            <div><p class="eyebrow">THE AMIRU EXPERIENCE</p><h2>Room to become <em>your best.</em></h2></div>
            <p>We support every learner, in class and beyond.</p>
        </div>
        <div class="feature-grid">
            <article class="feature-card"><span class="feature-number">01</span><div class="feature-icon icon-learning">✳</div><h3>Meaningful learning</h3><p>Build strong foundations, ask questions, and turn new ideas into understanding.</p></article>
            <article class="feature-card"><span class="feature-number">02</span><div class="feature-icon icon-community">◌</div><h3>A caring community</h3><p>Students are known, supported, and encouraged to grow with confidence.</p></article>
            <article class="feature-card"><span class="feature-number">03</span><div class="feature-icon icon-future">↗</div><h3>Ready for what’s next</h3><p>Develop the knowledge and character to take your next steps with purpose.</p></article>
        </div>
    </section>

    <section class="admissions-banner">
        <div><p class="eyebrow">YOUR NEXT CHAPTER STARTS HERE</p><h2>Let’s make room for <em>what’s possible.</em></h2></div>
        <a class="button button-dark" href="{{ route('admissions.create') }}">Start an application <span aria-hidden="true">↗</span></a>
    </section>
</main>
@endsection
