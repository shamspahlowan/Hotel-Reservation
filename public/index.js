function scrollToSection(id) {
    const el = document.getElementById(id);
    if (el) {
      el.scrollIntoView({ behavior: 'smooth' });
    }
  }
  
  const imageFolderPath = 'assets';
  const imageCount = 8;
  const imagePrefix = 'room';
  const imageExtension = 'jpg';
  
  function loadCarouselImages() {
    const wrapper = document.getElementById('carousel-wrapper');
    const heroWrapper = document.getElementById('hero-carousel');
  
    for (let i = 1; i <= imageCount; i++) {
      const src = `${imageFolderPath}/${imagePrefix}${i}.${imageExtension}`;
  
      const img1 = document.createElement('img');
      img1.src = src;
      img1.alt = `Room ${i}`;
      img1.className = 'carousel-image';
      wrapper.appendChild(img1);
  
      const img2 = document.createElement('img');
      img2.src = src;
      img2.alt = `Hero Background ${i}`;
      heroWrapper.appendChild(img2);
    }
  }
  
  document.getElementById('signup-form').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('Signup submitted');
  });
  
  window.addEventListener('DOMContentLoaded', loadCarouselImages);
  