<?php 
require_once 'connection.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Destinations - TravelPlanner</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/destinations.css">
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
                <h1>Explore Amazing Destinations</h1>
                <p>Discover beautiful places around the world and start planning your next adventure</p>
                <div class="hero-search">
                    <div class="search-box large">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search destinations, countries, or attractions...">
                        <button class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="filters-section">
                    <div class="filter-group">
                        <label>Filter by Region:</label>
                        <select id="regionFilter">
                            <option value="">All Regions</option>
                            <option value="europe">Europe</option>
                            <option value="asia">Asia</option>
                            <option value="north-america">North America</option>
                            <option value="south-america">South America</option>
                            <option value="africa">Africa</option>
                            <option value="oceania">Oceania</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Sort by:</label>
                        <select id="sortFilter">
                            <option value="popular">Most Popular</option>
                            <option value="rating">Highest Rated</option>
                            <option value="name">Name A-Z</option>
                        </select>
                    </div>
                </div>

                <div class="destinations-grid detailed" id="allDestinations">
                    <!-- All destinations loaded by JavaScript -->
                </div>

                <div class="load-more">
                    <button class="btn btn-outline" id="loadMoreBtn">Load More Destinations</button>
                </div>
            </div>
        </section>

        <!-- Destination Categories -->
        <section class="section section-dark">
            <div class="container">
                <div class="section-header">
                    <h2>Travel by Category</h2>
                    <p>Find destinations that match your travel style</p>
                </div>
                <div class="categories-grid">
                    <div class="category-card" data-category="beach">
                        <i class="fas fa-umbrella-beach"></i>
                        <h3>Beach Getaways</h3>
                        <p>Relax on stunning beaches</p>
                    </div>
                    <div class="category-card" data-category="mountain">
                        <i class="fas fa-mountain"></i>
                        <h3>Mountain Adventures</h3>
                        <p>Explore breathtaking peaks</p>
                    </div>
                    <div class="category-card" data-category="city">
                        <i class="fas fa-city"></i>
                        <h3>City Breaks</h3>
                        <p>Experience urban culture</p>
                    </div>
                    <div class="category-card" data-category="cultural">
                        <i class="fas fa-landmark"></i>
                        <h3>Cultural Trips</h3>
                        <p>Discover history & heritage</p>
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
                    <p>Your trusted partner in creating unforgettable travel experiences around the world.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="destinations.php">Destinations</a></li>
                        <li><a href="accommodations.php">Accommodations</a></li>
                        <li><a href="transport.php">Transport</a></li>
                        <li><a href="events.php">Events</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="help.php">Help Center</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/data.js"></script>
    <script src="js/navigation.js"></script>
    <script src="js/destinations.js"></script>
</body>
</html>