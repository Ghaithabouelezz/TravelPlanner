<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelPlanner - Your Perfect Journey Awaits</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/nav.css">

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
        
        <section class="hero">
            <div class="hero-content">
                <h1 class="hero-title">Plan Your Perfect Adventure</h1>
                <p class="hero-subtitle">Discover amazing destinations, book accommodations, and create unforgettable memories with our all-in-one travel planner</p>
                <div class="hero-search">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Where do you want to go?">
                        <button class="btn btn-primary">Explore</button>
                    </div>
                </div>
            </div>
            <div class="hero-background">
                <div class="floating-elements">
                    <div class="floating-card" style="--delay: 0s">
                        <i class="fas fa-hotel"></i>
                        <span>500+ Hotels</span>
                    </div>
                    <div class="floating-card" style="--delay: 1s">
                        <i class="fas fa-plane"></i>
                        <span>100+ Routes</span>
                    </div>
                    <div class="floating-card" style="--delay: 2s">
                        <i class="fas fa-ticket-alt"></i>
                        <span>50+ Events</span>
                    </div>
                </div>
            </div>
        </section>

        
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2>Popular Destinations</h2>
                    <p>Explore our most loved travel spots around the world</p>
                    <a href="destinations.html" class="btn btn-outline">View All Destinations</a>
                </div>
                <div class="destinations-grid" id="featuredDestinations">
                   
                </div>
            </div>
        </section>

     
        <section class="section section-dark">
            <div class="container">
                <div class="section-header">
                    <h2>How TravelPlanner Works</h2>
                    <p>Plan your perfect trip in just a few simple steps</p>
                </div>
                <div class="steps-grid">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <i class="fas fa-map-marked-alt"></i>
                        <h3>Choose Destination</h3>
                        <p>Browse through hundreds of amazing destinations worldwide</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <i class="fas fa-hotel"></i>
                        <h3>Book Accommodation</h3>
                        <p>Select from hotels, apartments, villas, or hostels</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <i class="fas fa-bus"></i>
                        <h3>Arrange Transport</h3>
                        <p>Book flights, trains, buses, or car rentals</p>
                    </div>
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <i class="fas fa-calendar-alt"></i>
                        <h3>Add Activities</h3>
                        <p>Include events and attractions to your itinerary</p>
                    </div>
                </div>
            </div>
        </section>

       
        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2>Special Offers & Bundles</h2>
                    <p>Save more with our curated travel packages</p>
                </div>
                <div class="bundles-grid" id="featuredBundles">
                   
                </div>
            </div>
        </section>

       
        <section class="section section-dark">
            <div class="container">
                <div class="section-header">
                    <h2>What Travelers Say</h2>
                    <p>Read experiences from our happy customers</p>
                </div>
                <div class="testimonials-grid">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"TravelPlanner made our honeymoon absolutely perfect! Everything was well organized."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150" alt="Sarah">
                            <div>
                                <h4>Sarah Johnson</h4>
                                <span>Paris, France Trip</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"The bundle deals saved us over 30% on our family vacation. Highly recommended!"</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150" alt="Mike">
                            <div>
                                <h4>Mike Chen</h4>
                                <span>Tokyo, Japan Trip</span>
                            </div>
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
                    <p>Your trusted partner in creating unforgettable travel experiences around the world.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="destinations.html">Destinations</a></li>
                        <li><a href="accommodations.html">Accommodations</a></li>
                        <li><a href="transport.html">Transport</a></li>
                        <li><a href="events.html">Events</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Support</h4>
                    <ul>
                        <li><a href="help.html">Help Center</a></li>
                        <li><a href="contact.html">Contact Us</a></li>
                        <li><a href="faq.html">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Newsletter</h4>
                    <p>Subscribe for travel tips and exclusive deals</p>
                    <div class="newsletter-form">
                        <input type="email" placeholder="Enter your email">
                        <button class="btn btn-primary">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 TravelPlanner. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/data.js"></script>
    <script src="js/navigation.js"></script>
    <script src="js/main.js"></script>
    
</body>
</html>