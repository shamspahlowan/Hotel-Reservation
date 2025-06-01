let hotels = [];
let rooms = [];
let guests = [];
let selectedRooms = [];

document.addEventListener('DOMContentLoaded', function() {
    loadHotels();
    updateCheckoutMinDate();
});

async function loadHotels() {
    try {
        const response = await fetch('../../controllers/BookingController.php?action=getHotels');
        const data = await response.json();
        
        if (Array.isArray(data)) {
            hotels = data;
            updateHotelSelects();
        } else {
            console.error('Error loading hotels:', data);
            showError('Failed to load hotels');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('Failed to load hotels');
    }
}

function updateHotelSelects() {
    const singleHotelSelect = document.getElementById('single-hotel');
    const groupHotelSelect = document.getElementById('group-hotel');
    
    singleHotelSelect.innerHTML = '<option value="">Select a hotel</option>';
    groupHotelSelect.innerHTML = '<option value="">Select a hotel</option>';
    
    hotels.forEach(hotel => {
        const rating = parseFloat(hotel.rating || 0);
        const option = `<option value="${hotel.id}">${hotel.name} - ${hotel.city} (${rating}★)</option>`;
        singleHotelSelect.innerHTML += option;
        groupHotelSelect.innerHTML += option;
    });
}

async function loadHotelRooms(hotelId, targetSelectId) {
    if (!hotelId) return;
    
    try {
        const response = await fetch(`../../controllers/BookingController.php?action=getHotelRooms&hotel_id=${hotelId}`);
        const data = await response.json();
        
        if (Array.isArray(data)) {
            rooms = data;
            updateRoomSelects(targetSelectId);
        } else {
            console.error('Error loading rooms:', data);
            showError('Failed to load rooms');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('Failed to load rooms');
    }
}

function updateRoomSelects(targetSelectId) {
    const roomSelect = document.getElementById(targetSelectId);
    roomSelect.innerHTML = '<option value="">Select a room</option>';
    
    const roomTypes = {};
    rooms.forEach(room => {
        if (!roomTypes[room.type]) {
            roomTypes[room.type] = [];
        }
        roomTypes[room.type].push(room);
    });
    
    Object.keys(roomTypes).forEach(type => {
        const roomsOfType = roomTypes[type];
        const minPrice = Math.min(...roomsOfType.map(r => parseFloat(r.price)));
        const option = `<option value="${type}">${type} Room (from $${minPrice}/night) - ${roomsOfType.length} available</option>`;
        roomSelect.innerHTML += option;
    });
}

document.getElementById('single-hotel').addEventListener('change', function() {
    loadHotelRooms(this.value, 'single-room');
});

document.getElementById('group-hotel').addEventListener('change', function() {
    loadHotelRooms(this.value, 'room-type');
});

function updateCheckoutMinDate() {
    const checkinInputs = ['single-checkin', 'group-checkin'];
    const checkoutInputs = ['single-checkout', 'group-checkout'];
    
    const today = new Date().toISOString().split('T')[0];
    checkinInputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) input.min = today;
    });
    
    checkinInputs.forEach((checkinId, index) => {
        const checkinInput = document.getElementById(checkinId);
        const checkoutInput = document.getElementById(checkoutInputs[index]);
        
        if (checkinInput && checkoutInput) {
            checkinInput.addEventListener('change', function() {
                if (this.value) {
                    const checkinDate = new Date(this.value);
                    checkinDate.setDate(checkinDate.getDate() + 1);
                    checkoutInput.min = checkinDate.toISOString().split('T')[0];
                    checkoutInput.value = '';
                }
            });
        }
    });
}

function showTab(tabId) {
    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
    document.querySelector(`[onclick="showTab('${tabId}')"]`).classList.add('active');
    document.getElementById(tabId).classList.add('active');
}

function addGuest() {
    const name = document.getElementById('guest-name').value.trim();
    const email = document.getElementById('guest-email').value.trim();
    const guestList = document.getElementById('guest-list');

    if (name === '' || email === '') {
        guestList.innerHTML = '<span class="highlight">Please enter guest name and email.</span>';
        return;
    }

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        guestList.innerHTML = '<span class="highlight">Please enter a valid email address.</span>';
        return;
    }

    guests.push({ name, email });
    document.getElementById('guest-name').value = '';
    document.getElementById('guest-email').value = '';
    updateGuestList();
}

