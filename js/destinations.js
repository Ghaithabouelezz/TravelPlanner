class DestinationsManager {
    constructor() {
        this.currentPage = 1;
        this.currentRegion = '';
        this.currentSort = 'popular';
        this.isLoading = false;
        this.hasMore = true;
        
        this.init();
    }

    init() {
        console.log('DestinationsManager initialized');
        this.bindEvents();
        this.loadDestinations();
    }

    bindEvents() {
        console.log('Binding events...');
        
        // Add null checks for all elements
        const regionFilter = document.getElementById('regionFilter');
        const sortFilter = document.getElementById('sortFilter');
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        const searchInput = document.querySelector('.search-box input');
        const searchButton = document.querySelector('.search-box .btn');

        if (regionFilter) {
            regionFilter.addEventListener('change', (e) => {
                this.currentRegion = e.target.value;
                this.currentPage = 1;
                this.loadDestinations(true);
            });
            console.log('Region filter bound');
        } else {
            console.error('Region filter element not found!');
        }

        if (sortFilter) {
            sortFilter.addEventListener('change', (e) => {
                this.currentSort = e.target.value;
                this.currentPage = 1;
                this.loadDestinations(true);
            });
            console.log('Sort filter bound');
        } else {
            console.error('Sort filter element not found!');
        }

        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => {
                this.currentPage++;
                this.loadDestinations(false);
            });
            console.log('Load more button bound');
        } else {
            console.error('Load more button not found!');
        }

        // Category filter
        const categoryCards = document.querySelectorAll('.category-card');
        if (categoryCards.length > 0) {
            categoryCards.forEach(card => {
                card.addEventListener('click', () => {
                    const category = card.getAttribute('data-category');
                    this.filterByCategory(category);
                });
            });
            console.log('Category cards bound');
        }

        // Search functionality
        if (searchInput && searchButton) {
            searchButton.addEventListener('click', () => {
                this.handleSearch(searchInput.value);
            });
            
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.handleSearch(searchInput.value);
                }
            });
            console.log('Search functionality bound');
        }
    }

    async loadDestinations(clearExisting = false) {
        console.log('loadDestinations called', { 
            page: this.currentPage, 
            region: this.currentRegion, 
            sort: this.currentSort,
            clearExisting: clearExisting
        });
        
        if (this.isLoading) {
            console.log('Already loading, skipping...');
            return;
        }
        
        this.isLoading = true;
        this.toggleLoadingState(true);

        try {
            const params = new URLSearchParams({
                region: this.currentRegion,
                sort: this.currentSort,
                page: this.currentPage
            });

            console.log('Fetching from: actions/get_destinations.php?' + params.toString());
            
            const response = await fetch(`actions/get_destinations.php?${params}`);
            console.log('Response status:', response.status);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();
            console.log('API Response data:', data);

            if (data.success) {
                console.log(`Success! Found ${data.destinations.length} destinations`);
                if (clearExisting) {
                    document.getElementById('allDestinations').innerHTML = '';
                }
                
                this.renderDestinations(data.destinations);
                this.hasMore = data.hasMore;
                this.updateLoadMoreButton();
            } else {
                console.error('API returned error:', data.message);
                this.showError(data.message || 'Failed to load destinations');
            }
        } catch (error) {
            console.error('Error loading destinations:', error);
            this.showError('Failed to load destinations: ' + error.message);
        } finally {
            this.isLoading = false;
            this.toggleLoadingState(false);
        }
    }

    renderDestinations(destinations) {
        const container = document.getElementById('allDestinations');
        console.log(`Rendering ${destinations.length} destinations`);
        
        if (destinations.length === 0 && this.currentPage === 1) {
            container.innerHTML = `
                <div class="no-results" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <i class="fas fa-map-marker-alt" style="font-size: 3rem; color: #666; margin-bottom: 1rem;"></i>
                    <h3 style="color: #2c3e50; margin-bottom: 1rem;">No destinations found</h3>
                    <p style="color: #666;">Try adjusting your filters or search terms</p>
                </div>
            `;
            return;
        }

        destinations.forEach((destination, index) => {
            console.log(`Creating card for: ${destination.name}`);
            const destinationCard = this.createDestinationCard(destination);
            container.appendChild(destinationCard);
        });
    }

 createDestinationCard(destination) {
    const card = document.createElement('div');
    card.className = 'destination-card';
    
    const ratingStars = this.generateStarRating(destination.avg_rating);
    
    card.innerHTML = `
        <div class="destination-image">
            <img src="${destination.image_url}" alt="${destination.name}" 
                 style="width: 100%; height: 100%; object-fit: cover;"
                 onerror="this.src='https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'">
        </div>
        <div class="destination-content">
            <h3>${destination.name}</h3>
            <div class="destination-location">
                <i class="fas fa-map-marker-alt"></i>
                ${destination.country}
            </div>
            <p class="destination-description">${destination.description || 'Explore this amazing destination with beautiful sights and experiences.'}</p>
            
            <div class="destination-features">
                <div class="destination-feature">
                    <div class="feature-value">${destination.avg_rating}</div>
                    <div class="feature-label">Rating</div>
                </div>
                <div class="destination-feature">
                    <div class="feature-value">${destination.review_count}</div>
                    <div class="feature-label">Reviews</div>
                </div>
            </div>
            
            <div class="card-actions" style="display: flex; flex-direction: column; gap: 10px; margin-top: 15px;">
                <button class="btn btn-primary btn-sm" onclick="chooseAccommodation(${destination.destination_id}, '${destination.name}', '${destination.country}')" style="width: 100%;">
                    <i class="fas fa-bed"></i> Choose a Place to Stay
                </button>
                <div style="display: flex; gap: 10px;">
                    <button class="btn btn-outline btn-sm" onclick="viewDestinationDetails(${destination.destination_id})" style="flex: 1;">
                        <i class="fas fa-eye"></i> Details
                    </button>
                    <button class="btn btn-outline btn-sm" onclick="addToWishlist(${destination.destination_id})" style="flex: 1;">
                        <i class="fas fa-heart"></i> Save
                    </button>
                </div>
            </div>
        </div>
    `;
    
    return card;
}

    generateStarRating(rating) {
        const fullStars = Math.floor(rating);
        const hasHalfStar = rating % 1 >= 0.5;
        let stars = '';
        
        for (let i = 1; i <= 5; i++) {
            if (i <= fullStars) {
                stars += '<i class="fas fa-star"></i>';
            } else if (i === fullStars + 1 && hasHalfStar) {
                stars += '<i class="fas fa-star-half-alt"></i>';
            } else {
                stars += '<i class="far fa-star"></i>';
            }
        }
        
        return stars;
    }

    filterByCategory(category) {
        console.log('Filtering by category:', category);
        const categoryMap = {
            'beach': 'oceania',
            'mountain': 'europe',
            'city': 'europe',
            'cultural': 'asia'
        };
        
        this.currentRegion = categoryMap[category] || '';
        this.currentPage = 1;
        this.loadDestinations(true);
        
        const regionFilter = document.getElementById('regionFilter');
        if (regionFilter) {
            regionFilter.value = this.currentRegion;
        }
    }

    handleSearch(searchTerm) {
        console.log('Searching for:', searchTerm);
        if (searchTerm.trim()) {
            alert(`Search functionality for "${searchTerm}" would be implemented here`);
        }
    }

    updateLoadMoreButton() {
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            loadMoreBtn.style.display = this.hasMore ? 'block' : 'none';
            console.log('Load more button updated, hasMore:', this.hasMore);
        }
    }

    toggleLoadingState(loading) {
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loading && this.currentPage === 1) {
            document.getElementById('allDestinations').innerHTML = `
                <div class="loading-spinner" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: #3498db; margin-bottom: 1rem;"></i>
                    <p style="color: #666;">Loading destinations...</p>
                </div>
            `;
        }
        
        if (loadMoreBtn) {
            loadMoreBtn.disabled = loading;
            loadMoreBtn.innerHTML = loading ? 
                '<i class="fas fa-spinner fa-spin"></i> Loading...' : 
                'Load More Destinations';
        }
    }

    showError(message) {
        console.error('Showing error:', message);
        const container = document.getElementById('allDestinations');
        container.innerHTML = `
            <div class="error-message" style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #e74c3c; margin-bottom: 1rem;"></i>
                <h3 style="color: #2c3e50; margin-bottom: 1rem;">Error</h3>
                <p style="color: #666; margin-bottom: 1.5rem;">${message}</p>
                <button class="btn btn-primary" onclick="window.destinationsManager.loadDestinations(true)">
                    Try Again
                </button>
            </div>
        `;
    }
}

