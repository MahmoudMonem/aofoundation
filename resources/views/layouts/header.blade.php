<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.0/gsap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


  <link rel="stylesheet" href="{{ asset('css/theme.css') }}">

  <link href="/css/cosmo.css" rel="stylesheet">
  <link href="/css/theme.css" rel="stylesheet">

  <link href="/css/milestone.css" rel="stylesheet">

  <link rel="icon" href="images/logo.png" type="image/png">
  
  <title>AO International Projects Management</title>


  <style>
.logo-wrapper {

  overflow: hidden;
  position: relative;
  width: 100%;
  height: 200px;
  background-color:black;
}

.logo-track {
  position: absolute;
  width: 200%;
  display: flex;
  top: 0;
  left: 0;
}

.logo-strip {
  display: flex;
  animation: scroll-left 30s linear infinite;
  animation-timing-function: linear;
  animation-iteration-count: infinite;
  animation-name: scroll-left;
  gap: 5rem;
  background-color:black;
}

.row2 .logo-strip {

  animation: scroll-right 30s linear infinite;
}

.logo-strip img {
  height: 80px;
  width: auto;
  object-fit: contain;
}

@keyframes scroll-left {
  0% { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

@keyframes scroll-right {
  0% { transform: translateX(0); }
  100% { transform: translateX(50%); }
}

@media (max-width: 768px) {
  .logo-wrapper {
    height: 150px;
   
  }

  .logo-strip img {
    height: 60px;
  }
}

.animate-on-scroll {
  opacity: 0;
  transform: translateY(40px);
  transition: opacity 0.8s ease-out, transform 1.8s ease-out;
}



.animate-on-scroll.visible {
  opacity: 1;
  transform: translateY(0);
}
    </style>
</head>

<body>




 
<main>
  <!-- HEADER -->
  <nav class="navbar navbar-expand-md navbar-dark nav-dark">
    <div class="container">
      <a href="/" class="navbar-brand d-flex align-items-center">
        <img src="images/logo.png" alt="AO International Projects Management Logo" width="200" height="auto" class="me-2">
        <!-- Optional text below logo if needed -->
        <!-- <span class="fw-bold text-white">AO International</span> -->
      </a>


      <!-- Burger button for mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Collapsible nav links -->
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto mb-2 mb-md-0">
          <li class="nav-item"><a href="#home" class="nav-link brandsecondary-color" aria-current="page">Home</a></li>
          <li class="nav-item"><a href="#about" class="nav-link text-light">About</a></li>
          <li class="nav-item"><a href="#events" class="nav-link text-light">Events</a></li>
          <li class="nav-item"><a href="#core-services" class="nav-link text-light">Services</a></li>
          <li class="nav-item"><a href="#clients" class="nav-link text-light">Clients</a></li>
          <li class="nav-item"><a href="#contact" class="nav-link text-light">Contact</a></li>
    @guest 
          <li class="nav-item"><a href="/register" class="nav-link text-light"><i class="far fa-user"></i></a></li>

    @endguest
          
    @auth
            <!-- User dropdown -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                @if(Auth::user()->roles->isNotEmpty())
                  <li>
                    <a class="dropdown-item text-dark" href="{{ url('/admin/dashboard') }}">Dashboard</a>
                  </li>
                @endif
                <li>
                  <a class="dropdown-item text-dark" href="{{ route('logout') }}"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                  </a>
                </li>
              </ul>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>
</main>

