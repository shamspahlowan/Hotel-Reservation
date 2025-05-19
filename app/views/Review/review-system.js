function filterReviews() {
  const filter = document.getElementById('user-filter').value.toLowerCase();
  const rows = document.querySelectorAll('#reviews-table tbody tr');
  rows.forEach(row => {
    const username = row.dataset.username.toLowerCase();
    row.style.display = username.includes(filter) ? '' : 'none';
  });
}

function openResponseForm(username) {
  document.getElementById('response-username').value = username;
  document.getElementById('response-text').value = '';
  document.getElementById('response-form').style.display = 'block';
}

function closeResponseForm() {
  document.getElementById('response-form').style.display = 'none';
}

function submitResponse(event) {
  event.preventDefault();
  const username = document.getElementById('response-username').value;
  const responseText = document.getElementById('response-text').value;
  const row = document.querySelector(`tr[data-username="${username}"]`);
  if (row) {
    const responseCell = row.cells[4];
    responseCell.textContent = responseText;
    closeResponseForm();
  }
}

function approveReview(username) {
  const row = document.querySelector(`tr[data-username="${username}"]`);
  if (row) {
    const statusCell = row.cells[3];
    statusCell.innerHTML = '<span class="status status-success">Approved</span>';
    const actionsCell = row.cells[5];
    actionsCell.innerHTML = `
      <button class="action-btn" onclick="openResponseForm('${username}')">[Respond]</button>
      <button class="action-btn" onclick="deleteReview('${username}')">[Delete]</button>
    `;
  }
}

function deleteReview(username) {
  const row = document.querySelector(`tr[data-username="${username}"]`);
  if (row) {
    row.remove();
  }
}