// Global functions for button actions
function chooseAccommodation(destinationId, destinationName, destinationCountry) {
    console.log('🎯 Choosing accommodation for:', destinationName, destinationCountry);
    
    // Store destination data
    const destinationData = {
        id: destinationId,
        name: destinationName,
        country: destinationCountry,
        timestamp: new Date().getTime()
    };
    
    sessionStorage.setItem('selectedDestination', JSON.stringify(destinationData));
    console.log('💾 Destination saved to sessionStorage:', destinationData);
    
    // Navigate to accommodations page
    window.location.href = 'accommodations.php';
}

// Helper function to get country from destination name
function getCountryFromDestination(destName) {
    const countryMap = {
        'Hawaii': 'United States',
        'Paris': 'France', 
        'Tokyo': 'Japan',
        'Seoul': 'South Korea',
        'Marrakech': 'Morocco',
        'Queenstown': 'New Zealand',
        'Vancouver': 'Canada',
        'Prague': 'Czech Republic',
        // Add more mappings as needed
    };
    return countryMap[destName] || '';
}
function viewDestinationDetails(destinationId) {
    console.log('View details for destination:', destinationId);
    window.location.href = `destination-details.php?id=${destinationId}`;
}

function addToWishlist(destinationId) {
    console.log('Add to wishlist:', destinationId);
    if (confirm('Add this destination to your wishlist?')) {
        fetch('actions/add_to_wishlist.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ destination_id: destinationId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Destination added to wishlist!');
            } else {
                alert('Please login to add to wishlist');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error adding to wishlist');
        });
    }
}

function addToTrip(destinationId) {
    console.log('Add to trip:', destinationId);
    alert(`Feature coming soon! Destination ${destinationId} would be added to trip.`);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing DestinationsManager...');
    window.destinationsManager = new DestinationsManager();
});
