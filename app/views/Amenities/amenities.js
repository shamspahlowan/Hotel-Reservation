// amenities.js
const amenities = [
  {
    name: "Spa & Wellness",
    description: "Relaxing massages, steam rooms, and luxury treatments for body and mind.",
    image: "../../public/images/spa.jpg",
    hours: "8:00 AM – 9:00 PM"
  },
  {
    name: "Fitness Center",
    description: "State-of-the-art gym equipment and fitness trainers available daily.",
    image: "../../public/images/gym.jpg",
    hours: "6:00 AM – 10:00 PM"
  },
  {
    name: "Swimming Pool",
    description: "Outdoor pool with sunbeds, bar service, and lifeguards.",
    image: "../../public/images/pool.jpg",
    hours: "7:00 AM – 8:00 PM"
  },
  {
    name: "Kids Play Zone",
    description: "Safe and fun space for children with staff supervision.",
    image: "../../public/images/playzone.jpg",
    hours: "10:00 AM – 6:00 PM"
  },
  {
    name: "Business Center",
    description: "Private meeting rooms, high-speed internet, and printing facilities.",
    image: "../../public/images/business.jpg",
    hours: "24/7"
  }
];

const amenityList = document.getElementById("amenityList");
const searchBox = document.getElementById("searchBox");

function renderAmenities(filtered) {
  amenityList.innerHTML = "";
  filtered.forEach(item => {
    const card = document.createElement("div");
    card.className = "amenity-card";
    card.innerHTML = `
      <img src="${item.image}" alt="${item.name}" />
      <h4>${item.name}</h4>
      <p>${item.description}</p>
      <p><strong>Hours:</strong> ${item.hours}</p>
    `;
    amenityList.appendChild(card);
  });
}

searchBox.addEventListener("input", () => {
  const term = searchBox.value.toLowerCase();
  const filtered = amenities.filter(item =>
    item.name.toLowerCase().includes(term) ||
    item.description.toLowerCase().includes(term)
  );
  renderAmenities(filtered);
});


if (typeof initialSearch !== 'undefined' && initialSearch.length > 0) {
  searchBox.value = initialSearch;
  const term = initialSearch.toLowerCase();
  const filtered = amenities.filter(item =>
    item.name.toLowerCase().includes(term) ||
    item.description.toLowerCase().includes(term)
  );
  renderAmenities(filtered);
} else {
  renderAmenities(amenities);
}
