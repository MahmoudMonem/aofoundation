@extends('layouts.index')

@section('center')

<!-- Hero Video Section -->
<section id="home" class="position-relative overflow-hidden text-white" style="height: 60vh;">
  <!-- Background Video with 50% Opacity -->
  <video autoplay muted loop playsinline id="myVideo"
    class="w-100 h-100 object-fit-cover position-absolute top-0 start-0"
    style="opacity: 0.5;">
    <source src="{{ site_content('hero_video', 'videos/hero.mp4') }}" type="video/mp4">
    Your browser does not support HTML5 video.
  </video>

  <!-- Black Gradient Fade (Top) -->
  <div class="position-absolute top-0 start-0 w-100"
    style="height: 100px; background: linear-gradient(to bottom, black, transparent); z-index: 1;"></div>

  <!-- Hero Content -->
  <div class="content-wrapper animate-on-scroll position-relative z-1 text-center text-white py-5">
    <h1 class="section-title">{{ site_content('hero_title', 'Events Done Right') }}</h1>
    <p class="section-sub mx-auto" style="max-width: 600px;">
      {{ site_content('hero_subtitle', 'AO International Projects Management brings years of experience in medical events to a wide range of industries.') }}
    </p>
    <a href="{{ site_content('hero_cta_link', '#about') }}" class="btn-light-outline">{{ site_content('hero_cta_text', 'See What We Do') }}</a>
  </div>
</section>

<!-- Events Section -->
<section id="events" class="milestone-section py-5 text-light animate-on-scroll">
  <div class="container">
    <div class="row align-items-center">
      <!-- Text Content -->
      <div class="col-lg-6 mb-4 mb-lg-0">
        <p class="text-uppercase small brandsecondary-color">{{ site_content('events_label', 'Events') }}</p>
        <h2 class="fw-bold display-5">{{ site_content('events_title', 'Our global events') }}</h2>
        <p class="text-left">
          {{ site_content('events_description_1', 'We host invitation-only events at key climate moments as well as community and partner-led gatherings in cities around the world.') }}
        </p>
        <p class="text-left">
          {{ site_content('events_description_2', 'Trust is built in rooms, not virtual rooms. We put humanity back in the room.') }}
        </p>
        <div class="mt-3">
          <a href="#contact" class="btn btn-primary rounded-pill">{{ site_content('events_cta_text', 'Get in touch') }} <span class="arrow">→</span></a>
        </div>
      </div>

      <!-- Image -->
      <div class="col-lg-6 text-center">
        <div class="event-image-wrapper mx-auto">
          <img src="{{ site_content('events_image', '/images/vfc.jpg') }}" alt="Event Photo" class="img-fluid rounded shadow event-image" />
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WHO WE ARE -->
<section id="about" class="py-5 text-white">
  <div class="container content-wrapper animate-on-scroll">
    <div class="row align-items-center">
      <!-- Text Column -->
      <div class="col-12 col-lg-6 mb-4 mb-lg-0">
        <h2 class="section-title head-color text-center text-lg-start">{{ site_content('about_title', 'Who We Are') }}</h2>
        <p class="mt-3 text-center text-lg-start">
          {{ site_content('about_description_1', 'AO International Projects Management Co. is a full-service management company specialized in marketing strategy, business process optimization, planning conferences, exhibitions, seminars, health awareness campaigns, and professional events.') }}
          <br><br>
          {{ site_content('about_description_2', 'AO International Projects Management is a trusted provider of comprehensive medical writing, clinical research support, and data management services.') }}
        </p>
      </div>

      <!-- Carousel Column -->
      <div class="col-12 col-lg-6">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="{{ asset('images/carousel/1(1).JPG') }}" class="d-block w-100 img-fluid" alt="Slide 1">
            </div>
            <div class="carousel-item">
              <img src="{{ asset('images/carousel/1(2).JPG') }}" class="d-block w-100 img-fluid" alt="Slide 2">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CORE SERVICES -->
<section id="core-services" class="py-5 text-white">
  <div class="container content-wrapper animate-on-scroll col-6">
    <h2 class="section-title mb-4 head-color">{{ site_content('services_title', 'Our Core Services') }}</h2><br>
    <div class="row g-4">
      @for($i = 1; $i <= 8; $i++)
      <div class="col-md-6 col-lg-4">
        <h5 class="brandsecondary-color">{{ site_content("service_{$i}_title", "Service {$i}") }}</h5>
        <p>{{ site_content("service_{$i}_description", '') }}</p>
      </div>
      @endfor
    </div>
  </div>
