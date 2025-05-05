
const preferencesForm = document.getElementById("preferencesForm");
const bedType = document.getElementById("bedType");
const floor = document.getElementById("floor");
const view = document.getElementById("view");
const saveMsg = document.getElementById("saveMsg");

preferencesForm.addEventListener("submit", function (e) {
  e.preventDefault();
  const preferences = {
    bedType: bedType.value,
    floor: floor.value,
    view: view.value
  };
  localStorage.setItem("guestPreferences", JSON.stringify(preferences));
  saveMsg.textContent = "Preferences saved successfully!";
  saveMsg.style.color = "green";
});


window.addEventListener("load", () => {
  const saved = JSON.parse(localStorage.getItem("guestPreferences"));
  if (saved) {
    bedType.value = saved.bedType;
    floor.value = saved.floor;
    view.value = saved.view;
  }

  renderHistory();
  updateLoyalty();
});


const stays = [
  { room: "Deluxe Room", dates: "2024-03-10 to 2024-03-12", amount: 300 },
  { room: "Suite", dates: "2024-04-01 to 2024-04-05", amount: 800 },
  { room: "Standard Room", dates: "2024-05-05 to 2024-05-06", amount: 100 }
];

function renderHistory() {
  const table = document.getElementById("historyTable");
  table.innerHTML = "";
  stays.forEach(s => {
    const tr = document.createElement("tr");
    tr.innerHTML = `<td>${s.room}</td><td>${s.dates}</td><td>$${s.amount}</td>`;
    table.appendChild(tr);
  });
}

function updateLoyalty() {
  const totalPoints = stays.reduce((sum, s) => sum + Math.floor(s.amount / 10), 0);
  const pointsDisplay = document.getElementById("points");
  const tierDisplay = document.getElementById("tier");

  pointsDisplay.textContent = totalPoints;

  let tier = "Bronze";
  if (totalPoints >= 200) tier = "Gold";
  else if (totalPoints >= 100) tier = "Silver";

  tierDisplay.textContent = tier;
}
