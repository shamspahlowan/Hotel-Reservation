function showSection(sectionId) {
  // Hide all sections
  document.querySelectorAll('.content-section').forEach(section => {
    section.classList.remove('active');
  });
  // Show selected section
  document.getElementById(`${sectionId}-section`).classList.add('active');
  // Update active nav item
  document.querySelectorAll('.nav-item').forEach(item => {
    item.classList.remove('active');
  });
  document.querySelector(`.nav-item a[href="#${sectionId}"]`).parentElement.classList.add('active');
}