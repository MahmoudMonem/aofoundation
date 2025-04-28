document.addEventListener('scroll', function() {
    const globe = document.querySelector('.globe');
    const heroSection = document.getElementById('hero');
    const scrollY = window.scrollY;
    const heroHeight = heroSection.offsetHeight;
    
    // Scale the globe up using GSAP
    gsap.to(globe, {
      scale: 1 + scrollY / 500,  // Adjust the factor for the scaling speed
      opacity: Math.max(1 - (scrollY / heroHeight), 0),  // Ensure opacity doesn't go below 0
      ease: "power1.out"  // Smooth easing effect
    });
  });
  