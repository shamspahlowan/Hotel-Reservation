const reviews = [];
const pending = [];
let currentPage = 1;
const reviewsPerPage = 5;

// Star rating accessibility
const stars = document.querySelectorAll('#star-rating .star');
stars.forEach((star, idx) => {
  star.addEventListener('click', () => setRating(idx + 1));
  star.addEventListener('keydown', e => {
    if (e.key === 'Enter' || e.key === ' ') setRating(idx + 1);
  });
});

function setRating(val) {
  document.getElementById('rating').value = val;
  stars.forEach((s, i) => {
    s.textContent = i < val ? '★' : '☆';
    s.setAttribute('aria-checked', i < val);
    s.tabIndex = i === val - 1 ? 0 : -1;
  });
}

// Submit new review
document.getElementById('review-form').addEventListener('submit', e => {
  e.preventDefault();
  const rating = +document.getElementById('rating').value;
  const comment = document.getElementById('comment').value.trim();
  const travelerType = document.getElementById('traveler-type').value;
  if (!rating || !comment || !travelerType) return alert('All fields are required.');
  
  const review = { id: reviews.length + 1, rating, comment, travelerType, response: '' };
  reviews.push(review);
  pending.push(review);
  renderPending();
  e.target.reset();
  setRating(0);
});

// Moderation
function renderPending() {
  const ul = document.getElementById('pending-list'); ul.innerHTML = '';
  pending.forEach(r => {
    const li = document.createElement('li');
    li.textContent = `#${r.id}: ${r.rating}★ (${r.travelerType}) – ${r.comment}`;
    ul.appendChild(li);
  });
}

document.getElementById('show-pending').addEventListener('click', renderPending);

// Management response
document.getElementById('response-form').addEventListener('submit', e => {
  e.preventDefault();
  const id = +e.target.reviewId.value;
  const text = e.target.responseText.value.trim();
  const rev = reviews.find(r => r.id === id);
  if (!rev || !text) return alert('Valid review ID and response required.');
  rev.response = text;
  pending.splice(pending.findIndex(r => r.id === id), 1);
  renderPending();
  renderReviews();
  e.target.reset();
});

// Render all reviews with pagination
function renderReviews() {
  const ul = document.getElementById('reviews-list'); ul.innerHTML = '';
  const filter = document.getElementById('filter-type').value;
  const filteredReviews = reviews.filter(r => filter === 'all' || r.travelerType === filter);
  
  const startIndex = (currentPage - 1) * reviewsPerPage;
  const endIndex = Math.min(startIndex + reviewsPerPage, filteredReviews.length);
  const currentReviews = filteredReviews.slice(startIndex, endIndex);
  
  currentReviews.forEach(r => {
    const li = document.createElement('li');
    li.innerHTML = `<strong>#${r.id} ${'★'.repeat(r.rating)}</strong> ` +
                   `<em>(${r.travelerType})</em><p>${r.comment}</p>` +
                   (r.response ? `<blockquote>Management: ${r.response}</blockquote>` : '');
    ul.appendChild(li);
  });

  // Update pagination visibility
  document.getElementById('page-num').textContent = `Page ${currentPage}`;
  document.getElementById('prev-page').disabled = currentPage === 1;
  document.getElementById('next-page').disabled = currentPage * reviewsPerPage >= filteredReviews.length;
}

document.getElementById('filter-type').addEventListener('change', () => {
  currentPage = 1;
  renderReviews();
});

document.getElementById('prev-page').addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    renderReviews();
  }
});

document.getElementById('next-page').addEventListener('click', () => {
  currentPage++;
  renderReviews();
});

renderReviews();