</section>

<!-- WHY CHOOSE US -->
<section id="why-choose-us" class="py-5 text-white">
  <div class="container content-wrapper animate-on-scroll">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-title head-color">{{ site_content('why_title', 'Why Choose Us?') }}</h2><br>
        <img src="{{ site_content('why_image', 'images/whyus.jpg') }}" alt="AO team or process" class="img-fluid rounded">

        <div class="text-start d-inline-block mt-3">
          <br><br>
          <p><strong class="brandsecondary-color">{{ site_content('why_point_1_title', 'Unmatched Quality') }}:</strong> {{ site_content('why_point_1_description', 'Every project is handled with scientific precision and attention to detail.') }}</p>
          <p><strong class="brandsecondary-color">{{ site_content('why_point_2_title', 'Timely Delivery') }}:</strong> {{ site_content('why_point_2_description', 'We meet deadlines without compromise.') }}</p>
          <p><strong class="brandsecondary-color">{{ site_content('why_point_3_title', 'Cost-Effective Solutions') }}:</strong> {{ site_content('why_point_3_description', 'Affordability with zero compromise on quality.') }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CLIENTS SECTION -->
<div class="logo-section">
    <div id="clients" class="text-center col-12">
        <h2 class="section-title head-color animate-on-scroll">{{ site_content('clients_title', 'Our Clients') }}</h2>
        <p class="brandsecondary-color">{{ site_content('clients_subtitle', 'We are working with a range of incredible global partners including:') }}</p>
    </div>

    @if(isset($clientLogosRow1) && $clientLogosRow1->count() > 0)
    <!-- First Logo Carousel -->
    <div style="background-color:black;" class="container-fluid mt-5">
        <div class="logo-wrapper mx-auto">
            <div class="logo-track row1">
                <div class="logo-strip">
                    {{-- First set of logos --}}
                    @foreach($clientLogosRow1 as $logo)
                        <img src="{{ asset($logo->logo) }}" alt="{{ $logo->name }}">
                    @endforeach
                    
                    {{-- Duplicated for seamless scroll --}}
                    @foreach($clientLogosRow1 as $logo)
                        <img src="{{ asset($logo->logo) }}" alt="{{ $logo->name }}">
                    @endforeach
                    
                    {{-- Third set for longer seamless scroll --}}
                    @foreach($clientLogosRow1 as $logo)
                        <img src="{{ asset($logo->logo) }}" alt="{{ $logo->name }}">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(isset($clientLogosRow2) && $clientLogosRow2->count() > 0)
    <!-- Second Logo Carousel -->
    <div class="container-fluid">
        <div class="logo-wrapper mx-auto">
            <div class="logo-track row1">
                <div class="logo-strip">
                    {{-- First set of logos --}}
                    @foreach($clientLogosRow2 as $logo)
                        <img src="{{ asset($logo->logo) }}" alt="{{ $logo->name }}">
                    @endforeach
                    
                    {{-- Duplicated for seamless scroll --}}
                    @foreach($clientLogosRow2 as $logo)
                        <img src="{{ asset($logo->logo) }}" alt="{{ $logo->name }}">
                    @endforeach
                    
                    {{-- Third set for longer seamless scroll --}}
                    @foreach($clientLogosRow2 as $logo)
                        <img src="{{ asset($logo->logo) }}" alt="{{ $logo->name }}">
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- OUR WORK / PREVIOUS EVENTS -->
<section id="previous-work" class="py-5 text-white">
  <div class="container content-wrapper animate-on-scroll">
    <h2 class="section-title mb-4 text-center head-color">{{ site_content('work_title', 'Our Work') }}</h2>
    <div class="row row-cols-1 row-cols-md-2 g-4">
      @foreach($events as $event)
        @php
          $featuredeventimage = $event->eventimages->where('featured', 1)->first();
          $nonFeaturedImages = $event->eventimages->where('featured', '!=', 1);
        @endphp

        <div class="col text-center">
          <span class="badge text-white d-inline-flex align-items-center px-3 py-2" style="background-color:rgb(97, 55, 40);">
            {{ $event->created_at->format('D, M j, Y') }}
          </span>
          <div id="carousel-{{ $event->id }}" class="carousel slide mb-3" data-bs-ride="carousel">
            <div class="carousel-inner">
              @if($featuredeventimage)
                <div class="carousel-item active">
                  <img src="{{ asset('events/' . $featuredeventimage->img) }}" class="d-block w-100" alt="Featured Event Image" style="max-height: 200px; object-fit: cover;">
                </div>
              @endif

              @foreach($nonFeaturedImages as $eventimage)
                <div class="carousel-item">
                  <img src="{{ asset('events/' . $eventimage->img) }}" class="d-block w-100" alt="Event Image" style="max-height: 200px; object-fit: cover;">
                </div>
              @endforeach
            </div>

            @if($event->eventimages->count() > 1)
              <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $event->id }}" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $event->id }}" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
              </button>
            @endif
          </div>

          <p class="fw-bold">{{ $event->title_en }}</p><br>
          <p class="brandsecondary-color">{{ $event->short_desc_en }}</p>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- MEDICAL EVENT METRICS -->
