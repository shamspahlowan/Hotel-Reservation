// Simulated booking database
const bookings = {
  "BOOK123": {
    checkInDate: "2025-05-25",
    rateType: "standard",
    bookingAmount: 300
  },
  "BOOK456": {
    checkInDate: "2025-06-01",
    rateType: "nonrefundable",
    bookingAmount: 200
  },
  "BOOK789": {
    checkInDate: "2025-05-20",
    rateType: "peak",
    bookingAmount: 500
  }
};

// Policies for reference
const policies = {
  standard: "Free cancellation up to 48 hours before check-in. Late cancellation incurs one night’s charge.",
  nonrefundable: "This rate is non-refundable. No cancellations or modifications allowed.",
  peak: "Cancellations within 14 days of check-in are non-refundable. Outside this, 50% refund available."
};

function displayPolicy() {
  const rate = document.getElementById("rateSelect").value;
  document.getElementById("policyText").textContent = policies[rate];
}

function processBooking() {
  const bookingId = document.getElementById("bookingId").value.trim();
  const resultBox = document.getElementById("bookingResult");

  if (bookingId === "" || !bookings[bookingId]) {
    resultBox.textContent = "Invalid or missing booking ID.";
    return;
  }

  const booking = bookings[bookingId];
  const checkInDate = new Date(booking.checkInDate);
  const currentDate = new Date("2025-05-19");
  const timeDiff = checkInDate - currentDate;
  const daysBefore = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

  let refund = 0;
  let fee = 0;
  let message = `Booking <strong>${bookingId}</strong><br>`;
  message += `Check-in Date: ${booking.checkInDate}<br>`;
  message += `Rate Type: ${booking.rateType.charAt(0).toUpperCase() + booking.rateType.slice(1)}<br>`;
  message += `Booking Amount: $${booking.bookingAmount.toFixed(2)}<br>`;

  if (daysBefore < 0) {
    message += "Check-in date has passed. No refunds available.";
    resultBox.innerHTML = message;
    return;
  }

  switch (booking.rateType) {
    case "standard":
      if (daysBefore >= 2) {
        refund = booking.bookingAmount;
        fee = 0;
        message += "Eligible for full refund.<br>";
        message += `Refund: <span class="highlight">$${refund.toFixed(2)}</span>`;
      } else {
        fee = booking.bookingAmount * 0.5;
        refund = booking.bookingAmount - fee;
        message += "Late cancellation (within 48 hours).<br>";
        message += `Fee: <span class="highlight">$${fee.toFixed(2)}</span><br>`;
        message += `Refund: <span class="highlight">$${refund.toFixed(2)}</span>`;
      }
      break;
    case "nonrefundable":
      refund = 0;
      fee = booking.bookingAmount;
      message += "Non-refundable rate. No refund available.<br>";
      message += `Fee: <span class="highlight">$${fee.toFixed(2)}</span>`;
      break;
    case "peak":
      if (daysBefore > 14) {
        refund = booking.bookingAmount * 0.5;
        fee = booking.bookingAmount - refund;
        message += "Cancellation outside 14 days.<br>";
        message += `Refund: <span class="highlight">$${refund.toFixed(2)}</span><br>`;
        message += `Fee: <span class="highlight">$${fee.toFixed(2)}</span>`;
      } else {
        refund = 0;
        fee = booking.bookingAmount;
        message += "Cancellation within 14 days. No refund available.<br>";
        message += `Fee: <span class="highlight">$${fee.toFixed(2)}</span>`;
      }
      break;
  }

  resultBox.innerHTML = message;
}

// Load default policy on page load
window.onload = displayPolicy;