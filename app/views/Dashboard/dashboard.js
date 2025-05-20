// Detailed Data for widgets and charts
function showDetail(type) {
  const panel = document.getElementById('detail-content');
  let html = '<h3>';
  
  if (type === 'bookings') {
    html += 'Booking Details</h3><ul>';
    html += '<li>Today: 12 bookings</li>';
    html += '<li>This Week: 84 bookings</li>';
    html += '<li>Top Source: Website</li>';
    html += '</ul>';
  } else if (type === 'occupancy') {
    html += 'Occupancy Details</h3><ul>';
    html += '<li>Single Rooms: 82%</li>';
    html += '<li>Double Rooms: 75%</li>';
    html += '<li>Suites: 63%</li>';
    html += '</ul>';
  } else if (type === 'revenue') {
    html += 'Revenue Details</h3><ul>';
    html += '<li>Bookings: $40,000</li>';
    html += '<li>Extras: $3,000</li>';
    html += '<li>Late Fees: $2,200</li>';
    html += '</ul>';
  } else if (type === 'cancellations') {
    html += 'Cancellation Summary</h3><ul>';
    html += '<li>This Week: 14</li>';
    html += '<li>Reasons: No show (7), Change of plan (5), Other (2)</li>';
    html += '</ul>';
  }

  panel.innerHTML = html;
}


function drawBarChart(containerId, labels, values, maxVal) {
  const container = document.getElementById(containerId);
  container.innerHTML = ''; 

  labels.forEach((label, i) => {
    const barWrapper = document.createElement('div');
    barWrapper.className = 'bar-wrapper';

    const bar = document.createElement('div');
    bar.className = 'bar';
    bar.style.width = (values[i] / maxVal * 100) + '%';
    bar.textContent = `${label}: ${values[i]}`;

    barWrapper.appendChild(bar);
    container.appendChild(barWrapper);
  });
}

// Draw all charts on page load
function drawCharts() {
  drawBarChart(
    'booking-trend-chart',
    ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    [12, 18, 22, 20, 25, 30, 28],
    40
  );

  drawBarChart(
    'occupancy-chart',
    ['Single', 'Double', 'Suite'],
    [82, 75, 63],
    100
  );

  drawBarChart(
    'revenue-chart',
    ['Bookings', 'Extras', 'Late Fees'],
    [40000, 3000, 2200],
    50000
  );
}

window.onload = function () {
  drawCharts();
};
