
<?php session_start();
require_once 'connection.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stays & Accommodations - TravelPlanner</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/accommodations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
   <?php 
if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
    include "nav_admin.php";
} else {
    include "nav.php";
}
?>

    <main class="main-content">
        <section class="page-hero">
            <div class="container">
                <h1><i class="fas fa-hotel"></i> Find Your Perfect Stay</h1>
                <p>Discover hotels, apartments, villas, and hostels for your next adventure</p>
                <div class="hero-search">
                    <div class="search-box large">
                        <i class="fas fa-search"></i>
                        <input type="text" id="destinationSearch" placeholder="Search by destination, hotel name, or type...">
                        <button class="btn btn-primary" onclick="searchAccommodations()">Search Stays</button>
                    </div>
                </div>
                <div id="selectedDestinationInfo" style="margin-top: 15px; display: none;">
                    <!-- Will be populated by JavaScript -->
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="filters-section">
                    <div class="filter-group">
                        <label>Accommodation Type:</label>
                        <select id="typeFilter">
                            <option value="">All Types</option>
                            <option value="hotel">Hotels</option>
                            <option value="apartment">Apartments</option>
                            <option value="villa">Villas</option>
                            <option value="hostel">Hostels</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Price Range:</label>
                        <select id="priceFilter">
                            <option value="">Any Price</option>
                            <option value="0-100">$0 - $100</option>
                            <option value="100-200">$100 - $200</option>
                            <option value="200-500">$200 - $500</option>
                            <option value="500+">$500+</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Rating:</label>
                        <select id="ratingFilter">
                            <option value="">Any Rating</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4+ Stars</option>
                            <option value="3">3+ Stars</option>
                        </select>
                    </div>
                </div>

                <div class="accommodations-grid" id="accommodationsGrid">
                    <!-- Accommodations loaded by JavaScript -->
                </div>
            </div>
        </section>

        <!-- Special Deals -->
        <section class="section section-dark">
            <div class="container">
                <div class="section-header">
                    <h2>Special Accommodation Deals</h2>
                    <p>Limited time offers on premium stays</p>
                </div>
                <div class="deals-grid">
                    <div class="deal-card">
                        <div class="deal-badge">25% OFF</div>
                        <div class="deal-content">
                            <h3>Luxury Resort Package</h3>
                            <p>5-star beach resort with all-inclusive amenities</p>
                            <div class="deal-price">
                                <span class="original-price">$400</span>
                                <span class="sale-price">$300/night</span>
                            </div>
                            <button class="btn btn-primary">View Deal</button>
                        </div>
                    </div>
                    <div class="deal-card">
                        <div class="deal-badge">FREE NIGHT</div>
                        <div class="deal-content">
                            <h3>City Apartment Special</h3>
                            <p>Book 3 nights, get 1 night free in central locations</p>
                            <div class="deal-price">
                                <span class="sale-price">From $120/night</span>
                            </div>
                            <button class="btn btn-primary">View Deal</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <i class="fas fa-compass"></i>
                        <span>TravelPlanner</span>
                    </div>
                    <p>Your trusted partner in creating unforgettable travel experiences.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/data.js"></script>
    <script src="js/navigation.js"></script>
    <script src="js/accommodations.js"></script>
    <script>
        // Handle the selected destination when page loads
       // Handle the selected destination when page loads
document.addEventListener('DOMContentLoaded', function() {
    const selectedDestination = sessionStorage.getItem('selectedDestination');
    
    if (selectedDestination) {
        const destination = JSON.parse(selectedDestination);
        const searchInput = document.getElementById('destinationSearch');
        const infoDiv = document.getElementById('selectedDestinationInfo');
        
        // Pre-fill search with destination name
        if (searchInput) {
            searchInput.value = `${destination.name}, ${destination.country}`;
        }
        
        // Show destination info
        if (infoDiv) {
            infoDiv.style.display = 'block';
            infoDiv.innerHTML = `
                <div style="background: rgba(52, 152, 219, 0.1); padding: 10px 15px; border-radius: 8px; border-left: 4px solid #3498db;">
                    <strong>Searching accommodations in:</strong> ${destination.name}, ${destination.country}
                    <button onclick="clearDestination()" style="margin-left: 10px; background: none; border: none; color: #666; cursor: pointer;">
                        <i class="fas fa-times"></i> Clear
                    </button>
                </div>
            `;
        }
        
        // Trigger search automatically
        setTimeout(() => {
            if (window.accommodationsPage && typeof window.accommodationsPage.searchAccommodations === 'function') {
                window.accommodationsPage.searchAccommodations(destination.country);
            }
        }, 500);
    }
});

        function clearDestination() {
            sessionStorage.removeItem('selectedDestination');
            document.getElementById('destinationSearch').value = '';
            document.getElementById('selectedDestinationInfo').style.display = 'none';
            
            // Reload accommodations without destination filter
            if (window.accommodationsPage && typeof window.accommodationsPage.loadAccommodations === 'function') {
                window.accommodationsPage.loadAccommodations();
            }
        }

        function searchAccommodations() {
            const searchTerm = document.getElementById('destinationSearch').value;
            if (window.accommodationsPage && typeof window.accommodationsPage.searchAccommodations === 'function') {
                window.accommodationsPage.searchAccommodations(searchTerm);
            }
        }
    </script>
</body>
</html>