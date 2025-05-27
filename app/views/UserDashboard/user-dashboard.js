function fetchUserBookings() {
  console.log("runs");
  fetch('../../controllers/BookingController.php?action=getBookingsByUser', {
    credentials: 'include'
  })
    .then(res => res.json())
    .then(data => {
      // Find current stay (confirmed or pending, checkout_date >= today)
      let currentStay = null;
      const today = new Date().toISOString().slice(0, 10);
      data.forEach(b => {
        if (
          (b.status === 'confirmed' || b.status === 'pending') &&
          b.checkout_date >= today &&
          !currentStay
        ) {
          currentStay = b;
        }
      });

      // Display current stay
      const currentStayDiv = document.getElementById("currentStay");
      const conciergeBtn = document.getElementById("conciergeBtn");
      if (currentStay) {
        currentStayDiv.innerHTML = `
          <div><strong>Booking ID:</strong> #BK${currentStay.id}</div>
          <div><strong>Check-in:</strong> ${currentStay.checkin_date}</div>
          <div><strong>Check-out:</strong> ${currentStay.checkout_date}</div>
          <div><strong>Status:</strong> ${currentStay.status}</div>
          <div><strong>Amount:</strong> $${currentStay.amount || 'N/A'}</div>
        `;
        conciergeBtn.style.display = "";
      } else {
        currentStayDiv.textContent = "No active stays.";
        conciergeBtn.style.display = "none";
      }

      // Display booking history
      const tbody = document.querySelector("#bookingHistory tbody");
      tbody.innerHTML = "";
      if (data.length > 0) {
        data.forEach(b => {
          const row = document.createElement("tr");
          row.innerHTML = `
            <td>#BK${b.id}</td>
            <td>${b.checkin_date}</td>
            <td>${b.checkout_date}</td>
            <td>${b.rate_type || 'Standard'}</td>
            <td>$${b.amount || 'N/A'}</td>
            <td>${b.status}</td>
          `;
          tbody.appendChild(row);
        });
      } else {
        tbody.innerHTML = "<tr><td colspan='6'>No bookings found.</td></tr>";
      }
    });
}

window.onload = function () {
  fetchUserBookings();
};