function updateGuestList() {
    const guestList = document.getElementById('guest-list');
    guestList.innerHTML = guests.length === 0 ? 'No guests added.' : '';
    guests.forEach((guest, index) => {
        const div = document.createElement('div');
        div.className = 'guest-entry';
        div.innerHTML = `
            ${guest.name} (${guest.email})
            <button class="remove-guest" onclick="removeGuest(${index})">Remove</button>
        `;
        guestList.appendChild(div);
    });
}

function removeGuest(index) {
    guests.splice(index, 1);
    updateGuestList();
}

function addRoom() {
    const roomType = document.getElementById('room-type').value;
    const quantity = parseInt(document.getElementById('room-quantity').value) || 0;
    const roomList = document.getElementById('room-list');

    if (!roomType) {
        roomList.innerHTML = '<span class="highlight">Please select a room type.</span>';
        return;
    }

    if (quantity <= 0) {
        roomList.innerHTML = '<span class="highlight">Please enter a valid room quantity.</span>';
        return;
    }

    const availableRooms = rooms.filter(r => r.type === roomType).length;
    const alreadySelected = selectedRooms.filter(r => r.type === roomType).reduce((sum, r) => sum + r.quantity, 0);
    
    if (alreadySelected + quantity > availableRooms) {
        roomList.innerHTML = `<span class="highlight">Only ${availableRooms - alreadySelected} ${roomType} rooms available.</span>`;
        return;
    }

    selectedRooms.push({ type: roomType, quantity });
    document.getElementById('room-quantity').value = '';
    updateRoomList();
}

function updateRoomList() {
    const roomList = document.getElementById('room-list');
    roomList.innerHTML = selectedRooms.length === 0 ? 'No rooms selected.' : '';
    selectedRooms.forEach((room, index) => {
        const roomsOfType = rooms.filter(r => r.type === room.type);
        const minPrice = roomsOfType.length > 0 ? Math.min(...roomsOfType.map(r => parseFloat(r.price))) : 0;
        
        const div = document.createElement('div');
        div.innerHTML = `
            ${room.quantity} x ${room.type} Room (from $${minPrice}/night)
            <button class="remove-guest" onclick="removeRoom(${index})">Remove</button>
        `;
        roomList.appendChild(div);
    });
}

function removeRoom(index) {
    selectedRooms.splice(index, 1);
    updateRoomList();
}

function calculateNights(checkIn, checkOut) {
    const checkInDate = new Date(checkIn);
    const checkOutDate = new Date(checkOut);
    const timeDiff = checkOutDate - checkInDate;
    return Math.ceil(timeDiff / (1000 * 60 * 60 * 24));
}

async function submitSingleBooking() {
    const hotelId = document.getElementById('single-hotel').value;
    const roomType = document.getElementById('single-room').value;
    const checkIn = document.getElementById('single-checkin').value;
    const checkOut = document.getElementById('single-checkout').value;
    const result = document.getElementById('single-result');

    console.log('Form values:', { hotelId, roomType, checkIn, checkOut });

    if (!hotelId || !roomType || !checkIn || !checkOut) {
        result.innerHTML = '<span class="highlight">Please fill all required fields.</span>';
        result.className = 'result error';
        return;
    }

    const currentDate = new Date().toISOString().split('T')[0];
    if (checkIn < currentDate || checkOut <= checkIn) {
        result.innerHTML = '<span class="highlight">Invalid dates. Check-in must be today or later, and check-out must be after check-in.</span>';
        result.className = 'result error';
        return;
    }

    const availableRoom = rooms.find(r => r.type === roomType);
    if (!availableRoom) {
        result.innerHTML = '<span class="highlight">No rooms of selected type available.</span>';
        result.className = 'result error';
        return;
    }

    try {
        result.innerHTML = 'Processing booking...';
        result.className = 'result';
        
        const bookingData = {
            action: 'createSingleBooking',
            room_id: availableRoom.id,
            checkin_date: checkIn,
            checkout_date: checkOut,
            guests: 1,
            special_requests: '' 
        };

        console.log('Sending booking data:', bookingData);

        const response = await fetch('../../controllers/BookingController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(bookingData)
        });

        const data = await response.json();
        console.log('Response data:', data);

        if (data.success) {
            const hotel = hotels.find(h => h.id == hotelId);
            const nights = calculateNights(checkIn, checkOut);
            
            result.innerHTML = `
                <strong>Booking Confirmed!</strong><br>
                <strong>Booking Reference:</strong> ${data.booking_reference || 'N/A'}<br>
                <strong>Hotel:</strong> ${hotel.name}<br>
                <strong>Room:</strong> ${availableRoom.type} Room<br>
                <strong>Check-in:</strong> ${checkIn}<br>
                <strong>Check-out:</strong> ${checkOut}<br>
                <strong>Nights:</strong> ${nights}<br>
                <strong>Guests:</strong> 1<br>
                <strong>Total Cost:</strong> <span class="highlight">$${data.total_amount}</span><br>
                <br>
                <button onclick="window.location.href='../Billing/payment.php?booking_id=${data.booking_id}'" class="book-btn">
                    Proceed to Payment
                </button>
            `;
            result.className = 'result success';
        } else {
            result.innerHTML = `<span class="highlight">${data.message}</span>`;
            result.className = 'result error';
        }
    } catch (error) {
        console.error('Error:', error);
        result.innerHTML = '<span class="highlight">Failed to create booking. Please try again.</span>';
        result.className = 'result error';
    }
}

