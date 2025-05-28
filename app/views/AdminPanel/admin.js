// Admin Dashboard JavaScript
document.addEventListener("DOMContentLoaded", function () {
    loadDashboardData();
});

// Load initial dashboard data
function loadDashboardData() {
    loadDashboardStats();
    loadRecentBookings();
}

// Dashboard Stats
function loadDashboardStats() {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', '../../controllers/AdminController.php?action=getDashboardStats', true);
    xhttp.send();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const data = JSON.parse(this.responseText);
                updateDashboardStats(data);
            } catch (e) {
                console.error('Error loading dashboard stats:', e);
            }
        }
    };
}

function updateDashboardStats(data) {
    document.querySelector('.stat-card:nth-child(1) .stat-value').textContent = data.totalBookings || '0';
    document.querySelector('.stat-card:nth-child(2) .stat-value').textContent = '$' + (data.totalRevenue || '0');
    document.querySelector('.stat-card:nth-child(3) .stat-value').textContent = (data.occupancyRate || '0') + '%';
    document.querySelector('.stat-card:nth-child(4) .stat-value').textContent = data.activeUsers || '0';
}

// Recent Bookings
function loadRecentBookings() {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', '../../controllers/AdminController.php?action=getRecentBookings', true);
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const bookings = JSON.parse(this.responseText);
                populateBookingsTable(bookings, '#dashboard-section tbody');
            } catch (e) {
                console.error('Error loading recent bookings:', e);
            }
        }
    };
    xhttp.send();
}

// Show Section Function
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
    document.querySelector(`.nav-item[href="#${sectionId}"]`).classList.add('active');
    
    // Load section-specific data
    loadSectionData(sectionId);
}

function loadSectionData(sectionId) {
    switch (sectionId) {
        case 'bookings':
            loadAllBookings();
            break;
        case 'users':
            loadAllUsers();
            break;
        case 'transactions':
            loadTransactions();
            break;
        case 'analytics':
            loadAnalytics();
            break;
        case 'hotels':
            loadHotels();
            break;
    }
}

// Bookings Management
function loadAllBookings() {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', '../../controllers/AdminController.php?action=getAllBookings', true);
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const bookings = JSON.parse(this.responseText);
                populateBookingsTable(bookings, '#bookings-section tbody');
                updateBookingStats(bookings);
            } catch (e) {
                console.error('Error loading all bookings:', e);
            }
        }
    };
    xhttp.send();
}

function populateBookingsTable(bookings, selector) {
    const tbody = document.querySelector(selector);
    if (!tbody) return;
    
    tbody.innerHTML = '';
    bookings.forEach(booking => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>#BK${booking.id}</td>
            <td>${booking.guest_name || 'N/A'}</td>
            <td>${booking.hotel_name || 'N/A'}</td>
            <td>${booking.checkin_date}</td>
            <td>${booking.checkout_date}</td>
            <td>$${booking.amount || '0'}</td>
            <td><span class="status status-${getStatusClass(booking.status)}">${booking.status}</span></td>
            <td>
                <button class="action-btn" onclick="viewBooking(${booking.id})">View</button>
                <button class="action-btn" onclick="editBooking(${booking.id})">Edit</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function updateBookingStats(bookings) {
    const total = bookings.length;
    const confirmed = bookings.filter(b => b.status === 'confirmed').length;
    const pending = bookings.filter(b => b.status === 'pending').length;
    const cancelled = bookings.filter(b => b.status === 'cancelled').length;
    
    const statsCards = document.querySelectorAll('#bookings-section .stat-card');
    if (statsCards.length >= 4) {
        statsCards[0].querySelector('.stat-value').textContent = total;
        statsCards[1].querySelector('.stat-value').textContent = confirmed;
        statsCards[2].querySelector('.stat-value').textContent = pending;
        statsCards[3].querySelector('.stat-value').textContent = cancelled;
    }
}

function updateBookingStatus(bookingId, newStatus) {
    const json = JSON.stringify({
        action: 'updateBookingStatus',
        booking_id: bookingId,
        status: newStatus
    });
    
    const xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/AdminController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            if (response.success) {
                showMessage('Booking status updated successfully!', 'success');
                loadAllBookings();
            } else {
                showMessage('Failed to update booking status.', 'error');
            }
        }
    };
    xhttp.send('json=' + json);
}

