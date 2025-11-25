class TransportPage {
    constructor() {
        this.travelers = {
            adults: 2,
            children: 0,
            infants: 0
        };
        this.selectedClass = 'economy';
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadFlightOptions();
    }

    setupEventListeners() {
        // Tab switching
        const tabBtns = document.querySelectorAll('.search-tabs .tab-btn');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.switchTransportTab(e.currentTarget.dataset.type));
        });

        // Trip type buttons
        const tripTypeBtns = document.querySelectorAll('.trip-type-btn');
        tripTypeBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.switchTripType(e.currentTarget.dataset.trip));
        });

        // Class selection
        const classBtns = document.querySelectorAll('.class-btn');
        classBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.selectClass(e.currentTarget.dataset.class));
        });

        // Date inputs
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => {
            input.addEventListener('change', (e) => this.updateDateDisplay(e.target));
        });

        // Initialize date displays
        this.initializeDateDisplays();
    }

    switchTransportTab(type) {
        const tabBtns = document.querySelectorAll('.search-tabs .tab-btn');
        const forms = document.querySelectorAll('.search-form');

        tabBtns.forEach(btn => btn.classList.remove('active'));
        forms.forEach(form => form.classList.remove('active'));

        document.querySelector(`[data-type="${type}"]`).classList.add('active');
        document.getElementById(`${type}Search`).classList.add('active');

        if (type === 'flight') {
            this.loadFlightOptions();
        }
    }

    switchTripType(tripType) {
        const tripTypeBtns = document.querySelectorAll('.trip-type-btn');
        tripTypeBtns.forEach(btn => btn.classList.remove('active'));
        document.querySelector(`[data-trip="${tripType}"]`).classList.add('active');

        // Show/hide return date based on trip type
        const returnDateField = document.querySelector('.date-field:nth-child(2)');
        if (tripType === 'oneway') {
            returnDateField.style.opacity = '0.5';
            returnDateField.style.pointerEvents = 'none';
        } else {
            returnDateField.style.opacity = '1';
            returnDateField.style.pointerEvents = 'all';
        }
    }

    swapLocations() {
        const fromInput = document.getElementById('flightFrom');
        const toInput = document.getElementById('flightTo');
        
        const temp = fromInput.value;
        fromInput.value = toInput.value;
        toInput.value = temp;

        this.showNotification('Locations swapped!', 'info');
    }

    initializeDateDisplays() {
        const dateInputs = document.querySelectorAll('input[type="date"]');
        dateInputs.forEach(input => this.updateDateDisplay(input));
    }

    updateDateDisplay(input) {
        const display = input.parentElement.querySelector('.date-display');
        if (display && input.value) {
            const date = new Date(input.value);
            display.textContent = date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }
    }

    openTravelersModal() {
        document.getElementById('travelersModal').style.display = 'block';
        this.updateTravelersModal();
    }

    closeTravelersModal() {
        document.getElementById('travelersModal').style.display = 'none';
    }

    updateTravelersModal() {
        document.getElementById('adultsCount').textContent = this.travelers.adults;
        document.getElementById('childrenCount').textContent = this.travelers.children;
        document.getElementById('infantsCount').textContent = this.travelers.infants;

        // Update class buttons
        const classBtns = document.querySelectorAll('.class-btn');
        classBtns.forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.class === this.selectedClass) {
                btn.classList.add('active');
            }
        });
    }

    adjustTravelerCount(type, change) {
        const newCount = this.travelers[type] + change;
        
        // Validation
        if (newCount >= 0) {
            if (type === 'adults' && newCount === 0) return; // Need at least 1 adult
            if (type === 'infants' && newCount > this.travelers.adults) return; // Infants can't exceed adults
            
            this.travelers[type] = newCount;
            this.updateTravelersModal();
        }
    }

    selectClass(className) {
        this.selectedClass = className;
        this.updateTravelersModal();
    }

    applyTravelers() {
        const totalTravelers = this.travelers.adults + this.travelers.children;
        const travelersText = `${totalTravelers} ${totalTravelers === 1 ? 'Traveler' : 'Travelers'}`;
        const classText = this.selectedClass.charAt(0).toUpperCase() + this.selectedClass.slice(1);
        
        document.querySelector('.travelers-summary').innerHTML = `
            <span class="travelers-count">${travelersText}</span>
            <span class="travelers-class">• ${classText}</span>
        `;
        
        this.closeTravelersModal();
        this.showNotification('Travelers updated!', 'success');
    }

    searchFlights() {
        const from = document.getElementById('flightFrom').value;
        const to = document.getElementById('flightTo').value;
        const departure = document.getElementById('departureDate').value;

        if (!from || !to || !departure) {
            this.showNotification('Please fill in all required fields', 'error');
            return;
        }

        this.showNotification(`Searching flights from ${from} to ${to}...`, 'info');
        
        // Simulate search
        setTimeout(() => {
            this.loadFlightOptions();
            this.showNotification(`Found 15 flights for your dates!`, 'success');
        }, 1500);
    }

    clearSearch() {
        document.getElementById('flightFrom').value = '';
        document.getElementById('flightTo').value = '';
        document.getElementById('departureDate').value = '';
        document.getElementById('returnDate').value = '';
        
        this.travelers = { adults: 1, children: 0, infants: 0 };
        this.selectedClass = 'economy';
        this.applyTravelers();
        
        this.initializeDateDisplays();
        this.showNotification('Search cleared!', 'info');
    }

    loadFlightOptions() {
        const grid = document.getElementById('transportGrid');
        if (!grid) return;

        const flights = [
            {
                id: 1,
                airline: 'Sky Airlines',
                flightNumber: 'SA 245',
                route: 'JFK → CDG',
                departure: '08:00 AM',
                arrival: '09:30 PM',
                duration: '7h 30m',
                price: 450,
                stops: 'Non-stop',
                aircraft: 'Boeing 787',
                features: ['Meal', 'Entertainment', 'WiFi', '23kg Baggage'],
                rating: 4.5
            },
            {
                id: 2,
                airline: 'Global Airways',
                flightNumber: 'GA 178',
                route: 'JFK → CDG',
                departure: '02:30 PM',
                arrival: '03:15 AM',
                duration: '7h 45m',
                price: 520,
                stops: 'Non-stop',
                aircraft: 'Airbus A350',
                features: ['Meal', 'Extra Legroom', 'WiFi', '30kg Baggage'],
                rating: 4.7
            },
            {
                id: 3,
                airline: 'Oceanic Airlines',
                flightNumber: 'OA 312',
                route: 'JFK → CDG',
                departure: '10:15 PM',
                arrival: '11:45 AM',
                duration: '8h 30m',
                price: 380,
                stops: '1 Stop (LHR)',
                aircraft: 'Boeing 777',
                features: ['Meal', 'WiFi', '23kg Baggage'],
                rating: 4.2
            }
        ];

        grid.innerHTML = flights.map(flight => `
            <div class="transport-card" onclick="transportPage.selectFlight(${flight.id})">
                <div class="transport-header">
                    <div class="airline-info">
                        <i class="fas fa-plane"></i>
                        <div>
                            <div class="transport-company">${flight.airline}</div>
                            <div class="flight-number">${flight.flightNumber}</div>
                        </div>
                    </div>
                    <div class="flight-price">$${flight.price}</div>
                </div>
                
                <div class="transport-content">
                    <div class="flight-route">
                        <div class="route-time">
                            <div class="time">${flight.departure}</div>
                            <div class="airport">JFK</div>
                        </div>
                        
                        <div class="route-duration">
                            <div class="duration">${flight.duration}</div>
                            <div class="route-line">
                                <div class="line"></div>
                                <i class="fas fa-plane"></i>
                            </div>
                            <div class="stops">${flight.stops}</div>
                        </div>
                        
                        <div class="route-time">
                            <div class="time">${flight.arrival}</div>
                            <div class="airport">CDG</div>
                        </div>
                    </div>
                    
                    <div class="flight-details">
                        <div class="detail-item">
                            <i class="fas fa-plane"></i>
                            <span>${flight.aircraft}</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-star" style="color: #ffd700;"></i>
                            <span>${flight.rating}/5</span>
                        </div>
                    </div>
                    
                    <div class="transport-features">
                        ${flight.features.map(feature => `
                            <span class="feature-tag">${feature}</span>
                        `).join('')}
                    </div>
                    
                    <div class="flight-actions">
                        <button class="btn btn-primary" onclick="event.stopPropagation(); transportPage.bookFlight(${flight.id})">
                            <i class="fas fa-shopping-cart"></i> Select
                        </button>
                        <button class="btn btn-outline" onclick="event.stopPropagation(); transportPage.viewFlightDetails(${flight.id})">
                            <i class="fas fa-info-circle"></i> Details
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    selectFlight(flightId) {
        const cards = document.querySelectorAll('.transport-card');
        cards.forEach(card => card.classList.remove('selected'));
        event.currentTarget.classList.add('selected');
        
        this.showNotification('Flight selected! Click "Select" to proceed.', 'info');
    }

    bookFlight(flightId) {
        const flight = this.findFlightById(flightId);
        if (flight) {
            this.showNotification(`Booking ${flight.airline} ${flight.flightNumber} for $${flight.price}`, 'success');
            // In real app, open booking process
        }
    }

    viewFlightDetails(flightId) {
        const flight = this.findFlightById(flightId);
        if (flight) {
            this.showNotification(`Details for ${flight.airline} ${flight.flightNumber}`, 'info');
            // In real app, show detailed modal
        }
    }

    findFlightById(id) {
        const flights = [
            { id: 1, airline: 'Sky Airlines', flightNumber: 'SA 245', price: 450 },
            { id: 2, airline: 'Global Airways', flightNumber: 'GA 178', price: 520 },
            { id: 3, airline: 'Oceanic Airlines', flightNumber: 'OA 312', price: 380 }
        ];
        return flights.find(flight => flight.id === id);
    }

    quickSearch(type) {
        this.switchTransportTab(type);
        this.showNotification(`Searching for ${type} options...`, 'info');
    }

    sortFlights(criteria) {
        this.showNotification(`Sorting flights by ${criteria}...`, 'info');
        // Implementation would sort the flight options
    }

    filterStops(stops) {
        this.showNotification(`Filtering by ${stops}...`, 'info');
        // Implementation would filter flight options
    }

    filterPrice(range) {
        this.showNotification(`Filtering by price range: ${range}...`, 'info');
        // Implementation would filter flight options
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span>${message}</span>
            <button class="notification-close" onclick="this.parentElement.remove()">&times;</button>
        `;

        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'success' ? '#27ae60' : type === 'error' ? '#e74c3c' : '#3498db'};
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 3000;
            display: flex;
            align-items: center;
            gap: 15px;
            animation: slideInRight 0.3s ease;
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 4000);
    }
}

// Initialize transport page
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('transport.html')) {
        window.transportPage = new TransportPage();
    }
});