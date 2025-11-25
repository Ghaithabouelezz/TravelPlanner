<?php
session_start();
require "connection.php";


if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    header("Location: login.php");
    exit;
}


$user_id = $_SESSION['user_id'];
try {
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        header("Location: login.php");
        exit;
    }
} catch (PDOException $e) {
    $error = "Failed to load profile data";
}


try {
    $tripsSql = "SELECT COUNT(*) as trip_count FROM normaltrips WHERE user_id = :user_id";
    $tripsStmt = $pdo->prepare($tripsSql);
    $tripsStmt->bindParam(':user_id', $user_id);
    $tripsStmt->execute();
    $tripData = $tripsStmt->fetch(PDO::FETCH_ASSOC);
    $tripCount = $tripData['trip_count'];
} catch (PDOException $e) {
    $tripCount = 0;
}

try {
    $bookingsSql = "SELECT COUNT(*) as booking_count FROM booking WHERE user_id = :user_id";
    $bookingsStmt = $pdo->prepare($bookingsSql);
    $bookingsStmt->bindParam(':user_id', $user_id);
    $bookingsStmt->execute();
    $bookingData = $bookingsStmt->fetch(PDO::FETCH_ASSOC);
    $bookingCount = $bookingData['booking_count'];
} catch (PDOException $e) {
    $bookingCount = 0;
}


try {
    $reviewsSql = "SELECT COUNT(*) as review_count FROM reviews WHERE user_id = :user_id";
    $reviewsStmt = $pdo->prepare($reviewsSql);
    $reviewsStmt->bindParam(':user_id', $user_id);
    $reviewsStmt->execute();
    $reviewData = $reviewsStmt->fetch(PDO::FETCH_ASSOC);
    $reviewCount = $reviewData['review_count'];
} catch (PDOException $e) {
    $reviewCount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Travel Profile - Travel Planner</title>
    <link rel="stylesheet" href="css/profile.css">
       <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animations.css">
   <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body> <?php include "nav.php";?>
    <div class="container">
        <div class="profile-card">
            
            <div class="profile-header">
                <div class="header-background"></div>
                <div class="profile-main">
                    <div class="avatar-container">
                        <div class="avatar">
                            <?php 
                            $initials = strtoupper(substr($user['name'], 0, 1) . substr($user['last_name'], 0, 1));
                            echo $initials;
                            ?>
                        </div>
                        <div class="online-indicator"></div>
                    </div>
                    <div class="profile-info">
                        <h1><?php echo htmlspecialchars($user['name'] . ' ' . $user['last_name']); ?></h1>
                        <p class="user-role"><?php echo ucfirst($user['role']); ?> Traveler</p>
                        <p class="member-since">Exploring the world since <?php echo date('F Y', strtotime($user['created_at'])); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="travel-stats">
                <h2>My Travel Journey</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">🗺️</div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo $tripCount; ?></div>
                            <div class="stat-label">Trips Planned</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📅</div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo $bookingCount; ?></div>
                            <div class="stat-label">Bookings Made</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo $reviewCount; ?></div>
                            <div class="stat-label">Reviews Posted</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">🌍</div>
                        <div class="stat-content">
                            <div class="stat-number"><?php echo $tripCount + 3; ?></div>
                            <div class="stat-label">Destinations</div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="profile-details">
                <h2>Profile Information</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-icon">📧</div>
                        <div class="info-content">
                            <div class="info-label">Email Address</div>
                            <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">📞</div>
                        <div class="info-content">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value">
                                <?php 
                                echo !empty($user['phone']) ? htmlspecialchars($user['phone']) : '<span class="not-provided">Not provided</span>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">🆔</div>
                        <div class="info-content">
                            <div class="info-label">User ID</div>
                            <div class="info-value">#<?php echo htmlspecialchars($user['id']); ?></div>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-icon">👑</div>
                        <div class="info-content">
                            <div class="info-label">Account Type</div>
                            <div class="info-value badge <?php echo $user['role'] === 'admin' ? 'badge-admin' : 'badge-user'; ?>">
                                <?php echo ucfirst($user['role']); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
           
            <div class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="actions-grid">
                    <a href="create_trip.php" class="action-card">
                        <div class="action-icon">➕</div>
                        <div class="action-content">
                            <div class="action-title">Create New Trip</div>
                            <div class="action-desc">Plan your next adventure</div>
                        </div>
                    </a>
                    <a href="my_trips.php" class="action-card">
                        <div class="action-icon">🗺️</div>
                        <div class="action-content">
                            <div class="action-title">My Trips</div>
                            <div class="action-desc">View your travel plans</div>
                        </div>
                    </a>
                    <a href="bundle_trips.php" class="action-card">
                        <div class="action-icon">📦</div>
                        <div class="action-content">
                            <div class="action-title">Bundle Trips</div>
                            <div class="action-desc">Explore ready-made packages</div>
                        </div>
                    </a>
                </div>
            </div>
            
          
            <div class="recent-activity">
                <h2>Recent Activity</h2>
                <div class="activity-list">
                    <?php if($tripCount > 0): ?>
                    <div class="activity-item">
                        <div class="activity-icon">✈️</div>
                        <div class="activity-content">
                            <div class="activity-text">Created a new trip plan</div>
                            <div class="activity-time">Recently</div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="activity-item">
                        <div class="activity-icon">🌴</div>
                        <div class="activity-content">
                            <div class="activity-text">Ready to plan your first trip?</div>
                            <div class="activity-time">Start your journey today!</div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($bookingCount > 0): ?>
                    <div class="activity-item">
                        <div class="activity-icon">✅</div>
                        <div class="activity-content">
                            <div class="activity-text">Completed a booking</div>
                            <div class="activity-time">Recently</div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="activity-item">
                        <div class="activity-icon">💳</div>
                        <div class="activity-content">
                            <div class="activity-text">No bookings yet</div>
                            <div class="activity-time">Book your first trip!</div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="activity-item">
                        <div class="activity-icon">👋</div>
                        <div class="activity-content">
                            <div class="activity-text">Welcome to Travel Planner!</div>
                            <div class="activity-time"><?php echo date('F j, Y', strtotime($user['created_at'])); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
           
            <div class="password-update-section">
                <div class="update-header">
                    <h2>Account Security</h2>
                    <p>Keep your travel adventures secure with a strong password</p>
                </div>
                <a href="password_update.php" class="btn btn-primary">
                    <span class="btn-icon">🔑</span>
                    Update Password
                </a>
            </div>
        </div>
    </div>

    <script src="js/profile.js"></script>
</body>
</html>