async function submitGroupBooking() {
    const hotelId = document.getElementById('group-hotel').value;
    const checkIn = document.getElementById('group-checkin').value;
    const checkOut = document.getElementById('group-checkout').value;
    const paymentTerms = document.getElementById('payment-terms').value;
    const eventSpace = document.getElementById('event-space').value;
    const result = document.getElementById('group-result');

    console.log('Group booking values:', { hotelId, checkIn, checkOut, guestsCount: guests.length, roomsCount: selectedRooms.length });

    if (!hotelId || !checkIn || !checkOut || guests.length === 0 || selectedRooms.length === 0) {
        result.innerHTML = '<span class="highlight">Please fill all required fields, add at least one guest, and select at least one room.</span>';
        result.className = 'result error';
        return;
    }

    const currentDate = new Date().toISOString().split('T')[0];
    if (checkIn < currentDate || checkOut <= checkIn) {
        result.innerHTML = '<span class="highlight">Invalid dates. Check-in must be today or later, and check-out must be after check-in.</span>';
        result.className = 'result error';
        return;
    }

    try {
        result.innerHTML = 'Processing group booking...';
        result.className = 'result';
        
        const bookingData = {
            action: 'createGroupBooking',
            hotel_id: hotelId,
            checkin_date: checkIn,
            checkout_date: checkOut,
            rooms: selectedRooms,
            guests: guests,
            payment_terms: paymentTerms,
            event_space: eventSpace,
            special_requests: ''
        };

        console.log('Sending group booking data:', bookingData);

        const response = await fetch('../../controllers/BookingController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(bookingData)
        });

        const data = await response.json();
        console.log('Group response data:', data);

        if (data.success) {
            const hotel = hotels.find(h => h.id == hotelId);
            const nights = calculateNights(checkIn, checkOut);
            const guestList = guests.map(g => `${g.name} (${g.email})`).join('<br>');
            const roomSummary = selectedRooms.map(r => `${r.quantity} x ${r.type} Room`).join('<br>');
            
            result.innerHTML = `
                <strong>Group Booking Confirmed!</strong><br>
                <strong>Group Reference:</strong> ${data.group_reference}<br>
                <strong>Hotel:</strong> ${hotel.name}<br>
                <strong>Check-in:</strong> ${checkIn}<br>
                <strong>Check-out:</strong> ${checkOut}<br>
                <strong>Nights:</strong> ${nights}<br>
                <strong>Guests:</strong><br>${guestList}<br>
                <strong>Rooms:</strong><br>${roomSummary}<br>
                <strong>Payment Terms:</strong> ${paymentTerms}<br>
                <strong>Event Space:</strong> ${eventSpace}<br>
                <strong>Total Cost:</strong> <span class="highlight">$${data.total_amount}</span><br>
                <br>
                <button onclick="window.location.href='../Billing/payment.php?booking_id=${data.booking_ids[0]}&group=true'" class="book-btn">
                    Proceed to Payment
                </button>
            `;
            result.className = 'result success';
        } else {
            result.innerHTML = `<span class="highlight"> ${data.message}</span>`;
            result.className = 'result error';
        }
    } catch (error) {
        console.error('Error:', error);
        result.innerHTML = '<span class="highlight"> Failed to create group booking. Please try again.</span>';
        result.className = 'result error';
    }
}

function showError(message) {
    console.error(message);
}