// Users Management
function loadAllUsers() {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', '../../controllers/AdminController.php?action=getAllUsers', true);
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const users = JSON.parse(this.responseText);
                populateUsersTable(users);
                updateUserStats(users);
            } catch (e) {
                console.error('Error loading users:', e);
            }
        }
    };
    xhttp.send();
}

function populateUsersTable(users) {
    const tbody = document.querySelector('#users-section tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>#U${user.id}</td>
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>${user.role}</td>
            <td><span class="status status-success">Active</span></td>
            <td>${formatDate(user.created_at)}</td>
            <td>Today</td>
            <td>
                <button class="action-btn" onclick="viewUser(${user.id})">View</button>
                <button class="action-btn" onclick="editUserRole(${user.id}, '${user.role}')">Edit</button>
                <button class="action-btn" onclick="deleteUserAccount(${user.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function updateUserStats(users) {
    const total = users.length;
    const active = users.filter(u => u.role !== 'inactive').length;
    const staff = users.filter(u => u.role === 'admin' || u.role === 'staff').length;
    const newThisMonth = users.filter(u => {
        const created = new Date(u.created_at);
        const now = new Date();
        return created.getMonth() === now.getMonth() && created.getFullYear() === now.getFullYear();
    }).length;
    
    const statsCards = document.querySelectorAll('#users-section .stat-card');
    if (statsCards.length >= 4) {
        statsCards[0].querySelector('.stat-value').textContent = total;
        statsCards[1].querySelector('.stat-value').textContent = active;
        statsCards[2].querySelector('.stat-value').textContent = staff;
        statsCards[3].querySelector('.stat-value').textContent = newThisMonth;
    }
}

function deleteUserAccount(userId) {
    if (!confirm('Are you sure you want to delete this user?')) return;
    
    const json = JSON.stringify({
        action: 'deleteUser',
        user_id: userId
    });
    
    const xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/AdminController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            if (response.success) {
                showMessage('User deleted successfully!', 'success');
                loadAllUsers();
            } else {
                showMessage('Failed to delete user.', 'error');
            }
        }
    };
    xhttp.send('json=' + json);
}

function editUserRole(userId, currentRole) {
    const newRole = prompt('Enter new role (guest/admin/staff):', currentRole);
    if (!newRole || newRole === currentRole) return;
    
    const json = JSON.stringify({
        action: 'updateUserRole',
        user_id: userId,
        role: newRole
    });
    
    const xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/AdminController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            if (response.success) {
                showMessage('User role updated successfully!', 'success');
                loadAllUsers();
            } else {
                showMessage('Failed to update user role.', 'error');
            }
        }
    };
    xhttp.send('json=' + json);
}

// Transactions Management
function loadTransactions() {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', '../../controllers/AdminController.php?action=getTransactions', true);
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const transactions = JSON.parse(this.responseText);
                populateTransactionsTable(transactions);
                updateTransactionStats(transactions);
            } catch (e) {
                console.error('Error loading transactions:', e);
            }
        }
    };
    xhttp.send();
}

