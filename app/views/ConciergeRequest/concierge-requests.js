const bookings = {
  BOOK123: {
    guestName: "Shams",
    checkInDate: "2025-05-18",
    checkOutDate: "2025-05-20",
    rateType: "standard",
    bookingAmount: 300,
    status: "checked-in",
  },
  BOOK456: {
    guestName: "Ali",
    checkInDate: "2025-06-01",
    checkOutDate: "2025-06-05",
    rateType: "nonrefundable",
    bookingAmount: 200,
    status: "upcoming",
  },
  BOOK789: {
    guestName: "Fatima",
    checkInDate: "2025-05-10",
    checkOutDate: "2025-05-12",
    rateType: "peak",
    bookingAmount: 500,
    status: "past",
  },
};

// Simulated request database
let requests = [
  {
    id: "REQ001",
    service: "City Tour",
    price: 50,
    requestDate: "2025-05-19T10:00:00+06:00",
    preferredTime: "2025-05-20T09:00",
    details: "Morning tour preferred",
    status: "pending",
    fulfillment: "",
  },
  {
    id: "REQ002",
    service: "Dining Reservation",
    price: 0,
    requestDate: "2025-05-18T15:00:00+06:00",
    preferredTime: "2025-05-19T19:00",
    details: "Table for 4 at Ocean Bistro",
    status: "fulfilled",
    fulfillment: "Confirmed for 7:00 PM at Ocean Bistro",
  },
];

let currentService = "";
let currentPrice = 0;

function checkGuestStatus() {
  const currentDate = new Date("2025-05-19T22:44:00+06:00");
  const messageDiv = document.getElementById("checkin-message");
  const contentDiv = document.getElementById("concierge-content");
  const guestInfoDiv = document.getElementById("guest-info");
  let isCheckedIn = false;
  let checkedInBooking = null;

  for (const bookingId in bookings) {
    const booking = bookings[bookingId];
    const checkIn = new Date(booking.checkInDate);
    const checkOut = new Date(booking.checkOutDate);
    if (currentDate >= checkIn && currentDate <= checkOut) {
      isCheckedIn = true;
      checkedInBooking = { id: bookingId, ...booking };
      break;
    }
  }

  if (isCheckedIn) {
    messageDiv.textContent = "";
    contentDiv.style.display = "block";
    guestInfoDiv.innerHTML = `
          Welcome, <strong>${checkedInBooking.guestName}</strong><br>
          Booking ID: <strong>${checkedInBooking.id}</strong><br>
          Check-in: ${checkedInBooking.checkInDate}<br>
          Check-out: ${checkedInBooking.checkOutDate}<br>
          Rate Type: ${
            checkedInBooking.rateType.charAt(0).toUpperCase() +
            checkedInBooking.rateType.slice(1)
          }
        `;
    displayRequests();
  } else {
    messageDiv.textContent =
      "You must be checked in to access concierge services.";
    contentDiv.style.display = "none";
    guestInfoDiv.innerHTML = "";
  }
}

function showRequestForm(service, price) {
  currentService = service;
  currentPrice = price;
  document.getElementById("request-service").value = service;
  document.getElementById("request-title").textContent = `Request: ${service}`;
  document.getElementById("request-form").style.display = "block";
  document.getElementById("request-time").value = "";
  document.getElementById("request-details").value = "";
  document.getElementById("request-result").textContent = "";
  window.scrollTo({
    top: document.getElementById("request-form").offsetTop,
    behavior: "smooth",
  });
}

function submitRequest() {
  const service = currentService;
  const price = currentPrice;
  const preferredTime = document.getElementById("request-time").value;
  const details = document.getElementById("request-details").value.trim();
  const result = document.getElementById("request-result");

  if (!preferredTime) {
    result.innerHTML =
      '<span class="highlight">Please select a preferred time.</span>';
    return;
  }

  const requestId = `REQ${(requests.length + 1).toString().padStart(3, "0")}`;
  const request = {
    id: requestId,
    service,
    price,
    requestDate: new Date().toISOString(),
    preferredTime,
    details,
    status: "pending",
    fulfillment: "",
  };

  requests.push(request);
  document.getElementById("request-form").style.display = "none";
  result.innerHTML = `Request <span class="highlight">${requestId}</span> for ${service} submitted successfully!`;
  displayRequests();
}

function displayRequests() {
  const tbody = document.getElementById("request-table").querySelector("tbody");
  const filter = document.getElementById("status-filter").value;
  tbody.innerHTML = "";

  requests
    .filter((req) => filter === "all" || req.status === filter)
    .forEach((req) => {
      const row = document.createElement("tr");
      row.innerHTML = `
            <td>${req.work}</td>
            <td>${new Date(req.requestDate).toLocaleString()}</td>
            <td>${req.status.charAt(0).toUpperCase() + req.status.slice(1)}</td>
            <td>${req.details || "None"} (Preferred: ${req.preferredTime})</td>
            <td>${req.fulfillment || "N/A"}</td>
          `;
      tbody.appendChild(row);
    });
}

function filterRequests() {
  displayRequests();
}

window.onload = checkGuestStatus;
