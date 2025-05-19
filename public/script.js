document.addEventListener("DOMContentLoaded", function () {
  // Configuration
  const sliderConfig = {
    images: [
      {
        path: "assets/room1.jpg",
        title: "Luxury Ocean View Suite",
        description: "Experience unparalleled luxury with panoramic ocean views.",
      },
      {
        path: "assets/room2.jpg",
        title: "Modern Mountain Retreat",
        description: "Escape to the tranquility of our mountain hideaways.",
      },
      {
        path: "assets/room3.jpg",
        title: "Urban Sanctuary",
        description: "Find peace in the heart of the city with our centrally located accommodations.",
      },
      {
        path: "assets/room4.jpg",
        title: "Beachfront Paradise",
        description: "Step directly onto pristine beaches from your private terrace.",
      },
    ],
    autoplay: true,
    interval: 5000,
    transitionSpeed: 500,
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
      const dot = document.createElement("div");
      dot.className = "slider-dot";
      if (index === 0) dot.classList.add("active");
      dot.addEventListener("click", () => goToSlide(index));
      pagination.appendChild(dot);
    });

    prevButton.addEventListener("click", prevSlide);
    nextButton.addEventListener("click", nextSlide);

    if (sliderConfig.autoplay) {
      startAutoplay();
      const sliderContainer = document.querySelector(".slider-container");
      sliderContainer.addEventListener("mouseenter", stopAutoplay);
      sliderContainer.addEventListener("mouseleave", startAutoplay);
    }

    document.addEventListener("keydown", function (e) {
      if (e.key === "ArrowLeft") prevSlide();
      if (e.key === "ArrowRight") nextSlide();
    });

    window.addEventListener("resize", updateSliderHeight);
    updateSliderHeight();
  }

  function updateSliderHeight() {
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
    sliderTrack.style.transform = `translateX(-${currentSlide * 100}%)`;
    const dots = pagination.querySelectorAll(".slider-dot");
    dots.forEach((dot, index) => {
      if (index === currentSlide) {
        dot.classList.add("active");
      } else {
        dot.classList.remove("active");
      }
    });
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

  // Search form handler
  const searchForm = document.getElementById("search-form");
  const searchButton = document.getElementById("search-button");
  searchButton.addEventListener("click", function (event) {
    event.preventDefault();
    const destination = document.getElementById("destination").value.trim();
    const checkin = document.getElementById("checkin").value;
    const checkout = document.getElementById("checkout").value;
    const guests = document.getElementById("guests").value;
    const params = new URLSearchParams({
      destination: destination,
      checkin: checkin,
      checkout: checkout,
      guests: guests
    });
    window.location.href = `search.?${params.toString()}`;
  });

  // Initialize the slider
  initSlider();
});