<?php
session_start();
require "connection.php";


if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
    echo "Debug: Not logged in. Redirecting to login.";
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    echo "Debug: User role is '" . ($_SESSION['user_role'] ?? 'NOT SET') . "'. Required: 'admin'. Redirecting to login.";
    header("Location: login.php");
    exit;
}


try {
    
    $userStats = $pdo->query("SELECT 
        COUNT(*) as total_users,
        COUNT(CASE WHEN role = 'admin' THEN 1 END) as admin_users,
        COUNT(CASE WHEN role = 'user' THEN 1 END) as regular_users,
        DATE(created_at) as date 
        FROM users 
        GROUP BY DATE(created_at) 
        ORDER BY date DESC 
        LIMIT 7")->fetchAll();

   
    $tripStats = $pdo->query("SELECT 
        COUNT(*) as total_trips,
        COUNT(CASE WHEN bundle_id IS NOT NULL THEN 1 END) as bundle_trips,
        COUNT(CASE WHEN bundle_id IS NULL THEN 1 END) as custom_trips
        FROM booking")->fetch();

    
    $destinationStats = $pdo->query("SELECT COUNT(*) as total_destinations FROM destinations")->fetch();
    
    
    $recentActivities = $pdo->query("SELECT 
        u.name as user_name,
        b.booking_date,
        'Trip Booking' as activity_type
        FROM booking b
        JOIN users u ON b.user_id = u.id
        ORDER BY b.booking_date DESC
        LIMIT 5")->fetchAll();

} catch (PDOException $e) {
    $error = "Failed to load statistics: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TravelPlanner</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include "nav_admin.php"; ?>
    
    <div class="admin-container">
        
        <div class="admin-header">
            <h1><i class="fas fa-crown"></i> Admin Dashboard</h1>
            <p>Manage your Travel Planner platform</p>
        </div>

        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon users">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $userStats[0]['total_users'] ?? 0; ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon trips">
                    <i class="fas fa-suitcase"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $tripStats['total_trips'] ?? 0; ?></div>
                    <div class="stat-label">Total Trips</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon destinations">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $destinationStats['total_destinations'] ?? 0; ?></div>
                    <div class="stat-label">Destinations</div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon revenue">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number"><?php echo $tripStats['bundle_trips'] ?? 0; ?></div>
                    <div class="stat-label">Bundle Trips</div>
                </div>
            </div>
        </div>

        
        <div class="admin-content">
            
            <div class="content-column">
               
                <div class="admin-card">
                    <div class="card-header">
                        <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                    </div>
                    <div class="quick-actions-grid">
                        <button class="action-btn" onclick="openModal('userManagement')">
                            <i class="fas fa-user-cog"></i>
                            <span>Manage Users</span>
                        </button>
                        <button class="action-btn" onclick="openModal('destinationManagement')">
                            <i class="fas fa-map-marked-alt"></i>
                            <span>Manage Destinations</span>
                        </button>
                        <button class="action-btn" onclick="openModal('tripManagement')">
                            <i class="fas fa-suitcase"></i>
                            <span>Manage Trips</span>
                        </button>
                        <button class="action-btn" onclick="openModal('bundleManagement')">
                            <i class="fas fa-box"></i>
                            <span>Manage Bundles</span>
                        </button>
                    </div>
                </div>

                
                <div class="admin-card">
                    <div class="card-header">
                        <h3><i class="fas fa-clock"></i> Recent Activities</h3>
                    </div>
                    <div class="activities-list">
                        <?php if (!empty($recentActivities)): ?>
                            <?php foreach ($recentActivities as $activity): ?>
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas fa-suitcase"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-text">
                                            <strong><?php echo htmlspecialchars($activity['user_name']); ?></strong> booked a trip
                                        </div>
                                        <div class="activity-time">
                                            <?php echo date('M j, g:i A', strtotime($activity['booking_date'])); ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-data">No recent activities</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            
            <div class="content-column">
                
                <div class="admin-card">
                    <div class="card-header">
                        <h3><i class="fas fa-users"></i> User Management</h3>
                        <button class="btn btn-sm" onclick="openModal('userManagement')">
                            <i class="fas fa-plus"></i> Add User
                        </button>
                    </div>
                    <div class="user-list">
                        <?php
                        $users = $pdo->query("SELECT id, name, email, username, role, created_at FROM users ORDER BY created_at DESC LIMIT 5")->fetchAll();
                        foreach ($users as $user):
                        ?>
                        <div class="user-item">
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($user['name'], 0, 1)); ?>
                            </div>
                            <div class="user-info">
                                <div class="user-name"><?php echo htmlspecialchars($user['name']); ?></div>
                                <div class="user-email"><?php echo htmlspecialchars($user['email']); ?></div>
                                <div class="user-role <?php echo $user['role']; ?>">
                                    <?php echo ucfirst($user['role']); ?>
                                </div>
                            </div>
                            <div class="user-actions">
                                <button class="btn-icon" onclick="editUser(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn-icon danger" onclick="deleteUser(<?php echo $user['id']; ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

               
                <div class="admin-card">
                    <div class="card-header">
                        <h3><i class="fas fa-server"></i> System Status</h3>
                    </div>
                    <div class="status-list">
                        <div class="status-item online">
                            <i class="fas fa-circle"></i>
                            <span>Database Connection</span>
                            <span class="status-badge">Online</span>
                        </div>
                        <div class="status-item online">
                            <i class="fas fa-circle"></i>
                            <span>User Authentication</span>
                            <span class="status-badge">Online</span>
                        </div>
                        <div class="status-item online">
                            <i class="fas fa-circle"></i>
                            <span>Payment Gateway</span>
                            <span class="status-badge">Online</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
   

    <script src="js/admin.js"></script>
</body>
</html>