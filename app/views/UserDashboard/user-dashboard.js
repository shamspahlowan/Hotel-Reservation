const bookings = {
  "BOOK123": {
    checkInDate: "2025-05-18",
    checkOutDate: "2025-05-20",
    rateType: "standard",
    bookingAmount: 300,
    status: "checked-in"
  },
  "BOOK456": {
    checkInDate: "2025-06-01",
    checkOutDate: "2025-06-05",
    rateType: "nonrefundable",
    bookingAmount: 200,
    status: "upcoming"
  },
  "BOOK789": {
    checkInDate: "2025-05-10",
    checkOutDate: "2025-05-12",
    rateType: "peak",
    bookingAmount: 500,
    status: "past"
  }
};

function displayCurrentStay() {
  const currentDate = new Date("2025-05-19T21:04:00+06:00");
  const currentStayDiv = document.getElementById("currentStay");
  const conciergeBtn = document.getElementById("conciergeBtn");
  let hasCurrentStay = false;

  for (const bookingId in bookings) {
    const booking = bookings[bookingId];
    const checkIn = new Date(booking.checkInDate);
    const checkOut = new Date(booking.checkOutDate);

    if (currentDate >= checkIn && currentDate <= checkOut) {
      hasCurrentStay = true;
      currentStayDiv.innerHTML = `
        You are currently checked in.<br>
        Booking ID: <strong>${bookingId}</strong><br>
        Check-in: ${booking.checkInDate}<br>
        Check-out: ${booking.checkOutDate}<br>
        Rate Type: ${booking.rateType.charAt(0).toUpperCase() + booking.rateType.slice(1)}<br>
        Amount: $${booking.bookingAmount.toFixed(2)}
      `;
      conciergeBtn.style.display = "block";
      break;
    }
  }

  if (!hasCurrentStay) {
    currentStayDiv.textContent = "No active stays.";
    conciergeBtn.style.display = "none";
  }
}

function displayBookingHistory() {
  const tbody = document.getElementById("bookingHistory").querySelector("tbody");
  tbody.innerHTML = "";

  for (const bookingId in bookings) {
    const booking = bookings[bookingId];
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${bookingId}</td>
      <td>${booking.checkInDate}</td>
      <td>${booking.checkOutDate}</td>
      <td>${booking.rateType.charAt(0).toUpperCase() + booking.rateType.slice(1)}</td>
      <td>$${booking.bookingAmount.toFixed(2)}</td>
      <td>${booking.status.charAt(0).toUpperCase() + booking.status.slice(1)}</td>
    `;
    tbody.appendChild(row);
  }
}

window.onload = function () {
  displayCurrentStay();
  displayBookingHistory();
};
