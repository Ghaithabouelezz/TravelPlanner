class TripsPage {
    constructor() {
        this.currentStep = 1;
        this.totalSteps = 5;
        this.tripData = {
            destination: 'paris',
            startDate: '',
            endDate: '',
            style: 'comfort',
            preferences: ['food'],
            budget: 2100
        };
        this.init();
    }

    init() {
        this.loadTrips();
        this.setupEventListeners();
        this.renderTrips();
        this.initTripBuilder();
    }

    loadTrips() {
        // Load trips from data.js or localStorage
        this.trips = window.travelData?.userTrips || [];
    }

    setupEventListeners() {
        // Create Trip Modal
        const createBtn = document.getElementById('createTripBtn');
        const cancelBtn = document.getElementById('cancelTripBtn');
        const saveBtn = document.getElementById('saveTripBtn');
        const quickPlanBtn = document.getElementById('quickPlanBtn');

        if (createBtn) createBtn.addEventListener('click', () => this.openCreateModal());
        if (cancelBtn) cancelBtn.addEventListener('click', () => this.closeCreateModal());
        if (saveBtn) saveBtn.addEventListener('click', () => this.saveTrip());
        if (quickPlanBtn) quickPlanBtn.addEventListener('click', () => this.startQuickPlan());

        // Tab functionality
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.switchTab(e.target.dataset.tab));
        });
    }

    initTripBuilder() {
        const nextBtn = document.getElementById('nextStepBtn');
        const prevBtn = document.getElementById('prevStepBtn');
        const createFinalBtn = document.getElementById('createTripFinalBtn');

        if (nextBtn) nextBtn.addEventListener('click', () => this.nextStep());
        if (prevBtn) prevBtn.addEventListener('click', () => this.previousStep());
        if (createFinalBtn) createFinalBtn.addEventListener('click', () => this.createTripFromBuilder());

        // Destination selection
        const destinationOptions = document.querySelectorAll('.destination-option');
        destinationOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                destinationOptions.forEach(opt => opt.classList.remove('active'));
                e.currentTarget.classList.add('active');
                this.tripData.destination = e.currentTarget.dataset.destination;
                this.updateSummary();
            });
        });

        // Style selection
        const styleOptions = document.querySelectorAll('.style-option');
        styleOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                styleOptions.forEach(opt => opt.classList.remove('active'));
                e.currentTarget.classList.add('active');
                this.tripData.style = e.currentTarget.dataset.style;
                this.updateBudget();
                this.updateSummary();
            });
        });

        // Preferences selection
        const preferenceOptions = document.querySelectorAll('.preference-option');
        preferenceOptions.forEach(option => {
            option.addEventListener('click', (e) => {
                e.currentTarget.classList.toggle('active');
                this.updatePreferences();
                this.updateSummary();
            });
        });

        // Date inputs
        const dateInputs = document.querySelectorAll('.date-input');
        dateInputs.forEach(input => {
            input.addEventListener('change', () => this.updateDuration());
        });

        this.updateProgress();
    }

    nextStep() {
        if (this.currentStep < this.totalSteps) {
            this.currentStep++;
            this.updateBuilderUI();
        }
    }

    previousStep() {
        if (this.currentStep > 1) {
            this.currentStep--;
            this.updateBuilderUI();
        }
    }

    updateBuilderUI() {
        // Update step visibility
        const steps = document.querySelectorAll('.builder-step');
        steps.forEach(step => {
            step.classList.remove('active');
            if (parseInt(step.dataset.step) === this.currentStep) {
                step.classList.add('active');
            }
        });

        // Update buttons
        const prevBtn = document.getElementById('prevStepBtn');
        const nextBtn = document.getElementById('nextStepBtn');
        const createFinalBtn = document.getElementById('createTripFinalBtn');

        if (prevBtn) prevBtn.disabled = this.currentStep === 1;
        if (nextBtn) nextBtn.style.display = this.currentStep === this.totalSteps ? 'none' : 'flex';
        if (createFinalBtn) createFinalBtn.style.display = this.currentStep === this.totalSteps ? 'flex' : 'none';

        this.updateProgress();
        this.updateSummary();
    }

    updateProgress() {
        const progressFill = document.querySelector('.progress-fill');
        const progressText = document.querySelector('.progress-text');
        
        if (progressFill) {
            const progress = (this.currentStep / this.totalSteps) * 100;
            progressFill.style.width = `${progress}%`;
        }
        
        if (progressText) {
            progressText.textContent = `Step ${this.currentStep} of ${this.totalSteps}`;
        }
    }

    updateDuration() {
        const startInput = document.querySelector('input[type="date"]');
        const endInput = document.querySelectorAll('input[type="date"]')[1];
        const durationValue = document.querySelector('.duration-value');

        if (startInput?.value && endInput?.value) {
            const start = new Date(startInput.value);
            const end = new Date(endInput.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            this.tripData.startDate = startInput.value;
            this.tripData.endDate = endInput.value;

            if (durationValue) {
                durationValue.textContent = `${diffDays} days`;
            }
        }
    }

    updateBudget() {
        // Calculate budget based on destination and style
        const basePrices = {
            paris: { budget: 1200, comfort: 2100, luxury: 3500 },
            tokyo: { budget: 1000, comfort: 1800, luxury: 3000 },
            bali: { budget: 800, comfort: 1500, luxury: 2500 },
            newyork: { budget: 1500, comfort: 2500, luxury: 4000 }
        };

        const destination = this.tripData.destination;
        const style = this.tripData.style;
        
        if (basePrices[destination] && basePrices[destination][style]) {
            this.tripData.budget = basePrices[destination][style];
        }
    }

    updatePreferences() {
        const activePreferences = document.querySelectorAll('.preference-option.active');
        this.tripData.preferences = Array.from(activePreferences).map(pref => pref.dataset.preference);
    }

    updateSummary() {
        const summaryDest = document.getElementById('summary-destination');
        const summaryDuration = document.getElementById('summary-duration');
        const summaryStyle = document.getElementById('summary-style');
        const summaryInterests = document.getElementById('summary-interests');
        const summaryBudget = document.getElementById('summary-budget');

        if (summaryDest) {
            const destNames = {
                paris: 'Paris, France',
                tokyo: 'Tokyo, Japan',
                bali: 'Bali, Indonesia',
                newyork: 'New York, USA'
            };
            summaryDest.textContent = destNames[this.tripData.destination] || this.tripData.destination;
        }

        if (summaryDuration) {
            summaryDuration.textContent = '7 days'; // This would be calculated
        }

        if (summaryStyle) {
            summaryStyle.textContent = this.tripData.style.charAt(0).toUpperCase() + this.tripData.style.slice(1);
        }

        if (summaryInterests) {
            summaryInterests.textContent = this.tripData.preferences.map(p => 
                p.charAt(0).toUpperCase() + p.slice(1)
            ).join(', ');
        }

        if (summaryBudget) {
            summaryBudget.textContent = `$${this.tripData.budget.toLocaleString()}`;
        }
    }

    createTripFromBuilder() {
        const tripName = `${this.tripData.destination.charAt(0).toUpperCase() + this.tripData.destination.slice(1)} ${this.tripData.style.charAt(0).toUpperCase() + this.tripData.style.slice(1)} Trip`;
        
        const newTrip = {
            id: Date.now(),
            name: tripName,
            destination: this.tripData.destination,
            startDate: this.tripData.startDate || '2024-06-15',
            endDate: this.tripData.endDate || '2024-06-22',
            style: this.tripData.style,
            preferences: this.tripData.preferences,
            budget: this.tripData.budget,
            status: 'planned'
        };

        this.saveTripToStorage(newTrip);
        this.showNotification('Trip created successfully!', 'success');
        this.resetBuilder();
        
        // Switch to upcoming trips tab
        this.switchTab('upcoming');
    }

    renderTrips() {
        this.renderUpcomingTrips();
        this.renderPastTrips();
        this.renderItinerary();
    }

    renderUpcomingTrips() {
        const grid = document.getElementById('upcomingTrips');
        if (!grid) return;

        const upcomingTrips = this.trips.filter(trip => trip.status === 'upcoming' || trip.status === 'planned');
        
        grid.innerHTML = upcomingTrips.map(trip => `
            <div class="trip-card">
                <div class="trip-header">
                    <h3>${trip.name}</h3>
                    <div class="trip-dates">
                        <i class="fas fa-calendar"></i>
                        ${trip.startDate} - ${trip.endDate}
                    </div>
                </div>
                <div class="trip-content">
                    <div class="trip-destinations">
                        <span class="destination-tag">${trip.destinations?.[0] || 'Multiple Cities'}</span>
                    </div>
                    <div class="trip-stats">
                        <div class="trip-stat">
                            <span class="stat-value">${trip.accommodations || 3}</span>
                            <span class="stat-label">Stays</span>
                        </div>
                        <div class="trip-stat">
                            <span class="stat-value">${trip.transport || 4}</span>
                            <span class="stat-label">Transport</span>
                        </div>
                        <div class="trip-stat">
                            <span class="stat-value">${trip.events || 8}</span>
                            <span class="stat-label">Activities</span>
                        </div>
                    </div>
                    <div class="trip-actions">
                        <button class="btn btn-primary btn-sm" onclick="tripsPage.viewTrip(${trip.id})">
                            View Details
                        </button>
                        <button class="btn btn-outline btn-sm" onclick="tripsPage.editTrip(${trip.id})">
                            Edit Trip
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    renderPastTrips() {
        const grid = document.getElementById('pastTrips');
        if (!grid) return;

        const pastTrips = this.trips.filter(trip => trip.status === 'past');
        // Similar to renderUpcomingTrips but for past trips
    }

    renderItinerary() {
        const timeline = document.querySelector('.itinerary-timeline');
        if (!timeline) return;

        timeline.innerHTML = `
            <div class="itinerary-day">
                <div class="day-header">
                    <div class="day-title">Day 1: Arrival in Paris</div>
                </div>
                <div class="day-activities">
                    <div class="activity-item">
                        <div class="activity-time">2:00 PM</div>
                        <div class="activity-details">
                            <h4>Check into Hotel</h4>
                            <p>Luxury Resort & Spa Paris</p>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-time">4:00 PM</div>
                        <div class="activity-details">
                            <h4>Eiffel Tower Visit</h4>
                            <p>Skip-the-line tickets included</p>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    openCreateModal() {
        const modal = document.getElementById('createTripModal');
        if (modal) modal.style.display = 'block';
    }

    closeCreateModal() {
        const modal = document.getElementById('createTripModal');
        if (modal) modal.style.display = 'none';
    }

    saveTrip() {
        const form = document.getElementById('tripForm');
        const name = document.getElementById('tripName').value;
        const destination = document.getElementById('tripDestination').value;

        if (!name || !destination) {
            this.showNotification('Please fill in all required fields', 'error');
            return;
        }

        const newTrip = {
            id: Date.now(),
            name,
            destination,
            startDate: document.getElementById('startDate').value,
            endDate: document.getElementById('endDate').value,
            type: document.getElementById('tripType').value,
            budget: document.getElementById('tripBudget').value || 0,
            status: 'planned'
        };

        this.saveTripToStorage(newTrip);
        this.closeCreateModal();
        form.reset();
        this.showNotification('Trip created successfully!', 'success');
        this.renderTrips();
    }

    saveTripToStorage(trip) {
        this.trips.push(trip);
        // In a real app, save to localStorage or send to server
        localStorage.setItem('userTrips', JSON.stringify(this.trips));
    }

    startQuickPlan() {
        // Auto-fill some data and start from step 1
        this.currentStep = 1;
        this.updateBuilderUI();
        
        // Scroll to trip builder section
        document.querySelector('.trip-builder-container').scrollIntoView({
            behavior: 'smooth'
        });
    }

    switchTab(tabName) {
        // Update tab buttons
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => btn.classList.remove('active'));
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');

        // Update tab content
        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => content.classList.remove('active'));
        document.getElementById(tabName).classList.add('active');
    }

    viewTrip(tripId) {
        const trip = this.trips.find(t => t.id === tripId);
        alert(`Viewing trip: ${trip.name}`);
        // In real app, show detailed trip view
    }

    editTrip(tripId) {
        const trip = this.trips.find(t => t.id === tripId);
        alert(`Editing trip: ${trip.name}`);
        // In real app, open trip editor
    }

    resetBuilder() {
        this.currentStep = 1;
        this.tripData = {
            destination: 'paris',
            startDate: '',
            endDate: '',
            style: 'comfort',
            preferences: ['food'],
            budget: 2100
        };
        this.updateBuilderUI();
    }

    showNotification(message, type = 'info') {
        // Create and show notification
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <span>${message}</span>
            <button class="notification-close">&times;</button>
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
            notification.remove();
        }, 5000);

        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.remove();
        });
    }
}

// Initialize trips page
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('my-trips.html')) {
        window.tripsPage = new TripsPage();
    }
});