<?php
session_start();
require_once '../config/database.php'; // Your database connection

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get the POST data
$input = json_decode(file_get_contents('php://input'), true);
$credential = $input['credential'] ?? '';

if (empty($credential)) {
    echo json_encode(['success' => false, 'message' => 'No credential provided']);
    exit;
}

// Split the JWT token to get the payload
$parts = explode('.', $credential);
if (count($parts) !== 3) {
    echo json_encode(['success' => false, 'message' => 'Invalid token format']);
    exit;
}

$payload = json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', $parts[1]))), true);

// Verify the token (in production, you should verify the signature)
$email = $payload['email'] ?? '';
$name = $payload['name'] ?? '';
$googleId = $payload['sub'] ?? '';

if (empty($email) || empty($googleId)) {
    echo json_encode(['success' => false, 'message' => 'Invalid token data']);
    exit;
}

try {
    // Check if user exists in database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? OR google_id = ?");
    $stmt->execute([$email, $googleId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Update user's Google ID if not set
        if (empty($user['google_id'])) {
            $updateStmt = $pdo->prepare("UPDATE users SET google_id = ? WHERE id = ?");
            $updateStmt->execute([$googleId, $user['id']]);
        }
    } else {
        // Create new user
        $insertStmt = $pdo->prepare("INSERT INTO users (name, email, google_id, created_at) VALUES (?, ?, ?, NOW())");
        $insertStmt->execute([$name, $email, $googleId]);
        $userId = $pdo->lastInsertId();
        
        // Fetch the newly created user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Set session variables
    $_SESSION['loggedIn'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_email'] = $user['email'];

    echo json_encode(['success' => true, 'message' => 'Login successful']);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
?>