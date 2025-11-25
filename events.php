<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events & Activities - TravelPlanner</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/events.css">

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
                <h1><i class="fas fa-calendar-alt"></i> Discover Amazing Events</h1>
                <p>Book concerts, festivals, tours, and unique experiences for your trip</p>
                <div class="hero-search">
                    <div class="search-box large">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search events, concerts, or activities...">
                        <button class="btn btn-primary">Find Events</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="filters-section">
                    <div class="filter-group">
                        <label>Event Type:</label>
                        <select id="eventTypeFilter">
                            <option value="">All Events</option>
                            <option value="concert">Concerts</option>
                            <option value="festival">Festivals</option>
                            <option value="tour">Tours</option>
                            <option value="sports">Sports</option>
                            <option value="cultural">Cultural</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Date Range:</label>
                        <select id="dateFilter">
                            <option value="">Any Date</option>
                            <option value="today">Today</option>
                            <option value="weekend">This Weekend</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Price Range:</label>
                        <select id="eventPriceFilter">
                            <option value="">Any Price</option>
                            <option value="free">Free Events</option>
                            <option value="0-50">Under $50</option>
                            <option value="50-100">$50 - $100</option>
                            <option value="100+">$100+</option>
                        </select>
                    </div>
                </div>

                <div class="events-grid" id="eventsGrid">
                   
                </div>
            </div>
        </section>

        
        <section class="section section-dark">
            <div class="container">
                <div class="section-header">
                    <h2>Featured Events This Month</h2>
                    <p>Don't miss these popular upcoming experiences</p>
                </div>
                <div class="featured-events">
                    <div class="featured-event-card">
                        <div class="event-date">
                            <span class="month">NOV</span>
                            <span class="day">25</span>
                        </div>
                        <div class="event-content">
                            <h3>Paris Jazz Festival</h3>
                            <p>Experience the best of jazz in the heart of Paris</p>
                            <div class="event-info">
                                <span><i class="fas fa-map-marker-alt"></i> Paris, France</span>
                                <span><i class="fas fa-clock"></i> 7:00 PM</span>
                            </div>
                            <div class="event-price">From $45</div>
                            <button class="btn btn-primary">Book Tickets</button>
                        </div>
                    </div>
                    <div class="featured-event-card">
                        <div class="event-date">
                            <span class="month">DEC</span>
                            <span class="day">15</span>
                        </div>
                        <div class="event-content">
                            <h3>Tokyo Food Tour</h3>
                            <p>Guided culinary adventure through Tokyo's best eateries</p>
                            <div class="event-info">
                                <span><i class="fas fa-map-marker-alt"></i> Tokyo, Japan</span>
                                <span><i class="fas fa-clock"></i> 6:30 PM</span>
                            </div>
                            <div class="event-price">$85</div>
                            <button class="btn btn-primary">Book Tour</button>
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
    <script src="js/events.js"></script>
</body>
</html>