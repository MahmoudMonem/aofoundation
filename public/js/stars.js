const starCount = 80; // increase for more stars

for (let i = 0; i < starCount; i++) {
  const star = document.createElement('div');
  star.className = 'star';

  // Random position across the viewport
  star.style.top = `${Math.random() * 100}vh`;
  star.style.left = `${Math.random() * 100}vw`;

  // Random delay so stars twinkle at different times
  star.style.animationDelay = `${Math.random() * 10}s`;

  // Random animation duration for more variation
  star.style.animationDuration = `${5 + Math.random() * 15}s`; // longer duration = slower

  // Random size (between 1px and 3px)
  const size = Math.random() * 2 + 1;
  star.style.width = `${size}px`;
  star.style.height = `${size}px`;

  document.body.appendChild(star);
}