function populateTransactionsTable(transactions) {
    const tbody = document.querySelector('#transactions-section tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    transactions.forEach(transaction => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>#TX${transaction.id}</td>
            <td>#BK${transaction.booking_id}</td>
            <td>${transaction.customer_name || 'N/A'}</td>
            <td>${formatDate(transaction.payment_date)}</td>
            <td>$${transaction.amount}</td>
            <td>${transaction.method || 'N/A'}</td>
            <td><span class="status status-${getStatusClass(transaction.status)}">${transaction.status}</span></td>
            <td>
                <button class="action-btn" onclick="viewTransaction(${transaction.id})">View</button>
                <button class="action-btn" onclick="generateInvoice(${transaction.id})">Invoice</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function updateTransactionStats(transactions) {
    const totalRevenue = transactions.reduce((sum, t) => sum + parseFloat(t.amount || 0), 0);
    const thisMonth = transactions.filter(t => {
        const date = new Date(t.payment_date);
        const now = new Date();
        return date.getMonth() === now.getMonth() && date.getFullYear() === now.getFullYear();
    }).reduce((sum, t) => sum + parseFloat(t.amount || 0), 0);
    
    const refunds = transactions.filter(t => t.status === 'refunded').reduce((sum, t) => sum + parseFloat(t.amount || 0), 0);
    const avgTransaction = totalRevenue / transactions.length || 0;
    
    const statsCards = document.querySelectorAll('#transactions-section .stat-card');
    if (statsCards.length >= 4) {
        statsCards[0].querySelector('.stat-value').textContent = '$' + totalRevenue.toFixed(2);
        statsCards[1].querySelector('.stat-value').textContent = '$' + thisMonth.toFixed(2);
        statsCards[2].querySelector('.stat-value').textContent = '$' + refunds.toFixed(2);
        statsCards[3].querySelector('.stat-value').textContent = '$' + avgTransaction.toFixed(0);
    }
}

// Analytics
function loadAnalytics() {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', '../../controllers/AdminController.php?action=getAnalytics', true);
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const data = JSON.parse(this.responseText);
                updateAnalyticsCharts(data);
            } catch (e) {
                console.error('Error loading analytics:', e);
            }
        }
    };
    xhttp.send();
}

function updateAnalyticsCharts(data) {
    // Update occupancy rate
    const occupancyEl = document.querySelector('#analytics-section .card:first-child .chart-container div div:first-child');
    if (occupancyEl) {
        occupancyEl.textContent = (data.occupancyRate || 0) + '%';
    }
    
    // Update revenue streams
    const revenueStreams = document.querySelectorAll('#analytics-section .card:nth-child(2) .chart-container div div');
    if (revenueStreams.length >= 4 && data.revenueStreams) {
        revenueStreams[1].textContent = data.revenueStreams.rooms + '%';
        revenueStreams[3].textContent = data.revenueStreams.services + '%';
    }
}

function addNewHotel() {
    const name = prompt('Hotel Name:');
    const location = prompt('Location:');
    const rooms = prompt('Number of Rooms:');
    
    if (!name || !location || !rooms) return;
    
    const json = JSON.stringify({
        action: 'addHotel',
        name: name,
        location: location,
        rooms: parseInt(rooms)
    });
    
    const xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/AdminController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            if (response.success) {
                showMessage(response.message || 'Hotel added successfully!', 'success');
                loadHotels();
            } else {
                showMessage('Failed to add hotel.', 'error');
            }
        }
    };
    xhttp.send('json=' + json);
}

// Utility Functions
function getStatusClass(status) {
    switch (status) {
        case 'confirmed':
        case 'paid':
        case 'completed':
            return 'success';
        case 'pending':
            return 'pending';
        case 'cancelled':
        case 'failed':
            return 'canceled';
        default:
            return 'pending';
    }
}

function formatDate(dateString) {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { 
        year: 'numeric', 
        month: 'short', 
        day: 'numeric' 
    });
}

function showMessage(message, type) {
    // Create a simple toast notification
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.cssText = `
        position: fixed;
        top: 80px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 8px;
        color: white;
        z-index: 1000;
        font-weight: 500;
    `;
    
    switch (type) {
        case 'success':
            toast.style.backgroundColor = '#34c759';
            break;
        case 'error':
            toast.style.backgroundColor = '#ff3b30';
            break;
        case 'info':
            toast.style.backgroundColor = '#007bff';
            break;
    }
    
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        document.body.removeChild(toast);
    }, 3000);
}

