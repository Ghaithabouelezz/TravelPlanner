<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport & Flights - TravelPlanner</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/transport.css">
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
                <h1><i class="fas fa-plane-departure"></i> Book Your Journey</h1>
                <p>Find flights, trains, buses, and car rentals for your trip</p>
                
                <div class="transport-search">
                    <div class="search-tabs">
                        <button class="tab-btn active" data-type="flight">
                            <i class="fas fa-plane"></i>
                            <span>Flights</span>
                        </button>
                        <button class="tab-btn" data-type="train">
                            <i class="fas fa-train"></i>
                            <span>Trains</span>
                        </button>
                        <button class="tab-btn" data-type="bus">
                            <i class="fas fa-bus"></i>
                            <span>Buses</span>
                        </button>
                        <button class="tab-btn" data-type="car">
                            <i class="fas fa-car"></i>
                            <span>Car Rental</span>
                        </button>
                    </div>
                    
                    
                    <div class="search-form flight-search-form active" id="flightSearch">
                        <div class="flight-search-header">
                            <div class="trip-type">
                                <button class="trip-type-btn active" data-trip="roundtrip">Round Trip</button>
                                <button class="trip-type-btn" data-trip="oneway">One Way</button>
                                <button class="trip-type-btn" data-trip="multicity">Multi-City</button>
                            </div>
                        </div>

                        <div class="flight-search-body">
                            <div class="route-section">
                                <div class="route-inputs">
                                    <div class="route-field from-field">
                                        <label for="flightFrom">
                                            <i class="fas fa-plane-departure"></i>
                                            From
                                        </label>
                                        <div class="input-with-action">
                                            <input type="text" id="flightFrom" placeholder="City or airport" value="New York (JFK)">
                                            <button class="swap-btn" onclick="transportPage.swapLocations()">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="route-field to-field">
                                        <label for="flightTo">
                                            <i class="fas fa-plane-arrival"></i>
                                            To
                                        </label>
                                        <input type="text" id="flightTo" placeholder="City or airport" value="Paris (CDG)">
                                    </div>
                                </div>
                            </div>

                            <div class="date-section">
                                <div class="date-inputs">
                                    <div class="date-field">
                                        <label for="departureDate">
                                            <i class="fas fa-calendar-alt"></i>
                                            Departure
                                        </label>
                                        <input type="date" id="departureDate" value="2024-06-15">
                                        <div class="date-display">Jun 15, 2024</div>
                                    </div>
                                    
                                    <div class="date-field">
                                        <label for="returnDate">
                                            <i class="fas fa-calendar-alt"></i>
                                            Return
                                        </label>
                                        <input type="date" id="returnDate" value="2024-06-22">
                                        <div class="date-display">Jun 22, 2024</div>
                                    </div>
                                </div>
                            </div>

                            <div class="travelers-section">
                                <div class="travelers-inputs">
                                    <div class="travelers-field">
                                        <label for="travelersClass">
                                            <i class="fas fa-users"></i>
                                            Travelers & Class
                                        </label>
                                        <div class="travelers-selector" onclick="transportPage.openTravelersModal()">
                                            <div class="travelers-summary">
                                                <span class="travelers-count">2 Adults</span>
                                                <span class="travelers-class">• Economy</span>
                                            </div>
                                            <i class="fas fa-chevron-down"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="search-actions">
                                <button class="btn btn-primary btn-lg search-btn" onclick="transportPage.searchFlights()">
                                    <i class="fas fa-search"></i>
                                    Search Flights
                                </button>
                                <button class="btn btn-outline" onclick="transportPage.clearSearch()">
                                    <i class="fas fa-times"></i>
                                    Clear
                                </button>
                            </div>
                        </div>
                    </div>

                   
                    <div class="search-form" id="trainSearch" style="display: none;">
                        
                    </div>
                </div>

                
                <div class="quick-actions">
                    <div class="quick-action-btn" onclick="transportPage.quickSearch('flight')">
                        <i class="fas fa-plane"></i>
                        <span>Find Cheap Flights</span>
                        <small>Best deals to Europe</small>
                    </div>
                    <div class="quick-action-btn" onclick="transportPage.quickSearch('train')">
                        <i class="fas fa-train"></i>
                        <span>Book Train Tickets</span>
                        <small>High-speed rail</small>
                    </div>
                    <div class="quick-action-btn" onclick="transportPage.quickSearch('bus')">
                        <i class="fas fa-bus"></i>
                        <span>Bus Routes</span>
                        <small>Affordable travel</small>
                    </div>
                    <div class="quick-action-btn" onclick="transportPage.quickSearch('car')">
                        <i class="fas fa-car"></i>
                        <span>Rent a Car</span>
                        <small>Flexible mobility</small>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="section-header">
                    <h2>Available Flights</h2>
                    <p>Best options for your travel dates</p>
                </div>

                <div class="filters-bar">
                    <div class="filter-group">
                        <label>Sort by:</label>
                        <select onchange="transportPage.sortFlights(this.value)">
                            <option value="price">Price (Low to High)</option>
                            <option value="duration">Duration</option>
                            <option value="departure">Departure Time</option>
                            <option value="airline">Airline</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Stops:</label>
                        <select onchange="transportPage.filterStops(this.value)">
                            <option value="all">All Stops</option>
                            <option value="nonstop">Non-stop</option>
                            <option value="1stop">1 Stop</option>
                            <option value="2stops">2+ Stops</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Price Range:</label>
                        <select onchange="transportPage.filterPrice(this.value)">
                            <option value="all">Any Price</option>
                            <option value="0-500">Under $500</option>
                            <option value="500-1000">$500 - $1000</option>
                            <option value="1000+">Over $1000</option>
                        </select>
                    </div>
                </div>

                <div class="transport-grid" id="transportGrid">
                    
                </div>
            </div>
        </section>
    </main>

    
    <div class="modal" id="travelersModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Travelers & Class</h3>
                <button class="modal-close" onclick="transportPage.closeTravelersModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div class="travelers-options">
                    <div class="traveler-type">
                        <div class="traveler-label">
                            <span>Adults</span>
                            <small>12+ years</small>
                        </div>
                        <div class="traveler-controls">
                            <button class="count-btn" onclick="transportPage.adjustTravelerCount('adults', -1)">-</button>
                            <span class="traveler-count" id="adultsCount">2</span>
                            <button class="count-btn" onclick="transportPage.adjustTravelerCount('adults', 1)">+</button>
                        </div>
                    </div>
                    <div class="traveler-type">
                        <div class="traveler-label">
                            <span>Children</span>
                            <small>2-11 years</small>
                        </div>
                        <div class="traveler-controls">
                            <button class="count-btn" onclick="transportPage.adjustTravelerCount('children', -1)">-</button>
                            <span class="traveler-count" id="childrenCount">0</span>
                            <button class="count-btn" onclick="transportPage.adjustTravelerCount('children', 1)">+</button>
                        </div>
                    </div>
                    <div class="traveler-type">
                        <div class="traveler-label">
                            <span>Infants</span>
                            <small>Under 2 years</small>
                        </div>
                        <div class="traveler-controls">
                            <button class="count-btn" onclick="transportPage.adjustTravelerCount('infants', -1)">-</button>
                            <span class="traveler-count" id="infantsCount">0</span>
                            <button class="count-btn" onclick="transportPage.adjustTravelerCount('infants', 1)">+</button>
                        </div>
                    </div>
                </div>
                <div class="class-options">
                    <h4>Class</h4>
                    <div class="class-buttons">
                        <button class="class-btn active" data-class="economy">Economy</button>
                        <button class="class-btn" data-class="premium">Premium Economy</button>
                        <button class="class-btn" data-class="business">Business</button>
                        <button class="class-btn" data-class="first">First Class</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="transportPage.applyTravelers()">Apply</button>
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
                    <p>Your trusted partner in creating unforgettable travel experiences.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/data.js"></script>
    <script src="js/navigation.js"></script>
    <script src="js/transport.js"></script>
</body>
</html>