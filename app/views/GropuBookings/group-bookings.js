const groups = [];


document.getElementById('new-group-btn').addEventListener('click', () => {
  const id = prompt('Enter unique Group ID:').trim();
  if (!id) return alert('ID required.');
  groups.push({ id, rooms: 0, deposit: 0, dueDate: '', events: [] });
  renderGroups();
});

function renderGroups() {
  const ul = document.getElementById('groups-list'); ul.innerHTML = '';
  groups.forEach(g => {
    const li = document.createElement('li');
    li.textContent = `Group ${g.id}: ${g.rooms} rooms blocked, deposit ${g.deposit}%, due ${g.dueDate || 'N/A'}, ${g.events.length} event(s)`;
    ul.appendChild(li);
  });
}


document.getElementById('room-block-form').addEventListener('submit', e => {
  e.preventDefault();
  const { groupId, numRooms, roomType } = e.target;
  const g = groups.find(x => x.id === groupId.value.trim());
  if (!g) return alert('Group not found.');
  if (+numRooms.value < 1) return alert('Enter at least one room.');
  g.rooms += +numRooms.value;
  renderGroups(); e.target.reset();
});


document.getElementById('terms-form').addEventListener('submit', e => {
  e.preventDefault();
  const { depositRate, dueDate } = e.target;
  const g = groups[groups.length-1];
  if (!g) return alert('Create a group first.');
  g.deposit = +depositRate.value;
  g.dueDate = dueDate.value;
  renderGroups(); e.target.reset();
});


document.getElementById('event-form').addEventListener('submit', e => {
  e.preventDefault();
  const id = prompt('Group ID for this event:').trim();
  const g = groups.find(x => x.id === id);
  if (!g) return alert('Group not found.');
  const { eventName, eventDate, spaceType } = e.target;
  if (!eventName.value || !eventDate.value) return alert('Name and date required.');
  g.events.push({ name: eventName.value.trim(), date: eventDate.value, spaceType: spaceType.value });
  renderGroups(); e.target.reset();
});