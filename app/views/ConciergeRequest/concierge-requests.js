const services = [];
const alertsEl = document.getElementById('alerts-area');

// Select service
let selectedService = '';
document.querySelectorAll('#services-list li').forEach(li => {
  li.addEventListener('click', () => {
    selectedService = li.dataset.service;
    document.querySelectorAll('#services-list li').forEach(x=>x.classList.remove('selected'));
    li.classList.add('selected');
  });
});

// Place request
document.getElementById('order-btn').addEventListener('click', () => {
  const qty = +document.getElementById('quantity').value;
  const notes = document.getElementById('details').value.trim();
  if (!selectedService) return alert('Select a service first.');
  if (qty < 1) return alert('Quantity must be at least 1.');
  const id = Date.now();
  const req = { id, service: selectedService, qty, notes, status: 'Pending' };
  services.push(req);
  renderRequests();
  addAlert(`Request #${id} placed.`);
});

function renderRequests() {
  const ul = document.getElementById('requests-list'); ul.innerHTML = '';
  services.forEach(r => {
    const li = document.createElement('li');
    li.textContent = `#${r.id}: ${r.service} ×${r.qty} – ${r.status}`;
    if (r.notes) li.append(` (Notes: ${r.notes})`);
    ul.appendChild(li);
  });
}

function addAlert(msg) {
  const p = document.createElement('p'); p.textContent = msg;
  alertsEl.appendChild(p);
  setTimeout(() => alertsEl.removeChild(p), 4000);
}

// Simulate fulfillment
setInterval(() => {
  const pending = services.filter(r=>r.status==='Pending');
  if (pending.length) {
    const r = pending[Math.floor(Math.random()*pending.length)];
    r.status = 'Completed'; renderRequests(); addAlert(`#${r.id} completed.`);
  }
}, 8000);