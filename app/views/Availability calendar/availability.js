const rooms = [
    {
      id: 1,
      name: "Standard Room",
      price: 80,
      image: "images/standard.jpg", // replace with your image path
      bookings: ["2024-05-10", "2024-05-11"]
    },
    {
      id: 2,
      name: "Deluxe Room",
      price: 120,
      image: "images/deluxe.jpg",
      bookings: ["2024-05-14"]
    },
    {
      id: 3,
      name: "Suite",
      price: 200,
      image: "images/suite.jpg",
      bookings: []
    }
  ];
  
  const checkinInput = document.getElementById("checkin");
  const checkoutInput = document.getElementById("checkout");
  const roomList = document.getElementById("roomList");
  const summary = document.getElementById("summary");
  
  checkinInput.addEventListener("change", handleDateChange);
  checkoutInput.addEventListener("change", handleDateChange);
  
  function handleDateChange() {
    const checkin = checkinInput.value;
    const checkout = checkoutInput.value;
  
    if (!checkin || !checkout || checkout <= checkin) {
      summary.style.display = "none";
      roomList.innerHTML = "";
      return;
    }
  
    const nights = calculateNights(checkin, checkout);
    summary.style.display = "block";
    summary.innerHTML = `<strong>Stay:</strong> ${nights} night(s) <br><strong>Dates:</strong> ${checkin} to ${checkout}`;
  
    const availableRooms = rooms.filter(room => {
      return !room.bookings.some(date => date >= checkin && date < checkout);
    });
  
    renderRoomList(availableRooms, nights);
  }
  
  function calculateNights(start, end) {
    const checkin = new Date(start);
    const checkout = new Date(end);
    const diff = checkout - checkin;
    return Math.ceil(diff / (1000 * 60 * 60 * 24));
  }
  
  function renderRoomList(roomArray, nights) {
    roomList.innerHTML = "";
    if (roomArray.length === 0) {
      roomList.innerHTML = "<p>No rooms available for the selected dates.</p>";
      return;
    }
  
    roomArray.forEach(room => {
      const div = document.createElement("div");
      div.className = "room-card";
      div.innerHTML = `
        <img src="${room.image}" alt="${room.name}" />
        <div>
          <h4>${room.name}</h4>
          <p>Rate: $${room.price} per night</p>
          <p>Total: $${room.price * nights}</p>
        </div>
      `;
      roomList.appendChild(div);
    });
  }
  