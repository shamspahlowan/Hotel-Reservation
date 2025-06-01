const rooms = [
    {
        name: "City Comfort",
        category: "Standard",
        image: "/Hotel-Reservation/public/assets/room10.jpeg",
        amenities: ["Wi-Fi", "TV", "AC"]
    },
    {
        name: "Seaside Bliss",
        category: "Deluxe",
        image: "/Hotel-Reservation/public/assets/room9.jpeg",
        amenities: ["Wi-Fi", "TV", "AC", "Mini Fridge"]
    },
    {
        name: "Presidential Suite",
        category: "Suite",
        image: "/Hotel-Reservation/public/assets/room11.jpeg",
        amenities: ["Wi-Fi", "TV", "AC", "Jacuzzi", "Balcony"]
    }
];
const allAmenities = ["Wi-Fi", "TV", "AC", "Mini Fridge", "Jacuzzi", "Balcony"];

function renderRooms(filter) {
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
                <p><strong>Category:</strong> ${room.category}</p>
                <p><strong>Amenities:</strong> ${room.amenities.join(", ")}</p>
                <div class="room-buttons">
                    <button onclick="window.location.href=''">360 View</button>
                    
                </div>
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
            cells.push(hasAmenity ? "available" : "not available");
        });

        row.innerHTML = cells.map(cell => `<td>${cell}</td>`).join("");
        tbody.appendChild(row);
    });
}

document.getElementById("filterForm").addEventListener("submit", function(event) {
    const select = document.getElementById("categorySelect");
    const value = select.value;
    const validOptions = ["", "Standard", "Deluxe", "Suite"];
    
    if (!validOptions.includes(value)) {
        event.preventDefault();
        const errorElement = document.createElement("p");
        errorElement.style.color = "red";
        errorElement.style.fontSize = "0.9rem";
        errorElement.style.textAlign = "center";
        errorElement.textContent = "Invalid room category selected.";
        const filterBar = document.querySelector(".filter-bar");
        const existingError = filterBar.querySelector("p");
        if (existingError) existingError.remove();
        filterBar.appendChild(errorElement);
        return;
    }
});

renderRooms(filter);
renderAmenityComparison();
