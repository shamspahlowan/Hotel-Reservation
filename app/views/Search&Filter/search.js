let allRooms = [];
let filteredRooms = [];

const searchInput = document.getElementById("searchInput");
const roomType = document.getElementById("roomType");
const priceRange = document.getElementById("priceRange");
const wifiCheck = document.getElementById("wifi");
const acCheck = document.getElementById("ac");
const resultsDiv = document.getElementById("results");
const loadingDiv = document.getElementById("loading");

async function loadRooms() {
    showLoading(true);
    try {
        const params = new URLSearchParams(window.location.search);
        const searchParams = new URLSearchParams({
            action: 'searchRooms',
            keyword: searchInput.value,
            room_type: roomType.value,
            checkin: params.get('checkin') || '',
            checkout: params.get('checkout') || '',
            guests: params.get('guests') || ''
        });
        
        const response = await fetch(`../../controllers/SearchController.php?${searchParams}`);
        const data = await response.json();
        
        if (Array.isArray(data)) {
            allRooms = data;
            filterRooms();
        } else {
            console.error('Error loading rooms:', data);
            displayError('Failed to load rooms. Please try again.');
        }
    } catch (error) {
        console.error('Error:', error);
        displayError('Failed to load rooms. Please try again.');
    } finally {
        showLoading(false);
    }
}

function displayRooms(rooms) {
    resultsDiv.innerHTML = "";
    
    if (rooms.length === 0) {
        resultsDiv.innerHTML = `
            <div class="no-results">
                <h3>No rooms found</h3>
                <p>Try adjusting your search criteria or dates.</p>
            </div>`;
        return;
    }

    rooms.forEach((room) => {
        const div = document.createElement("div");
        div.className = "room-card";
        
        const amenitiesList = room.amenities ? room.amenities.split(',').map(a => a.trim()) : [];
        const hotelAmenities = room.hotel_amenities ? room.hotel_amenities.split(',').map(a => a.trim()) : [];
        const allAmenities = [...new Set([...amenitiesList, ...hotelAmenities])];
        
        const rating = parseFloat(room.room_rating || room.hotel_rating || 0);
        const reviewCount = parseInt(room.review_count || 0);
        
        const price = parseFloat(room.price || 0);
        
        div.innerHTML = `
            <div class="room-image">
                <img src="${room.image || room.hotel_image || '../../public/assets/room1.jpg'}" 
                     alt="${room.type} room at ${room.hotel_name}" />
                <div class="room-price">$${price.toFixed(0)}<span>/night</span></div>
            </div>
            <div class="room-content">
                <div class="room-header">
                    <h3>${room.type} Room</h3>
                    <div class="hotel-info">
                        <strong>${room.hotel_name}</strong>
                        <p><i class="location-icon">📍</i> ${room.city}, ${room.state}</p>
                    </div>
                </div>
                
                <div class="room-rating">
                    <div class="stars">${generateStars(rating)}</div>
                    <span class="rating-text">${rating.toFixed(1)} (${reviewCount} reviews)</span>
                </div>
                
                <div class="room-details">
                    <p><strong>Capacity:</strong> ${room.capacity || 2} guests</p>
                    <p><strong>Size:</strong> ${room.size || 'Standard'}</p>
                    <div class="amenities">
                        <strong>Amenities:</strong>
                        <div class="amenity-tags">
                            ${allAmenities.slice(0, 4).map(amenity => 
                                `<span class="amenity-tag">${amenity}</span>`
                            ).join('')}
                            ${allAmenities.length > 4 ? `<span class="amenity-more">+${allAmenities.length - 4} more</span>` : ''}
                        </div>
                    </div>
                </div>
                
                <div class="room-actions">
                    <button class="btn-secondary" onclick="viewRoomDetails(${room.id})">View Details</button>
                    <button class="btn-primary" onclick="bookRoom(${room.id})">Book Now</button>
                </div>
            </div>
        `;
        resultsDiv.appendChild(div);
    });
}

function generateStars(rating) {
    const numRating = parseFloat(rating) || 0;
    const fullStars = Math.floor(numRating);
    const hasHalfStar = (numRating % 1) >= 0.5;
    const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
    
    return '★'.repeat(fullStars) + 
           (hasHalfStar ? '☆' : '') + 
           '☆'.repeat(emptyStars);
}

function filterRooms() {
    const keyword = searchInput.value.toLowerCase();
    const selectedType = roomType.value;
    const selectedPrice = priceRange.value;
    const wantWiFi = wifiCheck.checked;
    const wantAC = acCheck.checked;

    filteredRooms = allRooms.filter((room) => {
        const matchesKeyword = keyword === '' ||
            room.hotel_name.toLowerCase().includes(keyword) ||
            room.city.toLowerCase().includes(keyword) ||
            room.type.toLowerCase().includes(keyword);
            
        const matchesType = !selectedType || room.type === selectedType;

        let matchesPrice = true;
        if (selectedPrice) {
            const [min, max] = selectedPrice.split("-").map(Number);
            matchesPrice = room.price >= min && room.price <= max;
        }

        const amenities = (room.amenities || '').toLowerCase() + ' ' + (room.hotel_amenities || '').toLowerCase();
        const matchesWiFi = !wantWiFi || amenities.includes('wi-fi') || amenities.includes('wifi');
        const matchesAC = !wantAC || amenities.includes('ac') || amenities.includes('air conditioning');

        return matchesKeyword && matchesType && matchesPrice && matchesWiFi && matchesAC;
    });

    displayRooms(filteredRooms);
}

function showLoading(show) {
    if (loadingDiv) {
        loadingDiv.style.display = show ? 'block' : 'none';
    }
    resultsDiv.style.display = show ? 'none' : 'block';
}

function displayError(message) {
    resultsDiv.innerHTML = `
        <div class="error-message">
            <h3>Oops! Something went wrong</h3>
            <p>${message}</p>
            <button onclick="loadRooms()" class="btn-primary">Try Again</button>
        </div>`;
}

function viewRoomDetails(roomId) {
    const params = new URLSearchParams(window.location.search);
    window.location.href = `../../views/RoomTypes/room-types.php`;
}

function bookRoom(roomId) {
    const params = new URLSearchParams(window.location.search);
    window.location.href = `../../views/GroupBookings/group-bookings.php`;
}

function initializeSearch() {
    const params = new URLSearchParams(window.location.search);
    const destination = params.get("destination") || "";
    const guests = params.get("guests") || "";

    searchInput.value = destination;

    let inferredType = "";
    const guestCount = parseInt(guests) || 1;
    if (guestCount === 1) {
        inferredType = "Single";
    } else if (guestCount === 2) {
        inferredType = "Double";
    } else if (guestCount > 2) {
        inferredType = "Suite";
    }
    if (inferredType) {
        roomType.value = inferredType;
    }

    loadRooms();
}

searchInput.addEventListener("input", () => {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(filterRooms, 300);
});

roomType.addEventListener("change", filterRooms);
priceRange.addEventListener("change", filterRooms);
wifiCheck.addEventListener("change", filterRooms);
acCheck.addEventListener("change", filterRooms);

document.addEventListener("DOMContentLoaded", initializeSearch);