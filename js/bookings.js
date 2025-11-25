class BookingsPage {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.renderBookings();
    }

    setupEventListeners() {
        // Tab switching
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => {
            btn.addEventListener('click', (e) => this.switchTab(e.target.dataset.tab));
        });
    }

    renderBookings() {
        const upcomingList = document.querySelector('#upcoming .bookings-list');
        const pastList = document.querySelector('#past .bookings-list');

        const bookings = [
            {
                id: 1,
                type: 'Hotel',
                name: 'Luxury Resort Paris',
                date: '2024-06-15 to 2024-06-20',
                price: 1200,
                status: 'confirmed'
            },
            {
                id: 2,
                type: 'Flight',
                name: 'New York to Paris',
                date: '2024-06-15',
                price: 450,
                status: 'confirmed'
            }
        ];

        if (upcomingList) {
            upcomingList.innerHTML = bookings.map(booking => `
                <div class="booking-item">
                    <div class="booking-info">
                        <h4>${booking.name}</h4>
                        <div class="booking-meta">
                            <span>${booking.type}</span>
                            <span>${booking.date}</span>
                            <span>$${booking.price}</span>
                        </div>
                    </div>
                    <div class="booking-actions">
                        <span class="booking-status status-${booking.status}">
                            ${booking.status.charAt(0).toUpperCase() + booking.status.slice(1)}
                        </span>
                        <button class="btn btn-outline btn-sm" onclick="bookingsPage.viewBooking(${booking.id})">
                            View Details
                        </button>
                    </div>
                </div>
            `).join('');
        }
    }

    switchTab(tabName) {
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => btn.classList.remove('active'));
        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');

        const tabContents = document.querySelectorAll('.tab-content');
        tabContents.forEach(content => content.classList.remove('active'));
        document.getElementById(tabName).classList.add('active');
    }

    viewBooking(bookingId) {
        alert(`Viewing booking details for ID: ${bookingId}`);
        // In real app, open booking details modal
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('bookings.html')) {
        window.bookingsPage = new BookingsPage();
    }
});