const roomBoard = document.getElementById("roomBoard");
const reportForm = document.getElementById("reportForm");
const reportMsg = document.getElementById("reportMsg");

// Simulated room data
let rooms = [
  { number: 101, status: "cleaned" },
  { number: 102, status: "in-progress" },
  { number: 103, status: "needs-cleaning" },
  { number: 104, status: "cleaned" },
  { number: 105, status: "needs-cleaning" }
];

function renderRooms() {
  roomBoard.innerHTML = "";
  rooms.forEach(room => {
    const card = document.createElement("div");
    card.className = "room-card";
    card.innerHTML = `
      <h4>Room ${room.number}</h4>
      <div class="status ${room.status}">${room.status.replace('-', ' ')}</div>
      ${room.status === "in-progress" ? `
        <div class="progress-bar"><div class="progress-fill" id="progress-${room.number}"></div></div>` : ""}
      <button onclick="toggleStatus(${room.number})">Toggle Status</button>
    `;
    roomBoard.appendChild(card);

    if (room.status === "in-progress") {
      simulateProgress(`progress-${room.number}`);
    }
  });
}

function toggleStatus(roomNumber) {
  rooms = rooms.map(room => {
    if (room.number === roomNumber) {
      if (room.status === "cleaned") room.status = "needs-cleaning";
      else if (room.status === "needs-cleaning") room.status = "in-progress";
      else if (room.status === "in-progress") room.status = "cleaned";
    }
    return room;
  });
  renderRooms();
}

function simulateProgress(id) {
  let progress = 0;
  const bar = document.getElementById(id);
  const interval = setInterval(() => {
    if (progress >= 100) {
      clearInterval(interval);
    } else {
      progress += 10;
      bar.style.width = `${progress}%`;
    }
  }, 500);
}

reportForm.addEventListener("submit", function (e) {
  e.preventDefault();
  const room = document.getElementById("issueRoom").value;
  const desc = document.getElementById("issueDesc").value;

  // Simulate report handling
  console.log(`Issue reported for room ${room}: ${desc}`);
  reportMsg.textContent = `Issue submitted for room ${room}.`;
  reportForm.reset();
  setTimeout(() => (reportMsg.textContent = ""), 3000);
});

renderRooms();
