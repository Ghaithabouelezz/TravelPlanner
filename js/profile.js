// Travel Planner Profile Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    console.log('Travel Planner Profile page loaded successfully');
    
    // Add hover effects to interactive elements
    const interactiveElements = document.querySelectorAll('.stat-card, .info-item, .action-card, .activity-item, .btn');
    
    interactiveElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            if (this.classList.contains('btn')) {
                this.style.transform = 'translateY(-3px)';
            } else if (this.classList.contains('activity-item')) {
                this.style.transform = 'translateX(5px)';
            } else {
                this.style.transform = 'translateY(-5px)';
            }
        });
        
        element.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            if (this.classList.contains('activity-item')) {
                this.style.transform = 'translateX(0)';
            }
        });
    });
    
    // Add animation to avatar on page load
    const avatar = document.querySelector('.avatar');
    if (avatar) {
        setTimeout(() => {
            avatar.style.animation = 'pulse 2s infinite';
        }, 500);
    }
    
    // Add loading state to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<span class="btn-icon">⏳</span> Loading...';
            this.style.opacity = '0.7';
            this.style.cursor = 'wait';
            
            // Reset after 2 seconds (for demo purposes)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.style.opacity = '1';
                this.style.cursor = 'pointer';
            }, 2000);
        });
    });
    
    // Animate stats counting up
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const target = parseInt(stat.textContent);
        let current = 0;
        const increment = target / 30;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            stat.textContent = Math.floor(current);
        }, 50);
    });
    
    // Add typing effect to welcome message
    const welcomeMessage = document.querySelector('.user-role');
    if (welcomeMessage) {
        const text = welcomeMessage.textContent;
        welcomeMessage.textContent = '';
        let i = 0;
        
        function typeWriter() {
            if (i < text.length) {
                welcomeMessage.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 50);
            }
        }
        
        setTimeout(typeWriter, 1000);
    }
    
    // Add travel-themed confetti effect to action cards
    const actionCards = document.querySelectorAll('.action-card');
    actionCards.forEach(card => {
        card.addEventListener('click', function(e) {
            console.log('Navigating to: ' + this.href);
        });
    });
});