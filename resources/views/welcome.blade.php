@extends('layouts.index')

@section('center')

<!-- Hero Video Section -->
<section id="home" class="position-relative overflow-hidden text-white" style="height: 60vh;">
  <!-- Background Video with 50% Opacity -->
  <video autoplay muted loop playsinline id="myVideo"
    class="w-100 h-100 object-fit-cover position-absolute top-0 start-0"
    style="opacity: 0.5;">
    <source src="videos/hero.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
  </video>

  <!-- Black Gradient Fade (Top) -->
  <div class="position-absolute top-0 start-0 w-100"
    style="height: 100px; background: linear-gradient(to bottom, black, transparent); z-index: 1;"></div>

  <!-- Hero Content -->
  <div class="content-wrapper animate-on-scroll position-relative z-1 text-center text-white py-5">
    <h1 class="section-title">Events Done Right</h1>
    <p class="section-sub mx-auto" style="max-width: 600px;">
      AO Foundation brings years of experience in medical events to a wide range of industries — helping teams plan, manage, and deliver events that leave a mark.
    </p>
    <a href="#about" class="btn-light-outline">See What We Do</a>
  </div>
</section>





</section>

<section id="events" class="milestone-section py-5 text-light animate-on-scroll">
  <div class="container">
    <div class="row align-items-center">
      <!-- Text Content -->
      <div class="col-lg-6 mb-4 mb-lg-0">
        <p class="text-uppercase small brandsecondary-color">Events</p>
        <h2 class="fw-bold display-5">Our global events</h2>
        <p class="text-left">
          We host invitation-only events at key climate moments as well as
          community and partner-led gatherings in cities around the world.
          These moments enable guests to learn from each other, explore deal
          flow and create connections, encouraging collaboration.
        </p>
        <p class="text-left">
          Trust is built in rooms, not virtual rooms. <br />
          We put humanity back in the room.
        </p>
        <div class=" mt-3">

          <a href="#contact" class="btn btn-primary rounded-pill"> Get in touch <span class="arrow">→</span></a>
   
        </div>
      </div>

      <!-- Image -->
      <div class="col-lg-6 text-center">
        <div class="event-image-wrapper mx-auto">
          <img src="/images/vfc.jpg" alt="Event Photo" class="img-fluid rounded shadow event-image" />
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ABOUT -->
<!-- WHO WE ARE -->
<section id="about" id="who-we-are" class="py-5 text-white">
  <div class="container content-wrapper animate-on-scroll">
    <div class="row align-items-center">

      <!-- Text Column -->
      <div class="col-12 col-lg-6 mb-4 mb-lg-0">
        <h2 class="section-title head-color text-center text-lg-start"> Who We Are</h2>
        <p class="mt-3 text-center text-lg-start">
          AO International Projects Management Co. is a full-service management company specialized in marketing strategy, business process optimization, planning conferences, exhibitions, seminars, health awareness campaigns, and professional events.
          <br><br>
          AO International Projects Management is a trusted provider of comprehensive medical writing, clinical research support, and data management services. With a commitment to precision, efficiency, and affordability, we collaborate with healthcare professionals, pharmaceutical companies, and KOLs to deliver impactful, evidence-based scientific content.
        </p>
      </div>

      <!-- Carousel Column -->
      <div class="col-12 col-lg-6">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="{{ asset('images/carousel/1 (1).jpg') }}" class="d-block w-100 img-fluid" alt="Slide 1">
            </div>
            <div class="carousel-item">
              <img src="{{ asset('images/carousel/1 (2).jpg') }}" class="d-block w-100 img-fluid" alt="Slide 2">
            </div>
            <!-- Add additional slides as needed -->
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



  <!-- SERVICES -->
