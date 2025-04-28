window.addEventListener("DOMContentLoaded", () => {
    const row1 = document.querySelector(".row1 .logo-strip");
    const row2 = document.querySelector(".row2 .logo-strip");
  
    const speed1 = Math.floor(Math.random() * 20 + 100); // 100–120s
    const speed2 = Math.floor(Math.random() * 20 + 110); // 110–130s
  
    row1.style.animationDuration = `${speed1}s`;
    row2.style.animationDuration = `${speed2}s`;
  });
  