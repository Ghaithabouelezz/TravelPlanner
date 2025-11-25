// Navigation functionality
class Navigation {
    constructor() {
        this.init();
    }

    init() {
        this.setActiveNavItem();
        this.addCardClickHandlers();
        this.addModalHandlers();
    }

    setActiveNavItem() {
        const currentPage = window.location.pathname.split('/').pop() || 'index.html';
        const navItems = document.querySelectorAll('.nav-item');
        
        navItems.forEach(item => {
            const link = item.querySelector('.nav-link');
            const href = link.getAttribute('href');
            if (href === currentPage) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }

    addCardClickHandlers() {
        const cards = document.querySelectorAll('.card[data-page]');
        cards.forEach(card => {
            card.addEventListener('click', (e) => {
                if (!e.target.closest('.btn')) {
                    const page = card.getAttribute('data-page');
                    if (page) {
                        window.location.href = page;
                    }
                }
            });
        });
    }

    addModalHandlers() {
        // Modal open/close functionality
        const modals = document.querySelectorAll('.modal');
        
        modals.forEach(modal => {
            const closeBtn = modal.querySelector('.modal-close');
            const cancelBtn = modal.querySelector('#cancelDestinationBtn');
            
            if (closeBtn) {
                closeBtn.addEventListener('click', () => this.closeModal(modal));
            }
            
            if (cancelBtn) {
                cancelBtn.addEventListener('click', () => this.closeModal(modal));
            }
            
            // Close modal when clicking outside
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.closeModal(modal);
                }
            });
        });
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }
    }

    closeModal(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Initialize navigation when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.navigation = new Navigation();
});
// Mobile menu functionality
class MobileMenu {
    constructor() {
        this.menuToggle = document.getElementById('menuToggle');
        this.navMenu = document.getElementById('navMenu');
        this.init();
    }

    init() {
        if (this.menuToggle && this.navMenu) {
            this.menuToggle.addEventListener('click', () => this.toggleMenu());
            
            // Close menu when clicking on a link
            const navLinks = this.navMenu.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => this.closeMenu());
            });
            
            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!this.navMenu.contains(e.target) && !this.menuToggle.contains(e.target)) {
                    this.closeMenu();
                }
            });
        }
    }

    toggleMenu() {
        this.menuToggle.classList.toggle('active');
        this.navMenu.classList.toggle('active');
        
        // Prevent body scroll when menu is open
        if (this.navMenu.classList.contains('active')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }

    closeMenu() {
        this.menuToggle.classList.remove('active');
        this.navMenu.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

// User authentication state simulation
/*class UserAuth {
    constructor() {
        this.navAuth = document.getElementById('navAuth');
        this.navUser = document.getElementById('navUser');
        this.init();
    }

    init() {
        // Simulate user login state (in real app, this would check actual auth)
        const isLoggedIn = localStorage.getItem('userLoggedIn') === 'true';
        this.setAuthState(isLoggedIn);
        
        // Demo: Toggle auth state on user click (for demonstration)
        if (this.navUser) {
            this.navUser.addEventListener('click', (e) => {
                if (e.target.closest('.nav-user')) {
                    // This would normally show user dropdown
                    console.log('User menu clicked');
                }
            });
        }
    }

    setAuthState(isLoggedIn) {
        if (this.navAuth && this.navUser) {
            if (isLoggedIn) {
                this.navAuth.style.display = 'none';
                this.navUser.style.display = 'flex';
            } else {
                this.navAuth.style.display = 'flex';
                this.navUser.style.display = 'none';
            }
        }
    }

    login() {
        localStorage.setItem('userLoggedIn', 'true');
        this.setAuthState(true);
    }

    logout() {
        localStorage.setItem('userLoggedIn', 'false');
        this.setAuthState(false);
    }
}*/

// Initialize navbar components
// Initialize navbar components only if elements exist
document.addEventListener('DOMContentLoaded', () => {
    // Only initialize mobile menu if toggle exists
    if (document.getElementById('menuToggle')) {
        window.mobileMenu = new MobileMenu();
    }
    
    // DON'T initialize UserAuth - PHP handles authentication
    
    // Add scroll effect to navbar
    window.addEventListener('scroll', () => {
        const navbar = document.querySelector('.navbar');
        if (navbar && window.scrollY > 100) {
            navbar.style.background = 'rgba(255, 255, 255, 0.98)';
            navbar.style.boxShadow = '0 2px 30px rgba(0, 0, 0, 0.15)';
        } else if (navbar) {
            navbar.style.background = 'rgba(255, 255, 255, 0.95)';
            navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
        }
    });
});