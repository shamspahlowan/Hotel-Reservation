const rooms = [
  {
    name: "Ocean View",
    location: "Cox's Bazar",
    price: 90,
    type: "Double",
    amenities: ["Wi-Fi", "AC"],
  },
  {
    name: "Mountain Retreat",
    location: "Bandarban",
    price: 150,
    type: "Suite",
    amenities: ["Wi-Fi"],
  },
  {
    name: "City Stay",
    location: "Dhaka",
    price: 80,
    type: "Single",
    amenities: ["AC"],
  },
  {
    name: "Luxury Palace",
    location: "Sylhet",
    price: 220,
    type: "Suite",
    amenities: ["Wi-Fi", "AC"],
  },
];

const searchInput = document.getElementById("searchInput");
const roomType = document.getElementById("roomType");
const priceRange = document.getElementById("priceRange");
const wifiCheck = document.getElementById("wifi");
const acCheck = document.getElementById("ac");
const resultsDiv = document.getElementById("results");

function displayRooms(filteredRooms) {
  resultsDiv.innerHTML = "";
  if (filteredRooms.length === 0) {
    resultsDiv.innerHTML = "<p>No matching rooms found.</p>";
    return;
  }

  filteredRooms.forEach((room) => {
    const div = document.createElement("div");
    div.className = "room-card";
    div.innerHTML = `
      <strong>${room.name}</strong><br/>
      Location: ${room.location}<br/>
      Type: ${room.type}<br/>
      Price: $${room.price}<br/>
      Amenities: ${room.amenities.join(", ")}
    `;
    resultsDiv.appendChild(div);
  });
}

function filterRooms() {
  const keyword = searchInput.value.toLowerCase();
  const selectedType = roomType.value;
  const selectedPrice = priceRange.value;
  const wantWiFi = wifiCheck.checked;
  const wantAC = acCheck.checked;

  let filtered = rooms.filter((room) => {
    const matchesKeyword =
      room.name.toLowerCase().includes(keyword) ||
      room.location.toLowerCase().includes(keyword);
    const matchesType = !selectedType || room.type === selectedType;

    let matchesPrice = true;
    if (selectedPrice) {
      const [min, max] = selectedPrice.split("-").map(Number);
      matchesPrice = room.price >= min && room.price <= max;
    }

    const matchesWiFi = !wantWiFi || room.amenities.includes("Wi-Fi");
    const matchesAC = !wantAC || room.amenities.includes("AC");

    return (
      matchesKeyword && matchesType && matchesPrice && matchesWiFi && matchesAC
    );
  });

  displayRooms(filtered);
}

function initializeSearch() {
  const params = new URLSearchParams(window.location.search);
  const destination = params.get("destination") || "";
  const guests = params.get("guests") || "";

  // Pre-fill search input with destination
  searchInput.value = destination;

  // Infer room type from guests
  let inferredType = "";
  if (guests === "1 Adult") {
    inferredType = "Single";
  } else if (guests === "2 Adults") {
    inferredType = "Double";
  } else if (guests.includes("Child") || guests === "More options") {
    inferredType = "Suite";
  }
  if (inferredType) {
    roomType.value = inferredType;
  }


  filterRooms();
}

searchInput.addEventListener("input", filterRooms);
roomType.addEventListener("change", filterRooms);
priceRange.addEventListener("change", filterRooms);
wifiCheck.addEventListener("change", filterRooms);
acCheck.addEventListener("change", filterRooms);


document.addEventListener("DOMContentLoaded", initializeSearch);