<!-- CORE SERVICES -->
<section id="core-services" class="py-5 text-white ">
  <div class="container content-wrapper animate-on-scroll col-6">
    <h2 class="section-title mb-4 head-color">Our Core Services</h2><br>
    <div class="row g-4">
      <div class="col-md-6 col-lg-4">
        <h5 class="brandsecondary-color">Medical Writing Services</h5>
        <p>
          Manuscript writing & editing, board support, abstracts, posters, and grant writing.
        </p>
      </div>
      <div class="col-md-6 col-lg-4">
        <h5 class="brandsecondary-color">Clinical Research Support</h5>
        <p>
          Protocols, study docs, investigator brochures, CSR, SAP, and conference support.
        </p>
      </div>
      <div class="col-md-6 col-lg-4">
        <h5 class="brandsecondary-color">Data Management & Statistical Analysis</h5>
        <p>
          Comprehensive data handling, reporting, and statistical analysis.
        </p>
      </div>
      <div class="col-md-6 col-lg-4">
        <h5 class="brandsecondary-color">Medical Affairs & Training</h5>
        <p>
          CME modules, training for field medical affairs, and content development.
        </p>
      </div>
      <div class="col-md-6 col-lg-4">
        <h5 class="brandsecondary-color">Infographics & Visuals</h5>
        <p>
          Simplifying medical data via custom infographics and graphical abstracts.
        </p>
      </div>
      <div class="col-md-6 col-lg-4">
        <h5 class="brandsecondary-color">Publication & Journal Compliance</h5>
        <p>
          Strategic planning, journal selection, and end-to-end publication support.
        </p>
      </div>
      <div class="col-md-6 col-lg-4">
        <h5 class="brandsecondary-color">Digital Solutions</h5>
        <p>
          Medical registries, patient education tools, and mobile apps for assessment.
        </p>
      </div>
      <div class="col-md-6 col-lg-4">
        <h5 class="brandsecondary-color">Conference & Event Support</h5>
        <p>
          Abstract booklets, session coverage, and design for slides and posters.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- WHY CHOOSE US -->
<section id="why-choose-us" class="py-5 text-white">

  <div class="container content-wrapper animate-on-scroll">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2 class="section-title head-color">Why Choose Us?</h2><br>
  
        <img src="images/whyus.jpg" alt="AO team or process" class="img-fluid rounded">

      <div class="text-start d-inline-block mt-3">
      <br>  <br><p><strong class="brandsecondary-color">Unmatched Quality:</strong> Every project is handled with scientific precision and attention to detail.</p>
          <p><strong class="brandsecondary-color">Timely Delivery:</strong> We meet deadlines without compromise.</p>
          <p><strong class="brandsecondary-color">Cost-Effective Solutions:</strong> Affordability with zero compromise on quality.</p>
        </div>
      </div>

    </div>
  </div>
</section>



<div id="clients" class="text-center col-12">
      <h2 class="section-title head-color animate-on-scroll">Our Clients</h2>

      <p class="brandsecondary-color">We are working with a range of incredible global partners including:</p>

    </div>

<!-- First Logo Carousel -->
<div style="background-color:black;" class="container-fluid mt-5 ">
  <div class="logo-wrapper mx-auto">
    <div class="logo-track row1">
      <div class="logo-strip">
        <!-- Logos -->
        <img src="logos/Novartis.png" alt="Novartis">
        <img src="logos/novo.png" alt="Novo">
        <img src="logos/sabahalahmad.png" alt="Sabah Al Ahmad">
        <img src="logos/Servier.png" alt="Servier">
        <img src="logos/hamdsaleh.png" alt="Hamed Saleh">
        <img src="logos/sanofi.png" alt="Sanofi">
        <img src="logos/Algo.png" alt="Algo">
        <img src="logos/amryt.png" alt="Amryt">
        <img src="logos/AMGEN.png" alt="Amgen">
        <img src="logos/Boubyan.png" alt="Boubyan Bank">

        <!-- Duplicated for seamless scroll -->
        <img src="logos/Novartis.png" alt="Novartis">
        <img src="logos/novo.png" alt="Novo">
        <img src="logos/sabahalahmad.png" alt="Sabah Al Ahmad">
        <img src="logos/Servier.png" alt="Servier">
        <img src="logos/Viatris.png" alt="Viatris">
        <img src="logos/hamdsaleh.png" alt="Hamed Saleh">
        <img src="logos/sanofi.png" alt="Sanofi">
        <img src="logos/Algo.png" alt="Algo">
        <img src="logos/amryt.png" alt="Amryt">
        <img src="logos/AMGEN.png" alt="Amgen">
        <img src="logos/Boubyan.png" alt="Boubyan Bank">

        <img src="logos/Novartis.png" alt="Novartis">
        <img src="logos/novo.png" alt="Novo">
        <img src="logos/sabahalahmad.png" alt="Sabah Al Ahmad">
        <img src="logos/Servier.png" alt="Servier">
        <img src="logos/Viatris.png" alt="Viatris">
        <img src="logos/hamdsaleh.png" alt="Hamed Saleh">
        <img src="logos/sanofi.png" alt="Sanofi">
        <img src="logos/Algo.png" alt="Algo">
        <img src="logos/amryt.png" alt="Amryt">
        <img src="logos/AMGEN.png" alt="Amgen">
        <img src="logos/Boubyan.png" alt="Boubyan Bank">
      </div>
    </div>
  </div>
