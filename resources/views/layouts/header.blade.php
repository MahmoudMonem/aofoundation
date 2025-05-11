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
  <div class="container nav-dark">
    <header class="d-flex flex-wrap justify-content-center py-3 mb-4">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
  <img src="images/logo.png" alt="AO International Projects Management Logo" width="200" height="auto" class="me-2">
  <div>
     <!--
  <div class="fw-bold text-white" style="font-size: 1.5rem;">اي او انترناشيونال لإدارة المشاريع</div>
  <div class="fw-bold text-white">International <span class="fw-normal">Projects Management</span></div>
  -->
  </div>
</a>

<ul class="nav nav-pills">
  <li class="nav-item"><a href="#home" class="nav-link brandsecondary-color" aria-current="page">Home</a></li>
  <li class="nav-item"><a href="#about" class="nav-link text-light">About</a></li>
  <li class="nav-item"><a href="#events" class="nav-link text-light">Events</a></li>
  <li class="nav-item"><a href="#core-services" class="nav-link text-light">Services</a></li>
  <li class="nav-item"><a href="#clients" class="nav-link text-light">Clients</a></li>
  <li class="nav-item"><a href="#contact" class="nav-link text-light">Contact</a></li>
</ul>
    </header>
</main>
