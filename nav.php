<nav class="navbar">
    <div class="nav-container">
        <div class="nav-logo">
            <i class="fas fa-compass"></i>
            <span>TravelPlanner</span>
        </div>
        <ul class="nav-menu">
            <li class="nav-item "><a href="home.php" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="destinations.php" class="nav-link">Destinations</a></li>
            <li class="nav-item"><a href="accommodations.php" class="nav-link">Stays</a></li>
            <li class="nav-item"><a href="transport.php" class="nav-link">Transport</a></li>
            <li class="nav-item"><a href="events.php" class="nav-link">Events</a></li>
            <li class="nav-item"><a href="my-trips.php" class="nav-link">My Trips</a></li>
        </ul>
        <div class="nav-auth">
            <?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true): ?>
                
                <div class="user-dropdown">
                    <button class="user-menu-btn">
                        <div class="user-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="username">
                            <?php echo htmlspecialchars($_SESSION['user_username'] ?? 'User'); ?>
                        </span>
                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                    </button>
                    <div class="dropdown-menu">
                        <div class="dropdown-header">
                            <div class="username"><?php echo htmlspecialchars($_SESSION['user_username'] ?? 'User'); ?></div>
                            <div class="user-email"><?php echo htmlspecialchars($_SESSION['user_email'] ?? ''); ?></div>
                        </div>
                        <a href="profile.php" class="dropdown-item">
                            <i class="fas fa-user"></i>
                            My Profile
                        </a>
                        <a href="my-trips.html" class="dropdown-item">
                            <i class="fas fa-suitcase"></i>
                            My Trips
                        </a>
                        <a href="settings.php" class="dropdown-item">
                            <i class="fas fa-cog"></i>
                            Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="actions/logout.php" class="dropdown-item logout">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </div>
                </div>

                <script>
        
                document.addEventListener('DOMContentLoaded', function() {
                    const userDropdown = document.querySelector('.user-dropdown');
                    const userBtn = document.querySelector('.user-menu-btn');
                    const dropdownMenu = document.querySelector('.dropdown-menu');
                    
                    
                    userBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        const isVisible = dropdownMenu.style.display === 'block';
                        dropdownMenu.style.display = isVisible ? 'none' : 'block';
                    });
                    
                    document.addEventListener('click', function(e) {
                        if (!userDropdown.contains(e.target)) {
                            dropdownMenu.style.display = 'none';
                        }
                    });
                    
                   
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            dropdownMenu.style.display = 'none';
                        }
                    });
                });
                </script>
            <?php else: ?>
                <a href="login.php" class="btn btn-outline">Sign In</a>
                <a href="register.php" class="btn btn-primary">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</nav>