</div>

<!-- Second Logo Carousel -->
<div class="container-fluid ">
  <div class="logo-wrapper mx-auto">
    <div class="logo-track row1">
      <div class="logo-strip">
        <!-- Logos -->
        <img src="logos/AAW.png" alt="AAW">
        <img src="logos/Az.png" alt="AstraZeneca">
        <img src="logos/Bayer.png" alt="Bayer">
        <img src="logos/BLGX.png" alt="BLGX">
        <img src="logos/boehringer.png" alt="Boehringer Ingelheim">
        <img src="logos/genpharm.png" alt="Genpharm">
        <img src="logos/KHF.png" alt="Kuwait Heart Foundation">
        <img src="logos/Lilly.png" alt="Eli Lilly">
        <img src="logos/mohealth.png" alt="Ministry of Health">

        <!-- Duplicated for seamless scroll -->
        <img src="logos/AAW.png" alt="AAW">
        <img src="logos/Az.png" alt="AstraZeneca">
        <img src="logos/Bayer.png" alt="Bayer">
        <img src="logos/BLGX.png" alt="BLGX">
        <img src="logos/boehringer.png" alt="Boehringer Ingelheim">
        <img src="logos/genpharm.png" alt="Genpharm">
        <img src="logos/KHF.png" alt="Kuwait Heart Foundation">
        <img src="logos/Lilly.png" alt="Eli Lilly">
        <img src="logos/mohealth.png" alt="Ministry of Health">

        <img src="logos/AAW.png" alt="AAW">
        <img src="logos/Az.png" alt="AstraZeneca">
        <img src="logos/Bayer.png" alt="Bayer">
        <img src="logos/BLGX.png" alt="BLGX">
        <img src="logos/boehringer.png" alt="Boehringer Ingelheim">
        <img src="logos/genpharm.png" alt="Genpharm">
        <img src="logos/KHF.png" alt="Kuwait Heart Foundation">
        <img src="logos/Lilly.png" alt="Eli Lilly">
        <img src="logos/mohealth.png" alt="Ministry of Health">
      </div>
    </div>
  </div>
</div>



<!-- EXAMPLES OF PREVIOUS WORK -->
<section id="previous-work" class="py-5 text-white">
  <div class="container content-wrapper animate-on-scroll ">
    <h2 class="section-title mb-4 text-center  head-color">Examples of Our Previous Work</h2>
    <div class="row justify-content-center g-5">
      <div class="col-sm-6 col-md-4 text-center">
        <p class="fw-bold">Intracoronary Calcification Consensus</p>
        <img src="images/qrcode.png" alt="QR Code 1" class="img-fluid" style="max-width: 180px;">
      </div>
      <div class="col-sm-6 col-md-4 text-center">
        <p class="fw-bold">Intracoronary Imaging Consensus</p>
        <img src="images/qrcode.png" alt="QR Code 2" class="img-fluid" style="max-width: 180px;">
      </div>
    </div>
  </div>
</section>

<!-- MEDICAL EVENT METRICS -->
<section class="metrics-section text-light animate-on-scroll" id="metrics">
  <div class="container text-center animate-on-scroll">
    <p class="metrics-label text-uppercase mb-2">Our Metrics + Impact</p>
    <h1 class="metrics-title mb-4 head-color">
      The following medical event outcomes have been established:
    </h1>
    <hr class="mx-auto mb-5" style="max-width: 600px; border-color: rgba(255,255,255,0.2);" />

    <div class="row justify-content-center gy-5">
      <!-- Metric 1 -->
      <div class="col-12 col-md-4">
        <h1 class="section-title counter" data-target="97">0</h1>
        <p class="metric-subtitle text-uppercase  head-color">Knowledge Retention</p>
        <p class="metric-text">
          of participants reported improved understanding of clinical procedures
        </p>
      </div>

      <!-- Metric 2 -->
      <div class="col-12 col-md-4">
        <h1 class="section-title counter" data-target="98">0</h1>
        <p class="metric-subtitle text-uppercase  head-color">NPS Score</p>
        <p class="metric-text">
          A blended Net Promoter Score of 98 across international AO events
        </p>
      </div>

      <!-- Metric 3 -->
      <div class="col-12 col-md-4">
        <h1 class="section-title counter" data-target="94">0</h1>
        <p class="metric-subtitle text-uppercase  head-color">Global Collaboration</p>
        <p class="metric-text">
          of attendees made a new global research or clinical connection
        </p>
      </div>
    </div>
  </div>
