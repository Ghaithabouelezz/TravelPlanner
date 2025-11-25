<script src="https://accounts.google.com/gsi/client" async defer></script>

// Google OAuth Configuration
const googleClientId = 'YOUR_GOOGLE_CLIENT_ID'; // Replace with your actual client ID

// Initialize Google Identity Services
function initializeGoogleAuth() {
    google.accounts.id.initialize({
        client_id: googleClientId,
        callback: handleGoogleSignIn,
        auto_select: false,
        cancel_on_tap_outside: true
    });
    
    // Render the Google Sign In button
    google.accounts.id.renderButton(
        document.getElementById('googleSignIn'),
        {
            theme: 'outline',
            size: 'large',
            width: '280',
            text: 'continue_with',
            shape: 'rectangular'
        }
    );
    
    // Also offer one-tap sign-up
    google.accounts.id.prompt();
}

// Handle the Google Sign In response
function handleGoogleSignIn(response) {
    if (response.credential) {
        // Show loading state
        document.getElementById('googleSignIn').disabled = true;
        
        // Send the ID token to your server for verification
        fetch('actions/google_login_action.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                credential: response.credential
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success notification
                document.getElementById('successNotification').style.display = 'flex';
                
                // Redirect to dashboard after a short delay
                setTimeout(() => {
                    window.location.href = 'home.php';
                }, 1500);
            } else {
                // Show error message
                alert('Google login failed: ' + data.message);
                document.getElementById('googleSignIn').disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred during Google login');
            document.getElementById('googleSignIn').disabled = false;
        });
    }
}

// Initialize when the page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeGoogleAuth();
});
