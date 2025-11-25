<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Trips - TravelPlanner</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/trips.css">
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
        <section class="page-hero">
            <div class="container">
                <h1>My Travel Plans</h1>
                <p>Manage your upcoming trips, past adventures, and saved destinations</p>
                <div class="hero-actions">
                    <button class="btn btn-primary btn-lg" id="createTripBtn">
                        <i class="fas fa-plus"></i> Plan New Trip
                    </button>
                    <button class="btn btn-outline btn-lg" id="quickPlanBtn">
                        <i class="fas fa-bolt"></i> Quick Plan
                    </button>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="tabs">
                    <button class="tab-btn active" data-tab="upcoming">Upcoming Trips</button>
                    <button class="tab-btn" data-tab="past">Past Trips</button>
                    <button class="tab-btn" data-tab="saved">Saved Plans</button>
                    <button class="tab-btn" data-tab="itinerary">Trip Itinerary</button>
                </div>

               
                <div class="tab-content active" id="upcoming">
                    <div class="trips-grid" id="upcomingTrips">
                       
                    </div>
                </div>

                
                <div class="tab-content" id="past">
                    <div class="trips-grid" id="pastTrips">
                       
                    </div>
                </div>

                
                <div class="tab-content" id="saved">
                    <div class="saved-items-grid">
                        <div class="saved-card">
                            <div class="saved-content">
                                <h3>Paris Dream Vacation</h3>
                                <p>Saved on Oct 15, 2023</p>
                                <div class="saved-stats">
                                    <span><i class="fas fa-hotel"></i> 3 Hotels</span>
                                    <span><i class="fas fa-plane"></i> 2 Flights</span>
                                    <span><i class="fas fa-ticket-alt"></i> 5 Activities</span>
                                </div>
                            </div>
                            <div class="saved-actions">
                                <button class="btn btn-primary">Continue Planning</button>
                                <button class="btn btn-outline">Delete</button>
                            </div>
                        </div>
                        <div class="saved-card">
                            <div class="saved-content">
                                <h3>Japan Cultural Tour</h3>
                                <p>Saved on Nov 5, 2023</p>
                                <div class="saved-stats">
                                    <span><i class="fas fa-hotel"></i> 4 Ryokans</span>
                                    <span><i class="fas fa-train"></i> 3 Bullet Trains</span>
                                    <span><i class="fas fa-ticket-alt"></i> 8 Cultural Sites</span>
                                </div>
                            </div>
                            <div class="saved-actions">
                                <button class="btn btn-primary">Continue Planning</button>
                                <button class="btn btn-outline">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="tab-content" id="itinerary">
                    <div class="itinerary-container">
                        <div class="itinerary-header">
                            <h3>Europe Adventure - 10 Day Itinerary</h3>
                            <p>June 15-25, 2024 | Paris → Rome → Barcelona</p>
                        </div>
                        <div class="itinerary-timeline" id="itineraryTimeline">
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>

        
        <section class="section section-dark">
            <div class="container">
                <div class="section-header">
                    <h2>Plan Your Perfect Trip</h2>
                    <p>Use our interactive trip builder to create your dream itinerary</p>
                </div>
                
                <div class="trip-builder-container">
                    <div class="builder-steps">
                        <div class="builder-step active" data-step="1">
                            <div class="step-indicator">
                                <div class="step-number">1</div>
                                <div class="step-line"></div>
                            </div>
                            <div class="step-content">
                                <h3>Choose Destination</h3>
                                <p>Where do you want to go?</p>
                                <div class="destination-selection">
                                    <div class="destination-option active" data-destination="paris">
                                        <i class="fas fa-city"></i>
                                        <span>Paris, France</span>
                                    </div>
                                    <div class="destination-option" data-destination="tokyo">
                                        <i class="fas fa-torii-gate"></i>
                                        <span>Tokyo, Japan</span>
                                    </div>
                                    <div class="destination-option" data-destination="bali">
                                        <i class="fas fa-umbrella-beach"></i>
                                        <span>Bali, Indonesia</span>
                                    </div>
                                    <div class="destination-option" data-destination="newyork">
                                        <i class="fas fa-building"></i>
                                        <span>New York, USA</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="builder-step" data-step="2">
                            <div class="step-indicator">
                                <div class="step-number">2</div>
                                <div class="step-line"></div>
                            </div>
                            <div class="step-content">
                                <h3>Select Dates</h3>
                                <p>When are you traveling?</p>
                                <div class="date-selection">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" class="date-input" id="builderStartDate">
                                    </div>
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" class="date-input" id="builderEndDate">
                                    </div>
                                    <div class="duration-display">
                                        <span class="duration-value" id="durationValue">7 days</span>
                                        <span class="duration-label">Trip Duration</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="builder-step" data-step="3">
                            <div class="step-indicator">
                                <div class="step-number">3</div>
                                <div class="step-line"></div>
                            </div>
                            <div class="step-content">
                                <h3>Travel Style</h3>
                                <p>How do you like to travel?</p>
                                <div class="style-selection">
                                    <div class="style-option" data-style="budget">
                                        <i class="fas fa-wallet"></i>
                                        <span>Budget</span>
                                        <small>Save money, more experiences</small>
                                    </div>
                                    <div class="style-option active" data-style="comfort">
                                        <i class="fas fa-star"></i>
                                        <span>Comfort</span>
                                        <small>Balance cost & comfort</small>
                                    </div>
                                    <div class="style-option" data-style="luxury">
                                        <i class="fas fa-crown"></i>
                                        <span>Luxury</span>
                                        <small>Premium experiences</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="builder-step" data-step="4">
                            <div class="step-indicator">
                                <div class="step-number">4</div>
                                <div class="step-line"></div>
                            </div>
                            <div class="step-content">
                                <h3>Trip Preferences</h3>
                                <p>What interests you most?</p>
                                <div class="preferences-selection">
                                    <div class="preference-option" data-preference="culture">
                                        <i class="fas fa-landmark"></i>
                                        <span>Culture & History</span>
                                    </div>
                                    <div class="preference-option active" data-preference="food">
                                        <i class="fas fa-utensils"></i>
                                        <span>Food & Dining</span>
                                    </div>
                                    <div class="preference-option" data-preference="adventure">
                                        <i class="fas fa-hiking"></i>
                                        <span>Adventure</span>
                                    </div>
                                    <div class="preference-option" data-preference="relaxation">
                                        <i class="fas fa-spa"></i>
                                        <span>Relaxation</span>
                                    </div>
                                    <div class="preference-option" data-preference="shopping">
                                        <i class="fas fa-shopping-bag"></i>
                                        <span>Shopping</span>
                                    </div>
                                    <div class="preference-option" data-preference="nature">
                                        <i class="fas fa-tree"></i>
                                        <span>Nature</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="builder-step" data-step="5">
                            <div class="step-indicator">
                                <div class="step-number">5</div>
                            </div>
                            <div class="step-content">
                                <h3>Review & Create</h3>
                                <p>Your perfect trip is ready!</p>
                                <div class="trip-summary">
                                    <div class="summary-item">
                                        <strong>Destination:</strong>
                                        <span id="summary-destination">Paris, France</span>
                                    </div>
                                    <div class="summary-item">
                                        <strong>Duration:</strong>
                                        <span id="summary-duration">7 days</span>
                                    </div>
                                    <div class="summary-item">
                                        <strong>Style:</strong>
                                        <span id="summary-style">Comfort</span>
                                    </div>
                                    <div class="summary-item">
                                        <strong>Interests:</strong>
                                        <span id="summary-interests">Food & Dining</span>
                                    </div>
                                    <div class="summary-item">
                                        <strong>Estimated Budget:</strong>
                                        <span id="summary-budget">$2,100</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="builder-actions">
                        <button class="btn btn-outline" id="prevStepBtn" disabled>
                            <i class="fas fa-arrow-left"></i> Previous
                        </button>
                        <div class="step-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 20%"></div>
                            </div>
                            <span class="progress-text">Step 1 of 5</span>
                        </div>
                        <button class="btn btn-primary" id="nextStepBtn">
                            Next <i class="fas fa-arrow-right"></i>
                        </button>
                        <button class="btn btn-success" id="createTripFinalBtn" style="display: none;">
                            <i class="fas fa-check"></i> Create Trip
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </main>

   
    <div class="modal" id="createTripModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Plan New Trip</h3>
                <button class="modal-close" id="modalCloseBtn">&times;</button>
            </div>
            <div class="modal-body">
                <form id="tripForm">
                    <div class="form-group">
                        <label for="tripName">Trip Name *</label>
                        <input type="text" id="tripName" placeholder="e.g., Summer Europe Adventure" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tripDestination">Destination *</label>
                            <select id="tripDestination" required>
                                <option value="">Select Destination</option>
                                <option value="paris">Paris, France</option>
                                <option value="tokyo">Tokyo, Japan</option>
                                <option value="newyork">New York, USA</option>
                                <option value="bali">Bali, Indonesia</option>
                                <option value="rome">Rome, Italy</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tripType">Trip Type *</label>
                            <select id="tripType" required>
                                <option value="vacation">Vacation</option>
                                <option value="business">Business</option>
                                <option value="honeymoon">Honeymoon</option>
                                <option value="family">Family</option>
                                <option value="adventure">Adventure</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="startDate">Start Date *</label>
                            <input type="date" id="startDate" required>
                        </div>
                        <div class="form-group">
                            <label for="endDate">End Date *</label>
                            <input type="date" id="endDate" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tripBudget">Budget (per person)</label>
                        <div class="budget-input">
                            <span class="currency">$</span>
                            <input type="number" id="tripBudget" placeholder="2000" min="0">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tripDescription">Description (optional)</label>
                        <textarea id="tripDescription" placeholder="Tell us about your trip plans..." rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline" id="cancelTripBtn">Cancel</button>
                <button class="btn btn-primary" id="saveTripBtn">
                    <i class="fas fa-plus"></i> Create Trip
                </button>
            </div>
        </div>
    </div>

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
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 TravelPlanner. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="js/data.js"></script>
    <script src="js/navigation.js"></script>
    <script src="js/trips.js"></script>
</body>
</html>