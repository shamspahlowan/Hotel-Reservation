

const bookings = [
  { guest: "Alice", room: "Suite", date: "2024-05-10", amount: 250 },
  { guest: "Bob", room: "Double", date: "2024-05-15", amount: 150 },
  { guest: "Charlie", room: "Single", date: "2024-06-01", amount: 100 },
  { guest: "Diana", room: "Suite", date: "2024-06-05", amount: 280 },
  { guest: "Evan", room: "Double", date: "2024-06-10", amount: 160 }
];

const tableBody = document.getElementById("tableBody");

function renderTable(data) {
  tableBody.innerHTML = "";
  data.forEach(b => {
    const tr = document.createElement("tr");
    tr.innerHTML = `<td>${b.guest}</td><td>${b.room}</td><td>${b.date}</td><td>${b.amount}</td>`;
    tableBody.appendChild(tr);
  });
}

function filterData() {
  const from = document.getElementById("startDate").value;
  const to = document.getElementById("endDate").value;

  return bookings.filter(b => {
    return (!from || b.date >= from) && (!to || b.date <= to);
  });
}

function exportCSV() {
  const filtered = filterData();
  let csv = "Guest,Room,Date,Amount\n";
  filtered.forEach(b => {
    csv += `${b.guest},${b.room},${b.date},${b.amount}\n`;
  });

  const blob = new Blob([csv], { type: "text/csv" });
  const url = URL.createObjectURL(blob);
  const link = document.createElement("a");
  link.href = url;
  link.download = "booking_data.csv";
  link.click();
}

async function exportPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF();
  const filtered = filterData();

  doc.setFontSize(14);
  doc.text("Booking Report", 10, 10);

  let y = 20;
  doc.setFontSize(12);
  doc.text("Guest | Room | Date | Amount", 10, y);
  y += 10;

  filtered.forEach(b => {
    doc.text(`${b.guest} | ${b.room} | ${b.date} | $${b.amount}`, 10, y);
    y += 10;
  });

  doc.save("booking_data.pdf");
}


renderTable(bookings);


document.getElementById("startDate").addEventListener("change", () => renderTable(filterData()));
document.getElementById("endDate").addEventListener("change", () => renderTable(filterData()));