</section>
  <!-- 
<section class="milestone-section py-5 text-light animate-on-scroll">
  <div class="container">
    <div class="row align-items-start">

      <div class="col-lg-6 mb-4 mb-lg-0">
        <p class="text-uppercase small fw-bold text-light">Celebrating getting the work done at AO Foundation</p>
        <h2 class="display-5 fw-bold">The AO Foundation <br />Gala Awards</h2>
        <p class="mt-4">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla libero nisl, pretium nec lectus ut, venenatis euismod est. Vestibulum faucibus in eros imperdiet iaculis. Donec tincidunt blandit erat, sit amet placerat quam tempor eu. Suspendisse vitae urna non mauris tempor facilisis dapibus eget nisl. Nullam et malesuada dui. Aliquam blandit, libero at laoreet tempus, nisl orci vestibulum libero, a maximus turpis arcu ac odio. Nulla a elit viverra, facilisis augue et, accumsan est. Nam facilisis, purus sed mattis hendrerit, ligula lorem varius eros, vel pulvinar ipsum augue ut nulla. Sed iaculis auctor tempus. Maecenas sed vulputate mauris.        </p>

      </div>

      <div class="col-lg-6">
        <div class="timeline">
          <div class="timeline-item">
            <span class="timeline-dot"></span>
            <div>
              <p class="brandsecondary-color">September</p>
              <p class="timeline-desc">Nomination Period</p>
            </div>
          </div>
          <div class="timeline-item">
            <span class="timeline-dot"></span>
            <div>
              <p class="brandsecondary-color">October / November</p>
              <p class="timeline-desc">Judging Process</p>
            </div>
          </div>
          <div class="timeline-item active">
            <span class="timeline-dot highlight"></span>
            <div>
              <p class="brandsecondary-color fw-bold">December</p>
              <p class="timeline-desc fw-bold">Awards Listicle announced</p>
            </div>
          </div>
          <div class="timeline-item">
            <span class="timeline-dot"></span>
            <div>
              <p class="brandsecondary-color">January</p>
              <p class="timeline-desc">WEF Davos Uplift event</p>
            </div>
          </div>
          <div class="timeline-item">
            <span class="timeline-dot"></span>
            <div>
              <p class="brandsecondary-color">Feb–June</p>
              <p class="timeline-desc">Schedule of virtual and potentially in-person events for awardees+sponsors</p>
            </div>
          </div>
          <div class="timeline-item">
            <span class="timeline-dot"></span>
            <div>
              <p class="brandsecondary-color">June</p>
              <p class="timeline-desc">Awards dinner during LCAW</p>
            </div>
          </div>
          <div class="timeline-item">
            <span class="timeline-dot"></span>
            <div>
              <p class="brandsecondary-color">September</p>
              <p class="timeline-desc">New Nomination Period for Year 2</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
-->

<!-- CONTACT US -->
<div id="contact-success"></div>
<section id="contact" class="milestone-section">
  <div class="container py-5">
    <h2 class="text-center mb-4">Contact Us</h2>
    <p class="text-center mb-5">
      Have questions or ideas? Reach out and let's connect!
    </p>

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
          <input
            type="email"
            name="email"
            class="form-control"
            placeholder="Enter your email"
            aria-label="Email"
            style="background-color: rgba(255, 255, 255, 0.7);"
            value="{{ old('email') }}"
            required
          >
        </div>

        <div class="input-group mb-3">
          <input
            type="tel"
            name="phone"
            class="form-control"
            placeholder="Enter your phone number"
            aria-label="Phone"
            style="background-color: rgba(255, 255, 255, 0.7);"
            value="{{ old('phone') }}"
          >
        </div>

        <div class="input-group mb-3">
  <textarea
    name="message"
    class="form-control"
    rows="5"
    placeholder="Your message"
    aria-label="Message"
    required
    style="background-color: rgba(255, 255, 255, 0.7);"
  >{{ old('message') }}</textarea>
</div>

        <div class="text-center">
        <button type="submit"class="btn  rounded-pill" style="background-color:#ad715c; color:white;" > Send Message <span class="arrow">→</span></button>
        </div>

      </div>
    </form>
  </div>
</section>

<!-- Placeholder color fix -->
<style>
input::placeholder,
textarea::placeholder {
    color: white;
    opacity: 1;
}
</style>



  <hr class="text-light col-12">


@endsection