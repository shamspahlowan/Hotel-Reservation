const rooms = [
    {
      name: "City Comfort",
      category: "Standard",
      image: "images/standard1.jpg", 
      amenities: ["Wi-Fi", "TV", "AC"]
    },
    {
      name: "Seaside Bliss",
      category: "Deluxe",
      image: "images/deluxe1.jpg",
      amenities: ["Wi-Fi", "TV", "AC", "Mini Fridge"]
    },
    {
      name: "Presidential Suite",
      category: "Suite",
      image: "image/assets/pexels-zachtheshoota-1861153.jpg",
      amenities: ["Wi-Fi", "TV", "AC", "Jacuzzi", "Balcony"]
    }
  ];
  
  const allAmenities = ["Wi-Fi", "TV", "AC", "Mini Fridge", "Jacuzzi", "Balcony"];
  
  function renderRooms(filter = "") {
    const list = document.getElementById("roomList");
    list.innerHTML = "";
  
    const filtered = filter ? rooms.filter(r => r.category === filter) : rooms;
  
    filtered.forEach(room => {
      const div = document.createElement("div");
      div.className = "room-card";
      div.innerHTML = `
        <img src="${room.image}" alt="${room.name}" />
        <div>
          <h4>${room.name}</h4>
          <p>Category: ${room.category}</p>
          <p>Amenities: ${room.amenities.join(", ")}</p>
          <button onclick="openModal()">View 360° Tour</button>
        </div>
      `;
      list.appendChild(div);
    });
  }
  
  function renderAmenityComparison() {
    const tbody = document.getElementById("amenitiesTable");
    tbody.innerHTML = "";
  
    allAmenities.forEach(amenity => {
      const row = document.createElement("tr");
      const cells = [amenity];
  
      ["Standard", "Deluxe", "Suite"].forEach(cat => {
        const room = rooms.find(r => r.category === cat);
        const hasAmenity = room?.amenities.includes(amenity);
        cells.push(hasAmenity ? "✔️" : "❌");
      });
  
      row.innerHTML = cells.map(cell => `<td>${cell}</td>`).join("");
      tbody.appendChild(row);
    });
  }
  
  function openModal() {
    document.getElementById("tourModal").style.display = "flex";
  }
  
  function closeModal() {
    document.getElementById("tourModal").style.display = "none";
  }
  
  document.getElementById("categorySelect").addEventListener("change", function () {
    renderRooms(this.value);
  });
  
  renderRooms();
  renderAmenityComparison();
  