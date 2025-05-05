const charges = [
  { date: '2025-05-01', desc: 'Room Charge', amt: 200 },
  { date: '2025-05-02', desc: 'Minibar', amt: 50 },
  { date: '2025-05-03', desc: 'Spa Service', amt: 80 }
];

function renderFolio() {
  const tbody = document.querySelector('#charges-table tbody');
  tbody.innerHTML = '';
  charges.forEach(c => {
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${c.date}</td><td>${c.desc}</td><td>${c.amt.toFixed(2)}</td>`;
    tbody.appendChild(tr);
  });
  renderBreakdown();
}

function renderBreakdown() {
  const total = charges.reduce((sum, c) => sum + c.amt, 0);
  document.getElementById('breakdown-details').textContent = `Total charges: $${total.toFixed(2)}`;
}

// Split payment functionality
document.getElementById('split-btn').addEventListener('click', () => {
  const parts = parseInt(prompt('Split among how many guests?'), 10);
  if (!parts || parts < 1) return alert('Enter a valid number');
  const total = charges.reduce((s, c) => s + c.amt, 0);
  alert(`Each guest pays: $${(total / parts).toFixed(2)}`);
});

// Email receipt functionality
document.getElementById('email-receipt-btn').addEventListener('click', () => {
  const email = prompt('Enter email address:').trim();
  if (!email || !email.includes('@') || !email.split('@')[1].includes('.')) {
    return alert('Invalid email format');
  }
  alert(`Receipt will be sent to ${email}`);
});

renderFolio();
