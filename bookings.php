<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - TravelPlanner</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/bookings.css">
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
                <h1><i class="fas fa-receipt"></i> My Bookings</h1>
                <p>Manage your reservations, tickets, and upcoming trips</p>
            </div>
        </section>

        <section class="section">
            <div class="container">
                <div class="bookings-summary">
                    <div class="summary-card">
                        <i class="fas fa-clock"></i>
                        <div class="summary-content">
                            <h3>Upcoming</h3>
                            <span class="summary-value">3 Trips</span>
                        </div>
                    </div>
                    <div class="summary-card">
                        <i class="fas fa-check-circle"></i>
                        <div class="summary-content">
                            <h3>Completed</h3>
                            <span class="summary-value">12 Trips</span>
                        </div>
                    </div>
                    <div class="summary-card">
                        <i class="fas fa-star"></i>
                        <div class="summary-content">
                            <h3>Reviews</h3>
                            <span class="summary-value">8 Pending</span>
                        </div>
                    </div>
                </div>

                <div class="tabs">
                    <button class="tab-btn active" data-tab="upcoming">Upcoming Bookings</button>
                    <button class="tab-btn" data-tab="past">Past Bookings</button>
                    <button class="tab-btn" data-tab="cancelled">Cancelled</button>
                </div>

                <div class="tab-content active" id="upcoming">
                    <div class="bookings-list">
                        
                    </div>
                </div>

                <div class="tab-content" id="past">
                    <div class="bookings-list">
                        
                    </div>
                </div>
            </div>
        </section>

       
        <section class="section section-dark">
            <div class="container">
                <div class="support-grid">
                    <div class="support-card">
                        <i class="fas fa-question-circle"></i>
                        <h3>Need Help?</h3>
                        <p>Check our FAQ or contact support for assistance with your bookings.</p>
                        <button class="btn btn-outline">Get Help</button>
                    </div>
                    <div class="support-card">
                        <i class="fas fa-file-invoice"></i>
                        <h3>Booking Documents</h3>
                        <p>Download your tickets, invoices, and booking confirmations.</p>
                        <button class="btn btn-outline">View Documents</button>
                    </div>
                    <div class="support-card">
                        <i class="fas fa-star"></i>
                        <h3>Leave Reviews</h3>
                        <p>Share your experience and help other travelers make better choices.</p>
                        <button class="btn btn-outline">Write Review</button>
                    </div>
                </div>
            </div>
        </section>
    </main>


    <div class="modal" id="bookingModal">
        <div class="modal-content large">
            <div class="modal-header">
                <h3>Booking Details</h3>
                <button class="modal-close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="booking-details">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-outline">Download Invoice</button>
                <button class="btn btn-primary">Contact Support</button>
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
    <script src="js/bookings.js"></script>
</body>
</html>