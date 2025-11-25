class AccommodationsManager {
    constructor() {
        this.accommodations = [];
        this.filteredAccommodations = [];
        this.currentFilters = {
            destination: '',
            search: '',
            type: '',
            priceRange: '',
            rating: ''
        };
        this.isLoading = false;
        
        this.init();
    }

    async init() {
        console.log('🏨 AccommodationsManager Initialized');
        
        // Get destination from sessionStorage
        this.loadSelectedDestination();
        
        // Setup event listeners first
        this.setupEventListeners();
        
        // Then load accommodations
        await this.loadAccommodations();
        
        // Render results
        this.renderAccommodations();
    }

    loadSelectedDestination() {
        const selectedDestination = sessionStorage.getItem('selectedDestination');
        if (selectedDestination) {
            try {
                const destination = JSON.parse(selectedDestination);
                this.currentFilters.destination = destination.name;
                console.log('🎯 Loaded destination:', this.currentFilters.destination);
                
                // Update search input
                const searchInput = document.getElementById('destinationSearch');
                if (searchInput) {
                    searchInput.value = `${destination.name}, ${destination.country}`;
                }
                
                // Show destination info
                this.showDestinationInfo(destination.name, destination.country);
            } catch (e) {
                console.error('Error parsing destination:', e);
            }
        }
    }

    showDestinationInfo(destinationName, country) {
        const infoDiv = document.getElementById('selectedDestinationInfo');
        if (infoDiv) {
            infoDiv.innerHTML = `
                <div style="background: rgba(52, 152, 219, 0.1); padding: 12px 16px; border-radius: 8px; border-left: 4px solid #3498db; margin-top: 15px;">
                    <div style="display: flex; justify-content: between; align-items: center;">
                        <div>
                            <strong style="color: #2c3e50;">📍 Searching accommodations in:</strong>
                            <span style="color: #34495e; margin-left: 8px;">${destinationName}, ${country}</span>
                        </div>
                        <button onclick="accommodationsManager.clearDestination()" 
                                style="background: none; border: none; color: #7f8c8d; cursor: pointer; padding: 4px 8px; border-radius: 4px;">
                            <i class="fas fa-times"></i> Clear
                        </button>
                    </div>
                </div>
            `;
            infoDiv.style.display = 'block';
        }
    }

    setupEventListeners() {
        // Search button
        const searchBtn = document.querySelector('.search-box .btn');
        if (searchBtn) {
            searchBtn.addEventListener('click', () => this.handleSearch());
        }

        // Search input enter key
        const searchInput = document.getElementById('destinationSearch');
        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.handleSearch();
            });
        }

        // Filter changes
        const filters = ['typeFilter', 'priceFilter', 'ratingFilter'];
        filters.forEach(filterId => {
            const element = document.getElementById(filterId);
            if (element) {
                element.addEventListener('change', () => this.applyFilters());
            }
        });
    }

    handleSearch() {
        const searchInput = document.getElementById('destinationSearch');
        if (searchInput) {
            this.currentFilters.search = searchInput.value.trim();
            this.currentFilters.destination = ''; // Clear destination when manual search
            this.loadAccommodations();
        }
    }

    async loadAccommodations() {
        if (this.isLoading) return;
        
        this.isLoading = true;
        this.showLoadingState();

        try {
            const params = new URLSearchParams();
            
            if (this.currentFilters.destination) {
                params.append('destination', this.currentFilters.destination);
            }
            if (this.currentFilters.search) {
                params.append('search', this.currentFilters.search);
            }
            if (this.currentFilters.type) {
                params.append('type', this.currentFilters.type);
            }
            if (this.currentFilters.priceRange) {
                params.append('price_range', this.currentFilters.priceRange);
            }
            if (this.currentFilters.rating) {
                params.append('rating', this.currentFilters.rating);
            }

            console.log('🔍 Fetching accommodations with params:', params.toString());

            const response = await fetch(`actions/get_accommodations.php?${params}`);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('📊 API Response:', data);

            if (data.success) {
                this.accommodations = data.accommodations;
                this.filteredAccommodations = [...this.accommodations];
                console.log(`✅ Loaded ${this.accommodations.length} accommodations`);
            } else {
                throw new Error(data.message || 'Failed to load accommodations');
            }
        } catch (error) {
            console.error('💥 Error loading accommodations:', error);
            this.showError('Failed to load accommodations: ' + error.message);
            this.showFallbackData();
        } finally {
            this.isLoading = false;
        }
    }

    applyFilters() {
        // Update current filters from UI
        this.currentFilters.type = document.getElementById('typeFilter')?.value || '';
        this.currentFilters.priceRange = document.getElementById('priceFilter')?.value || '';
        this.currentFilters.rating = document.getElementById('ratingFilter')?.value || '';

        this.loadAccommodations();
    }

    showLoadingState() {
        const grid = document.getElementById('accommodationsGrid');
        if (!grid) return;

        grid.innerHTML = `
            <div class="loading-spinner" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #3498db; margin-bottom: 1rem;"></i>
                <p style="color: #666;">Searching for accommodations...</p>
                ${this.currentFilters.destination ? 
                    `<p style="color: #666; font-size: 0.9rem;">in ${this.currentFilters.destination}</p>` : ''}
            </div>
        `;
    }

    renderAccommodations() {
        const grid = document.getElementById('accommodationsGrid');
        if (!grid) return;

        if (this.filteredAccommodations.length === 0) {
            grid.innerHTML = `
                <div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <i class="fas fa-bed" style="font-size: 3rem; color: #bdc3c7; margin-bottom: 1rem;"></i>
                    <h3 style="color: #2c3e50; margin-bottom: 1rem;">No accommodations found</h3>
                    <p style="color: #7f8c8d; margin-bottom: 1.5rem;">
                        ${this.currentFilters.destination ? 
                            `No accommodations found for "${this.currentFilters.destination}". Try a different destination or search term.` : 
                            'Try adjusting your search criteria or filters.'}
                    </p>
                    <button class="btn btn-primary" onclick="accommodationsManager.clearFilters()">
                        <i class="fas fa-redo"></i> Clear Filters
                    </button>
                </div>
            `;
            return;
        }

        grid.innerHTML = this.filteredAccommodations.map(acc => this.createAccommodationCard(acc)).join('');
    }

    createAccommodationCard(accommodation) {
        const ratingStars = this.generateStarRating(accommodation.rating);
        const fallbackIcon = this.getAccommodationIcon(accommodation.type);

        return `
            <div class="accommodation-card" data-id="${accommodation.accommodation_id}">
                <div class="accommodation-image">
                    <img src="${accommodation.image_url}" alt="${accommodation.name}" 
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="accommodation-image-fallback" style="display: none; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 2rem; width: 100%; height: 100%;">
                        <i class="fas fa-${fallbackIcon}"></i>
                    </div>
                    <div class="accommodation-type">${accommodation.type.charAt(0).toUpperCase() + accommodation.type.slice(1)}</div>
                    <div class="accommodation-rating-badge">${accommodation.rating}/10</div>
                </div>
                <div class="accommodation-content">
                    <h3>${accommodation.name}</h3>
                    <div class="accommodation-location">
                        <i class="fas fa-map-marker-alt"></i>
                        ${accommodation.country || 'Location not specified'}
                    </div>
                    <div class="accommodation-rating">
                        <div class="rating-stars">${ratingStars}</div>
                        <span>${accommodation.rating}/10</span>
                    </div>
                    
                    <div class="accommodation-features">
                        <span class="feature"><i class="fas fa-wifi"></i> WiFi</span>
                        <span class="feature"><i class="fas fa-parking"></i> Parking</span>
                        <span class="feature"><i class="fas fa-utensils"></i> Restaurant</span>
                    </div>
                    
                    <div class="accommodation-price">
                        $${parseFloat(accommodation.price_per_night).toFixed(2)}/night
                    </div>
                    
                    <div class="accommodation-actions">
                        <button class="btn btn-primary" onclick="accommodationsManager.bookAccommodation(${accommodation.accommodation_id}, '${this.escapeString(accommodation.name)}', '${this.escapeString(accommodation.booking_url)}')">
                            <i class="fas fa-external-link-alt"></i> Book Now
                        </button>
                        <button class="btn btn-outline" onclick="accommodationsManager.viewDetails(${accommodation.accommodation_id})">
                            <i class="fas fa-info-circle"></i> Details
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    generateStarRating(rating) {
        const starRating = Math.min(rating / 2, 5); // Convert 10-point to 5-star
        let stars = '';
        
        for (let i = 1; i <= 5; i++) {
            if (i <= Math.floor(starRating)) {
                stars += '<i class="fas fa-star"></i>';
            } else if (i === Math.ceil(starRating) && starRating % 1 >= 0.3) {
                stars += '<i class="fas fa-star-half-alt"></i>';
            } else {
                stars += '<i class="far fa-star"></i>';
            }
        }
        
        return stars;
    }

    getAccommodationIcon(type) {
        const icons = {
            'hotel': 'hotel',
            'resort': 'umbrella-beach',
            'apartment': 'building',
            'villa': 'home',
            'hostel': 'users'
        };
        return icons[type] || 'bed';
    }

    escapeString(str) {
        if (!str) return '';
        return str.replace(/'/g, "\\'").replace(/"/g, '\\"');
    }

    bookAccommodation(id, name, bookingUrl) {
        console.log('Booking:', { id, name, bookingUrl });
        
        if (!bookingUrl || bookingUrl === 'null') {
            this.showNotification(`No booking link available for ${name}. Please visit the hotel website directly.`, 'warning');
            return;
        }

        // Open booking URL in new tab
        window.open(bookingUrl, '_blank', 'noopener,noreferrer');
        this.showNotification(`Opening booking page for ${name}`, 'success');
    }

    viewDetails(id) {
        const accommodation = this.accommodations.find(acc => acc.accommodation_id === id);
        if (accommodation) {
            alert(`Details for ${accommodation.name}\n\nLocation: ${accommodation.country}\nType: ${accommodation.type}\nRating: ${accommodation.rating}/10\nPrice: $${accommodation.price_per_night}/night`);
        }
    }

    clearDestination() {
        sessionStorage.removeItem('selectedDestination');
        this.currentFilters.destination = '';
        this.currentFilters.search = '';
        
        const searchInput = document.getElementById('destinationSearch');
        if (searchInput) searchInput.value = '';
        
        const infoDiv = document.getElementById('selectedDestinationInfo');
        if (infoDiv) infoDiv.style.display = 'none';
        
        this.loadAccommodations();
    }

    clearFilters() {
        // Reset all filters
        this.currentFilters = {
            destination: '',
            search: '',
            type: '',
            priceRange: '',
            rating: ''
        };
        
        // Reset UI elements
        const filters = ['typeFilter', 'priceFilter', 'ratingFilter'];
        filters.forEach(filterId => {
            const element = document.getElementById(filterId);
            if (element) element.value = '';
        });
        
        const searchInput = document.getElementById('destinationSearch');
        if (searchInput) searchInput.value = '';
        
        this.loadAccommodations();
    }

    showError(message) {
        const grid = document.getElementById('accommodationsGrid');
        if (!grid) return;

        grid.innerHTML = `
            <div class="error-message" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #e74c3c; margin-bottom: 1rem;"></i>
                <h3 style="color: #2c3e50; margin-bottom: 1rem;">Error Loading Accommodations</h3>
                <p style="color: #666; margin-bottom: 1.5rem;">${message}</p>
                <button class="btn btn-primary" onclick="accommodationsManager.loadAccommodations()">
                    <i class="fas fa-redo"></i> Try Again
                </button>
            </div>
        `;
    }

    showFallbackData() {
        console.log('Showing fallback data');
        this.accommodations = [
            {
                accommodation_id: 1,
                name: 'Sample Hotel',
                type: 'hotel',
                price_per_night: '150.00',
                rating: 8,
                image_url: 'https://images.unsplash.com/photo-1566073771259-6a8506099945?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                booking_url: 'https://www.booking.com',
                country: 'Various Locations'
            }
        ];
        this.filteredAccommodations = [...this.accommodations];
        this.renderAccommodations();
    }

    showNotification(message, type = 'info') {
        // Simple notification implementation
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#27ae60' : type === 'warning' ? '#f39c12' : '#3498db'};
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            z-index: 10000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        notification.textContent = message;
        document.body.appendChild(notification);
        
        setTimeout(() => notification.remove(), 3000);
    }
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', () => {
    window.accommodationsManager = new AccommodationsManager();
});