const bookings = {
      "BOOK123": {
        guestName: "Shams",
        checkInDate: "2025-05-18",
        checkOutDate: "2025-05-20",
        rateType: "standard",
        bookingAmount: 300,
        status: "checked-in",
        hotel: "Oceanview Resort",
        isGroup: true,
        guests: [
          { name: "Shams", email: "shams@example.com" },
          { name: "Ali", email: "ali@example.com" }
        ],
        rooms: [
          { type: "standard", quantity: 1, price: 100 },
          { type: "deluxe", quantity: 1, price: 150 }
        ],
        eventSpace: { name: "Conference Room", price: 500 }
      },
      "BOOK456": {
        guestName: "Ali",
        checkInDate: "2025-06-01",
        checkOutDate: "2025-06-05",
        rateType: "nonrefundable",
        bookingAmount: 200,
        status: "upcoming",
        hotel: "Cityscape Hotel",
        isGroup: false
      },
      "BOOK789": {
        guestName: "Fatima",
        checkInDate: "2025-05-10",
        checkOutDate: "2025-05-12",
        rateType: "peak",
        bookingAmount: 500,
        status: "past",
        hotel: "Mountain Lodge",
        isGroup: false
      }
    };

    // Simulated charge database
    const charges = {
      "BOOK123": [
        { category: "Room (Standard)", date: "2025-05-18", amount: 100 },
        { category: "Room (Deluxe)", date: "2025-05-18", amount: 150 },
        { category: "Hotel Base", date: "2025-05-18", amount: 200 },
        { category: "Conference Room", date: "2025-05-18", amount: 500 },
        { category: "City Tour (Concierge)", date: "2025-05-19", amount: 50 },
        { category: "Tax (10%)", date: "2025-05-18", amount: 100 },
        { category: "Service Fee", date: "2025-05-18", amount: 20 }
      ],
      "BOOK456": [],
      "BOOK789": [
        { category: "Room (Suite)", date: "2025-05-10", amount: 200 },
        { category: "Hotel Base", date: "2025-05-10", amount: 180 },
        { category: "Tax (10%)", date: "2025-05-10", amount: 38 },
        { category: "Service Fee", date: "2025-05-10", amount: 20 }
      ]
    };

    // Simulated split payments
    let splitPayments = {};

    function checkAccess() {
      const currentDate = new Date("2025-05-19T22:53:00+06:00");
      const messageDiv = document.getElementById("access-message");
      const contentDiv = document.getElementById("billing-content");
      const bookingSelect = document.getElementById("booking-id");
      let hasAccess = false;

      bookingSelect.innerHTML = '<option value="">Select a booking</option>';
      for (const bookingId in bookings) {
        const booking = bookings[bookingId];
        const checkIn = new Date(booking.checkInDate);
        const checkOut = new Date(booking.checkOutDate);
        if (booking.status === "checked-in" || booking.status === "past") {
          hasAccess = true;
          bookingSelect.innerHTML += `<option value="${bookingId}">${bookingId} - ${booking.guestName} (${booking.hotel})</option>`;
        }
      }

      if (hasAccess) {
        messageDiv.textContent = "";
        contentDiv.style.display = "block";
        displayFolio();
      } else {
        messageDiv.textContent = "No checked-in or past bookings found.";
        contentDiv.style.display = "none";
      }
    }

    function displayFolio() {
      const bookingId = document.getElementById("booking-id").value;
      const folioDetails = document.getElementById("folio-details");
      const chargeTable = document.getElementById("charge-table").querySelector("tbody");
      const chargeTotal = document.getElementById("charge-total");
      const splitPaymentsDiv = document.getElementById("split-payments");
      const splitList = document.getElementById("split-list");

      if (!bookingId) {
        folioDetails.innerHTML = "";
        chargeTable.innerHTML = "";
        chargeTotal.innerHTML = "";
        splitPaymentsDiv.style.display = "none";
        return;
      }

      const booking = bookings[bookingId];
      const bookingCharges = charges[bookingId] || [];
      const nights = Math.ceil((new Date(booking.checkOutDate) - new Date(booking.checkInDate)) / (1000 * 60 * 60 * 24));
      let total = bookingCharges.reduce((sum, charge) => sum + charge.amount, 0);

      folioDetails.innerHTML = `
        <strong>Booking ID:</strong> ${bookingId}<br>
        <strong>Guest:</strong> ${booking.guestName}<br>
        <strong>Hotel:</strong> ${booking.hotel}<br>
        <strong>Check-in:</strong> ${booking.checkInDate}<br>
        <strong>Check-out:</strong> ${booking.checkOutDate}<br>
        <strong>Nights:</strong> ${nights}<br>
        <strong>Total Charges:</strong> $${total.toFixed(2)}
      `;

      chargeTable.innerHTML = "";
      bookingCharges.forEach(charge => {
        const row = document.createElement("tr");
        row.innerHTML = `
          <td>${charge.category}</td>
          <td>${charge.date}</td>
          <td>$${charge.amount.toFixed(2)}</td>
        `;
        chargeTable.appendChild(row);
      });

      chargeTotal.innerHTML = `<strong>Total:</strong> $${total.toFixed(2)}`;

      splitPaymentsDiv.style.display = booking.isGroup ? "block" : "none";
      if (booking.isGroup) {
        splitList.innerHTML = `<strong>Guests:</strong><br>`;
        booking.guests.forEach(guest => {
          const amount = splitPayments[bookingId]?.[guest.email] || 0;
          splitList.innerHTML += `${guest.name} (${guest.email}): $${amount.toFixed(2)}<br>`;
        });
      }
    }

    function setupSplitPayments() {
      const bookingId = document.getElementById("booking-id").value;
      const splitType = document.getElementById("split-type").value;
      const splitResult = document.getElementById("split-result");
      const booking = bookings[bookingId];
      const bookingCharges = charges[bookingId] || [];
      const total = bookingCharges.reduce((sum, charge) => sum + charge.amount, 0);
      const guestCount = booking.guests.length;

      if (!booking.isGroup) {
        splitResult.innerHTML = '<span class="highlight">Split payments are only available for group bookings.</span>';
        return;
      }

      splitPayments[bookingId] = splitPayments[bookingId] || {};

      if (splitType === "even") {
        const evenSplit = total / guestCount;
        booking.guests.forEach(guest => {
          splitPayments[bookingId][guest.email] = evenSplit;
        });
        splitResult.innerHTML = `Payments split evenly: $${evenSplit.toFixed(2)} per guest.`;
      } else {
        splitResult.innerHTML = `
          <strong>Enter Custom Amounts:</strong><br>
          Total must equal $${total.toFixed(2)}<br>
        `;
        booking.guests.forEach(guest => {
          splitResult.innerHTML += `
            <div class="split-entry">
              <label>${guest.name} (${guest.email})</label>
              <input type="number" id="split-${guest.email}" placeholder="Amount" step="0.01" min="0" />
            </div>
          `;
        });
        splitResult.innerHTML += `<button onclick="applyCustomSplit('${bookingId}', ${total})">Confirm Custom Split</button>`;
      }

      displayFolio();
    }

    function applyCustomSplit(bookingId, total) {
      const booking = bookings[bookingId];
      const splitResult = document.getElementById("split-result");
      let splitTotal = 0;

      booking.guests.forEach(guest => {
        const amount = parseFloat(document.getElementById(`split-${guest.email}`).value) || 0;
        splitPayments[bookingId][guest.email] = amount;
        splitTotal += amount;
      });

      if (Math.abs(splitTotal - total) > 0.01) {
        splitResult.innerHTML = `<span class="highlight">Error: Split amounts must total $${total.toFixed(2)} (current: $${splitTotal.toFixed(2)}).</span>`;
        return;
      }

      splitResult.innerHTML = `Custom split applied successfully!`;
      displayFolio();
    }

    function generateReceipt() {
      const bookingId = document.getElementById("booking-id").value;
      const receiptOutput = document.getElementById("receipt-output");

      if (!bookingId) {
        receiptOutput.innerHTML = '<span class="highlight">Please select a booking.</span>';
        return;
      }

      const booking = bookings[bookingId];
      const bookingCharges = charges[bookingId] || [];
      const total = bookingCharges.reduce((sum, charge) => sum + charge.amount, 0);
      const nights = Math.ceil((new Date(booking.checkOutDate) - new Date(booking.checkInDate)) / (1000 * 60 * 60 * 24));

      let receipt = `
        <strong>NexStay Receipt</strong><br>
        <strong>Booking ID:</strong> ${bookingId}<br>
        <strong>Guest:</strong> ${booking.guestName}<br>
        <strong>Hotel:</strong> ${booking.hotel}<br>
        <strong>Check-in:</strong> ${booking.checkInDate}<br>
        <strong>Check-out:</strong> ${booking.checkOutDate}<br>
        <strong>Nights:</strong> ${nights}<br>
        <br><strong>Charges:</strong><br>
      `;

      bookingCharges.forEach(charge => {
        receipt += `${charge.category} (${charge.date}): $${charge.amount.toFixed(2)}<br>`;
      });

      receipt += `<br><strong>Total:</strong> $${total.toFixed(2)}<br>`;

      if (booking.isGroup && splitPayments[bookingId]) {
        receipt += `<br><strong>Split Payments:</strong><br>`;
        booking.guests.forEach(guest => {
          const amount = splitPayments[bookingId][guest.email] || 0;
          if (amount > 0) {
            receipt += `${guest.name} (${guest.email}): $${amount.toFixed(2)}<br>`;
          }
        });
      }

      receipt += `<br>Thank you for choosing NexStay!`;

      receiptOutput.innerHTML = receipt;
    }

    // Initialize page
    window.onload = checkAccess;