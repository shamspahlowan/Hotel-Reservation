const hotels = {
  oceanview: { name: "Oceanview Resort", basePrice: 200 },
  cityscape: { name: "Cityscape Hotel", basePrice: 150 },
  mountainlodge: { name: "Mountain Lodge", basePrice: 180 },
};

const rooms = {
  standard: { name: "Standard", price: 100 },
  deluxe: { name: "Deluxe", price: 150 },
  suite: { name: "Suite", price: 200 },
};

const eventSpaces = {
  none: { name: "None", price: 0 },
  conference: { name: "Conference Room", price: 500 },
  banquet: { name: "Banquet Hall", price: 1000 },
};

let guests = [];
let selectedRooms = [];

function showTab(tabId) {
  document
    .querySelectorAll(".tab")
    .forEach((tab) => tab.classList.remove("active"));
  document
    .querySelectorAll(".tab-content")
    .forEach((content) => content.classList.remove("active"));
  document
    .querySelector(`[onclick="showTab('${tabId}')"]`)
    .classList.add("active");
  document.getElementById(tabId).classList.add("active");
}

function addGuest() {
  const name = document.getElementById("guest-name").value.trim();
  const email = document.getElementById("guest-email").value.trim();
  const guestList = document.getElementById("guest-list");

  if (name === "" || email === "") {
    guestList.innerHTML =
      '<span class="highlight">Please enter guest name and email.</span>';
    return;
  }

  guests.push({ name, email });
  document.getElementById("guest-name").value = "";
  document.getElementById("guest-email").value = "";
  updateGuestList();
}

function updateGuestList() {
  const guestList = document.getElementById("guest-list");
  guestList.innerHTML = guests.length === 0 ? "No guests added." : "";
  guests.forEach((guest, index) => {
    const div = document.createElement("div");
    div.className = "guest-entry";
    div.innerHTML = `
          ${guest.name} (${guest.email})
          <button class="remove-guest" onclick="removeGuest(${index})">Remove</button>
        `;
    guestList.appendChild(div);
  });
}

function removeGuest(index) {
  guests.splice(index, 1);
  updateGuestList();
}

function addRoom() {
  const roomType = document.getElementById("room-type").value;
  const quantity =
    parseInt(document.getElementById("room-quantity").value) || 0;
  const roomList = document.getElementById("room-list");

  if (quantity <= 0) {
    roomList.innerHTML =
      '<span class="highlight">Please enter a valid room quantity.</span>';
    return;
  }

  selectedRooms.push({ type: roomType, quantity });
  document.getElementById("room-quantity").value = "";
  updateRoomList();
}

function updateRoomList() {
  const roomList = document.getElementById("room-list");
  roomList.innerHTML = selectedRooms.length === 0 ? "No rooms added." : "";
  selectedRooms.forEach((room, index) => {
    const div = document.createElement("div");
    div.innerHTML = `
          ${room.quantity} x ${rooms[room.type].name} ($${
      rooms[room.type].price
    }/night)
          <button class="remove-guest" onclick="removeRoom(${index})">Remove</button>
        `;
    roomList.appendChild(div);
  });
}

function removeRoom(index) {
  selectedRooms.splice(index, 1);
  updateRoomList();
}

function calculateNights(checkIn, checkOut) {
  const checkInDate = new Date(checkIn);
  const checkOutDate = new Date(checkOut);
  const timeDiff = checkOutDate - checkInDate;
  return Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
}

function submitSingleBooking() {
  const hotel = document.getElementById("single-hotel").value;
  const roomType = document.getElementById("single-room").value;
  const checkIn = document.getElementById("single-checkin").value;
  const checkOut = document.getElementById("single-checkout").value;
  const result = document.getElementById("single-result");

  const currentDate = new Date("2025-05-19");
  const checkInDate = new Date(checkIn);
  const checkOutDate = new Date(checkOut);

  if (!hotel || !roomType || !checkIn || !checkOut) {
    result.innerHTML = '<span class="highlight">Please fill all fields.</span>';
    return;
  }

  if (checkInDate < currentDate || checkOutDate <= checkInDate) {
    result.innerHTML =
      '<span class="highlight">Invalid dates. Check-in must be today or later, and check-out must be after check-in.</span>';
    return;
  }

  const nights = calculateNights(checkIn, checkOut);
  const totalCost = (hotels[hotel].basePrice + rooms[roomType].price) * nights;

  result.innerHTML = `
        <strong>Booking Confirmation</strong><br>
        Hotel: ${hotels[hotel].name}<br>
        Room Type: ${rooms[roomType].name}<br>
        Check-in: ${checkIn}<br>
        Check-out: ${checkOut}<br>
        Nights: ${nights}<br>
        Total Cost: <span class="highlight">$${totalCost.toFixed(2)}</span><br>
        Your booking has been submitted!
      `;
}

function submitGroupBooking() {
  const hotel = document.getElementById("group-hotel").value;
  const checkIn = document.getElementById("group-checkin").value;
  const checkOut = document.getElementById("group-checkout").value;
  const paymentTerms = document.getElementById("payment-terms").value;
  const eventSpace = document.getElementById("event-space").value;
  const result = document.getElementById("group-result");

  const currentDate = new Date("2025-05-19");
  const checkInDate = new Date(checkIn);
  const checkOutDate = new Date(checkOut);

  if (
    !hotel ||
    !checkIn ||
    !checkOut ||
    guests.length === 0 ||
    selectedRooms.length === 0
  ) {
    result.innerHTML =
      '<span class="highlight">Please fill all fields, add at least one guest, and select at least one room.</span>';
    return;
  }

  if (checkInDate < currentDate || checkOutDate <= checkInDate) {
    result.innerHTML =
      '<span class="highlight">Invalid dates. Check-in must be today or later, and check-out must be after check-in.</span>';
    return;
  }

  const nights = calculateNights(checkIn, checkOut);
  let roomCost = 0;
  selectedRooms.forEach((room) => {
    roomCost += rooms[room.type].price * room.quantity * nights;
  });
  const hotelCost = hotels[hotel].basePrice * nights;
  const eventCost = eventSpaces[eventSpace].price;
  const totalCost = hotelCost + roomCost + eventCost;

  let guestList = guests.map((g) => `${g.name} (${g.email})`).join("<br>");
  let roomSummary = selectedRooms
    .map((r) => `${r.quantity} x ${rooms[r.type].name}`)
    .join("<br>");

  result.innerHTML = `
        <strong>Group Booking Confirmation</strong><br>
        Hotel: ${hotels[hotel].name}<br>
        Check-in: ${checkIn}<br>
        Check-out: ${checkOut}<br>
        Nights: ${nights}<br>
        Guests:<br>${guestList}<br>
        Rooms:<br>${roomSummary}<br>
        Payment Terms: ${
          paymentTerms.charAt(0).toUpperCase() + paymentTerms.slice(1)
        }<br>
        Event Space: ${eventSpaces[eventSpace].name}<br>
        Total Cost: <span class="highlight">$${totalCost.toFixed(2)}</span><br>
        Your group booking has been submitted!
      `;
}