<section class="metrics-section text-light animate-on-scroll" id="metrics">
  <div class="container text-center animate-on-scroll">
    <p class="metrics-label text-uppercase mb-2">{{ site_content('metrics_label', 'Our Metrics + Impact') }}</p>
    <h1 class="metrics-title mb-4 head-color">
      {{ site_content('metrics_title', 'The following medical event outcomes have been established:') }}
    </h1>
    <hr class="mx-auto mb-5" style="max-width: 600px; border-color: rgba(255,255,255,0.2);" />

    <div class="row justify-content-center gy-5">
      <!-- Metric 1 -->
      <div class="col-12 col-md-4">
        <h1 class="section-title counter" data-target="{{ site_content('metric_1_value', '97') }}">0</h1>
        <p class="metric-subtitle text-uppercase head-color">{{ site_content('metric_1_label', 'Knowledge Retention') }}</p>
        <p class="metric-text">{{ site_content('metric_1_description', 'of participants reported improved understanding of clinical procedures') }}</p>
      </div>

      <!-- Metric 2 -->
      <div class="col-12 col-md-4">
        <h1 class="section-title counter" data-target="{{ site_content('metric_2_value', '98') }}">0</h1>
        <p class="metric-subtitle text-uppercase head-color">{{ site_content('metric_2_label', 'NPS Score') }}</p>
        <p class="metric-text">{{ site_content('metric_2_description', 'A blended Net Promoter Score of 98 across international AO events') }}</p>
      </div>

      <!-- Metric 3 -->
      <div class="col-12 col-md-4">
        <h1 class="section-title counter" data-target="{{ site_content('metric_3_value', '94') }}">0</h1>
        <p class="metric-subtitle text-uppercase head-color">{{ site_content('metric_3_label', 'Global Collaboration') }}</p>
        <p class="metric-text">{{ site_content('metric_3_description', 'of attendees made a new global research or clinical connection') }}</p>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT US -->
<div id="contact-success"></div>
<section id="contact" class="milestone-section">
  <div class="container py-5">
    <h2 class="text-center mb-4">{{ site_content('contact_title', 'Contact Us') }}</h2>
    <p class="text-center mb-5">{{ site_content('contact_subtitle', 'Have questions or ideas? Reach out and let\'s connect!') }}</p>

    <!-- Success Message -->
    @if(session('success'))
      <div class="alert alert-success text-center">
        {{ session('success') }}
      </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('contact.store') }}" method="POST" class="row justify-content-center">
      @csrf
      <div class="col-md-8">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Enter your email" aria-label="Email" style="background-color: rgba(255, 255, 255, 0.7);" value="{{ old('email') }}" required>
        </div>

        <div class="input-group mb-3">
          <input type="tel" name="phone" class="form-control" placeholder="Enter your phone number" aria-label="Phone" style="background-color: rgba(255, 255, 255, 0.7);" value="{{ old('phone') }}">
        </div>

        <div class="input-group mb-3">
          <textarea name="message" class="form-control" rows="5" placeholder="Your message" aria-label="Message" required style="background-color: rgba(255, 255, 255, 0.7);">{{ old('message') }}</textarea>
        </div>

        <div class="text-center">
          <button type="submit" class="btn rounded-pill" style="background-color:#ad715c; color:white;">{{ site_content('contact_cta_text', 'Send Message') }} <span class="arrow">→</span></button>
        </div>
      </div>
    </form>
  </div>
</section>

<style>
input::placeholder,
textarea::placeholder {
    color: white;
    opacity: 1;
}
</style>

<hr class="text-light col-12">

@endsection