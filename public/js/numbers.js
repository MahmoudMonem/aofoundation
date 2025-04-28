document.addEventListener("DOMContentLoaded", function () {
    const counters = document.querySelectorAll(".counter");
  
    const animateCounter = (counter) => {
      const target = +counter.getAttribute("data-target");
      let count = 0;
      const speed = 300; // Lower is faster
  
      const updateCount = () => {
        const increment = Math.ceil((target - count) / 8);
        count += increment;
        if (count < target) {
          counter.textContent = count;
          requestAnimationFrame(updateCount);
        } else {
          counter.textContent = target + (counter.dataset.percent ? "%" : "");
        }
      };
  
      updateCount();
    };
  
    const observer = new IntersectionObserver(
      (entries, observer) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            animateCounter(entry.target);
            observer.unobserve(entry.target); // Only animate once
          }
        });
      },
      { threshold: 0.6 }
    );
  
    counters.forEach((counter) => {
      observer.observe(counter);
    });
  });
  