// Search functionality
function setupSearch() {
    document.querySelectorAll('.search-input').forEach(input => {
        input.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const table = this.closest('.table-container').querySelector('table tbody');
            const rows = table.querySelectorAll('tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
}

// Initialize search after DOM load
document.addEventListener('DOMContentLoaded', function() {
    setupSearch();
});

function loadHotels() {
    // Load hotel stats
    const xhttp1 = new XMLHttpRequest();
    xhttp1.open('GET', '../../controllers/AdminController.php?action=getHotelStats', true);
    xhttp1.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const stats = JSON.parse(this.responseText);
                updateHotelStats(stats);
            } catch (e) {
                console.error('Error loading hotel stats:', e);
            }
        }
    };
    xhttp1.send();
    
    // Load all hotels
    const xhttp2 = new XMLHttpRequest();
    xhttp2.open('GET', '../../controllers/AdminController.php?action=getAllHotels', true);
    xhttp2.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            try {
                const hotels = JSON.parse(this.responseText);
                populateHotelsTable(hotels);
            } catch (e) {
                console.error('Error loading hotels:', e);
            }
        }
    };
    xhttp2.send();
}

function updateHotelStats(stats) {
    const statsCards = document.querySelectorAll('#hotels-section .stat-card');
    if (statsCards.length >= 4) {
        statsCards[0].querySelector('.stat-value').textContent = stats.total || '0';
        statsCards[1].querySelector('.stat-value').textContent = stats.active || '0';
        statsCards[2].querySelector('.stat-value').textContent = stats.total_rooms || '0';
        statsCards[3].querySelector('.stat-value').textContent = stats.avg_rating || '0.0';
    }
}

