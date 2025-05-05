const terms = {
    standard: 'Free cancellation up to 24 hours before check‑in.',
    flexible: 'Free cancellation up to 6 hours before check‑in.',
    nonrefundable: 'No refund upon cancellation.'
  };
  
  document.getElementById('rate-type').addEventListener('change', e => {
    document.getElementById('terms-text').textContent = terms[e.target.value] || '';
  });
  
  document.getElementById('modify-form').addEventListener('submit', e => {
    e.preventDefault();
    const id = e.target.bookingId.value.trim();
    const date = e.target.newDate.value;
    if (!id || !date) return alert('Enter booking ID and new date.');
    alert(`Change request submitted for booking ${id} → ${date}`);
    e.target.reset();
  });
  
  document.getElementById('calculate-button').addEventListener('click', () => {
    const ci = new Date(document.getElementById('checkin-date').value);
    const cd = new Date(document.getElementById('cancel-date').value);
    const type = document.getElementById('penalty-rate-type').value;
    if (!ci || !cd || !type) return alert('All fields must be filled.');
    const days = (ci - cd) / (24*60*60*1000);
    let fee;
    if (type === 'nonrefundable' || (type === 'standard' && days < 1) || (type === 'flexible' && days < 0.25)) {
      fee = '100%';
    } else fee = '0%';
    document.getElementById('fee-result').textContent = `Cancellation fee: ${fee}`;
  });