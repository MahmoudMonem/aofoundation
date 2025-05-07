<footer class=" text-white py-5">
  <div class="container">
    <div class="row">
      
      <!-- Left: Logo + Downloads -->
      <div class="col-md-4 mb-4 mb-md-0 text-center text-md-start">
        <img src="images/logo.png" alt="AO Logo" style="max-width: 120px;" class="mb-3">
        <h5 class="mb-3">Where stories come together.</h5>
        <div class="d-flex flex-column flex-sm-row gap-2">

        </div>
        <div class="mt-4 d-flex gap-3 justify-content-center justify-content-md-start">
          <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-white"><i class="fab fa-threads"></i></a>
          <a href="#" class="text-white"><i class="fab fa-youtube"></i></a>
          <a href="#" class="text-white"><i class="fab fa-tiktok"></i></a>
          <a href="#" class="text-white"><i class="fab fa-linkedin"></i></a>
          <a href="#" class="text-white"><i class="fab fa-x-twitter"></i></a>
        </div>
      </div>

      <!-- Middle: Info Links -->
      <div class="col-md-4 mb-4 mb-md-0">

        <ul class="list-unstyled">
          <li class="mb-2"><br><strong class="brandsecondary-color">Visit us:</strong><br>KIPCO Tower, Khalid Bin Al Waleed Street, Sharq, Kuwait City</li>
          <li class="mb-2"><br><strong class="brandsecondary-color">Email us:</strong><br>
            <a href="mailto:faten@ao-project.com" class="text-white text-decoration-underline">faten@ao-project.com</a>
          </li>
             <!--   <li><br><strong class="brandsecondary-color">Call us:</strong><br>
            <a href="tel:+96566303777" class="text-white text-decoration-none">+965 66303777</a>
          </li>-->
        </ul>
      </div>

      <!-- Right: Tags/Topics -->
      <div class="col-md-4">
        <h6 class="fw-bold">Highlights</h6>
        <div class="d-flex flex-wrap gap-2">
          <span class="badge bg-light text-dark">Innovation</span>
          <span class="badge bg-light text-dark">Technology</span>
          <span class="badge bg-light text-dark">Community</span>
          <span class="badge bg-light text-dark">Leadership</span>
        </div>
      </div>

    </div>

    <!-- Bottom -->
    <div class="mt-5 d-flex flex-column flex-md-row justify-content-between align-items-center">
      <p class="mb-2 mb-md-0">© 2025 AO Foundation</p>
      <div class="d-flex gap-3">
        <a href="{{route('tocPage')}}" class="text-white text-decoration-none">Terms of Use</a>
        <a href="{{route('ppPage')}}" class="text-white text-decoration-none">Privacy Policy</a>
      <!--   <a href="#" class="text-white text-decoration-none">License</a>
        <a href="#" class="text-white text-decoration-none">Cookies</a>-->
      </div>
    </div>
  </div>
</footer>



  <script src="/js/stars.js"></script>

  <script src="js/logo.js"></script>
  <script src="/js/globe.js"></script>
  <script src="/js/numbers.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


  <script>
  document.addEventListener("DOMContentLoaded", function () {
    const animatedElements = document.querySelectorAll(".animate-on-scroll");

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add("visible");
        }
      });
    }, {
      threshold: 0.1
    });

    animatedElements.forEach(el => observer.observe(el));
  });
</script>
<div id="starfield"></div>
</body>
</html>