function populateHotelsTable(hotels) {
    const tbody = document.querySelector('#hotels-section tbody');
    if (!tbody) return;
    
    tbody.innerHTML = '';
    if (hotels.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" style="text-align: center; padding: 20px;">No hotels found.</td></tr>';
        return;
    }
    
    hotels.forEach(hotel => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>#H${hotel.id}</td>
            <td>${hotel.name}</td>
            <td>${hotel.city}, ${hotel.state}</td>
            <td>${hotel.actual_rooms || hotel.total_rooms || 0}</td>
            <td>${hotel.avg_rating || hotel.rating || 'N/A'}</td>
            <td><span class="status status-${getStatusClass(hotel.status)}">${hotel.status}</span></td>
            <td>
                <button class="action-btn" onclick="viewHotel(${hotel.id})">View</button>
                <button class="action-btn" onclick="editHotel(${hotel.id})">Edit</button>
                <button class="action-btn" onclick="deleteHotelConfirm(${hotel.id})">Delete</button>
            </td>
        `;
        tbody.appendChild(row);
    });
}

function addNewHotel() {
    // Create a simple modal/form for adding hotel
    const form = `
        <div id="hotelModal" style="
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.5); z-index: 1000; display: flex; 
            align-items: center; justify-content: center;">
            <div style="
                background: white; padding: 30px; border-radius: 12px; 
                width: 500px; max-height: 80vh; overflow-y: auto;">
                <h3>Add New Hotel</h3>
                <form id="addHotelForm">
                    <input type="text" id="hotelName" placeholder="Hotel Name" required style="width: 100%; margin: 10px 0; padding: 8px;">
                    <textarea id="hotelDescription" placeholder="Description" style="width: 100%; margin: 10px 0; padding: 8px; height: 60px;"></textarea>
                    <input type="text" id="hotelAddress" placeholder="Address" required style="width: 100%; margin: 10px 0; padding: 8px;">
                    <input type="text" id="hotelCity" placeholder="City" required style="width: 100%; margin: 10px 0; padding: 8px;">
                    <input type="text" id="hotelState" placeholder="State" required style="width: 100%; margin: 10px 0; padding: 8px;">
                    <input type="text" id="hotelCountry" placeholder="Country" required style="width: 100%; margin: 10px 0; padding: 8px;">
                    <input type="text" id="hotelPhone" placeholder="Phone" style="width: 100%; margin: 10px 0; padding: 8px;">
                    <input type="email" id="hotelEmail" placeholder="Email" style="width: 100%; margin: 10px 0; padding: 8px;">
                    <input type="number" id="hotelRooms" placeholder="Total Rooms" min="1" required style="width: 100%; margin: 10px 0; padding: 8px;">
                    <input type="text" id="hotelAmenities" placeholder="Amenities (comma separated)" style="width: 100%; margin: 10px 0; padding: 8px;">
                    <div id="hotelMsg" style="margin: 10px 0; color: red;"></div>
                    <div style="text-align: right; margin-top: 20px;">
                        <button type="button" onclick="closeHotelModal()" style="margin-right: 10px; padding: 8px 16px;">Cancel</button>
                        <button type="submit" style="padding: 8px 16px; background: #007bff; color: white; border: none; border-radius: 4px;">Add Hotel</button>
                    </div>
                </form>
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', form);
    
    // Handle form submission
    document.getElementById('addHotelForm').onsubmit = function(e) {
        e.preventDefault();
        
        const hotelData = {
            action: 'addHotel',
            name: document.getElementById('hotelName').value.trim(),
            description: document.getElementById('hotelDescription').value.trim(),
            address: document.getElementById('hotelAddress').value.trim(),
            city: document.getElementById('hotelCity').value.trim(),
            state: document.getElementById('hotelState').value.trim(),
            country: document.getElementById('hotelCountry').value.trim(),
            phone: document.getElementById('hotelPhone').value.trim(),
            email: document.getElementById('hotelEmail').value.trim(),
            total_rooms: parseInt(document.getElementById('hotelRooms').value),
            amenities: document.getElementById('hotelAmenities').value.trim()
        };
        
        // Validation
        if (!hotelData.name || !hotelData.address || !hotelData.city || !hotelData.state || !hotelData.country || !hotelData.total_rooms) {
            document.getElementById('hotelMsg').textContent = 'Please fill in all required fields.';
            return;
        }
        
        const json = JSON.stringify(hotelData);
        const xhttp = new XMLHttpRequest();
        xhttp.open('POST', '../../controllers/AdminController.php', true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                try {
                    const response = JSON.parse(this.responseText);
                    if (response.success) {
                        showMessage(response.message || 'Hotel added successfully!', 'success');
                        closeHotelModal();
                        loadHotels();
                    } else {
                        document.getElementById('hotelMsg').textContent = response.message || 'Failed to add hotel.';
                    }
                } catch (e) {
                    document.getElementById('hotelMsg').textContent = 'Server error occurred.';
                }
            }
        };
        xhttp.send('json=' + json);
    };
}

function closeHotelModal() {
    const modal = document.getElementById('hotelModal');
    if (modal) {
        modal.remove();
    }
}

function viewHotel(id) {
    showMessage(`View hotel #${id} feature will be implemented soon`, 'info');
}

function editHotel(id) {
    showMessage(`Edit hotel #${id} feature will be implemented soon`, 'info');
}

function deleteHotelConfirm(id) {
    if (!confirm('Are you sure you want to delete this hotel? This will also delete all associated rooms and bookings.')) return;
    
    const json = JSON.stringify({
        action: 'deleteHotel',
        hotel_id: id
    });
    
    const xhttp = new XMLHttpRequest();
    xhttp.open('POST', '../../controllers/AdminController.php', true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const response = JSON.parse(this.responseText);
            if (response.success) {
                showMessage('Hotel deleted successfully!', 'success');
                loadHotels();
            } else {
                showMessage('Failed to delete hotel.', 'error');
            }
        }
    };
    xhttp.send('json=' + json);
}

// Action functions (placeholders for modal implementations)
function viewBooking(id) { showMessage(`View booking #${id}`, 'info'); }
function editBooking(id) { showMessage(`Edit booking #${id}`, 'info'); }
function viewUser(id) { showMessage(`View user #${id}`, 'info'); }
function viewTransaction(id) { showMessage(`View transaction #${id}`, 'info'); }
function generateInvoice(id) { showMessage(`Generate invoice for transaction #${id}`, 'info'); }