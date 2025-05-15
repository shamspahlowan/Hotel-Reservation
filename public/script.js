document.addEventListener("DOMContentLoaded", function () {
  // Configuration
  const sliderConfig = {
    // These would be your actual image paths
    images: [
      {
        path: "assets/room1.jpg",
        title: "Luxury Ocean View Suite",
        description:
          "Experience unparalleled luxury with panoramic ocean views.",
      },
      {
        path: "assets/room2.jpg",
        title: "Modern Mountain Retreat",
        description:
          "Escape to the tranquility of our mountain hideaways.",
      },
      {
        path: "assets/room3.jpg",
        title: "Urban Sanctuary",
        description:
          "Find peace in the heart of the city with our centrally located accommodations.",
      },
      {
        path: "assets/room4.jpg",
        title: "Beachfront Paradise",
        description:
          "Step directly onto pristine beaches from your private terrace.",
      },
    ],
    autoplay: true,
    interval: 5000, // 5 seconds
    transitionSpeed: 500, // 0.5 seconds
  };

  // Elements
  const sliderTrack = document.querySelector(".slider-track");
  const pagination = document.querySelector(".slider-pagination");
  const prevButton = document.querySelector(".slider-prev");
  const nextButton = document.querySelector(".slider-next");

  let currentSlide = 0;
  let slideCount = sliderConfig.images.length;
  let autoplayInterval;

  // Initialize slider
  function initSlider() {
    // Create slides
    sliderConfig.images.forEach((image, index) => {
      const slide = document.createElement("div");
      slide.className = "slider-slide";

      slide.innerHTML = `
                <img class="slider-image" src="${image.path}" alt="${image.title}">
                <div class="slider-content">
                    <h2>${image.title}</h2>
                    <p>${image.description}</p>
                </div>
            `;

      sliderTrack.appendChild(slide);

      // Create pagination dot
      const dot = document.createElement("div");
      dot.className = "slider-dot";
      if (index === 0) dot.classList.add("active");
      dot.addEventListener("click", () => goToSlide(index));
      pagination.appendChild(dot);
    });

    // Set up events
    prevButton.addEventListener("click", prevSlide);
    nextButton.addEventListener("click", nextSlide);

    // Start autoplay
    if (sliderConfig.autoplay) {
      startAutoplay();

      // Pause autoplay on hover
      const sliderContainer = document.querySelector(".slider-container");
      sliderContainer.addEventListener("mouseenter", stopAutoplay);
      sliderContainer.addEventListener("mouseleave", startAutoplay);
    }

    // Handle keyboard navigation
    document.addEventListener("keydown", function (e) {
      if (e.key === "ArrowLeft") prevSlide();
      if (e.key === "ArrowRight") nextSlide();
    });

    // Update on resize for responsive behavior
    window.addEventListener("resize", updateSliderHeight);
    updateSliderHeight();
  }

  function updateSliderHeight() {
    // Optional: Adjust slider height based on window width for responsive design
    const windowWidth = window.innerWidth;
    const sliderContainer = document.querySelector(".image-slider");

    if (windowWidth < 768) {
      sliderContainer.style.height = "400px";
    } else {
      sliderContainer.style.height = "600px";
    }
  }

  function goToSlide(index) {
    currentSlide = index;
    updateSlider();
  }

  function nextSlide() {
    currentSlide = (currentSlide + 1) % slideCount;
    updateSlider();
  }

  function prevSlide() {
    currentSlide = (currentSlide - 1 + slideCount) % slideCount;
    updateSlider();
  }

  function updateSlider() {
    // Update track position
    sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;

    // Update pagination
    const dots = pagination.querySelectorAll(".slider-dot");
    dots.forEach((dot, index) => {
      if (index === currentSlide) {
        dot.classList.add("active");
      } else {
        dot.classList.remove("active");
      }
    });

    // Reset autoplay
    if (sliderConfig.autoplay) {
      stopAutoplay();
      startAutoplay();
    }
  }

  function startAutoplay() {
    autoplayInterval = setInterval(nextSlide, sliderConfig.interval);
  }

  function stopAutoplay() {
    clearInterval(autoplayInterval);
  }

  // Initialize the slider
  initSlider();
});