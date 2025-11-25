class EventsPage {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.renderEvents();
    }

    setupEventListeners() {
        // Filter functionality
        const filters = ['eventTypeFilter', 'dateFilter', 'eventPriceFilter'];
        filters.forEach(filterId => {
            const filter = document.getElementById(filterId);
            if (filter) filter.addEventListener('change', () => this.filterEvents());
        });
    }

    renderEvents() {
        const grid = document.getElementById('eventsGrid');
        if (!grid) return;

        const events = [
            {
                id: 1,
                name: 'Louvre Museum Tour',
                type: 'tour',
                location: 'Paris, France',
                date: '2024-06-16',
                price: 35,
                description: 'Guided tour of the world\'s largest art museum'
            },
            {
                id: 2,
                name: 'Jazz Night Concert',
                type: 'concert',
                location: 'Paris, France',
                date: '2024-06-17',
                price: 45,
                description: 'Live jazz performance in historic venue'
            }
        ];

        grid.innerHTML = events.map(event => `
            <div class="event-card">
                <div class="event-image">
                    <i class="fas fa-${this.getEventIcon(event.type)}"></i>
                </div>
                <div class="event-content">
                    <div class="event-date">${new Date(event.date).toLocaleDateString()}</div>
                    <h3>${event.name}</h3>
                    <p class="event-location">
                        <i class="fas fa-map-marker-alt"></i> ${event.location}
                    </p>
                    <p class="event-description">${event.description}</p>
                    <div class="event-info">
                        <span><i class="fas fa-tag"></i> ${event.type.charAt(0).toUpperCase() + event.type.slice(1)}</span>
                    </div>
                    <div class="event-price">$${event.price}</div>
                    <div class="btn-group">
                        <button class="btn btn-primary" onclick="eventsPage.viewEvent(${event.id})">
                            View Details
                        </button>
                        <button class="btn btn-outline" onclick="eventsPage.bookEvent(${event.id})">
                            Book Tickets
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    getEventIcon(type) {
        const icons = {
            concert: 'music',
            tour: 'map-marked-alt',
            festival: 'glass-cheers',
            sports: 'running',
            cultural: 'landmark'
        };
        return icons[type] || 'calendar-alt';
    }

    viewEvent(eventId) {
        alert(`Viewing event details for ID: ${eventId}`);
    }

    bookEvent(eventId) {
        alert(`Booking event ID: ${eventId}`);
    }

    filterEvents() {
        // Filter logic here
        this.renderEvents();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('events.html')) {
        window.eventsPage = new EventsPage();
    }
});