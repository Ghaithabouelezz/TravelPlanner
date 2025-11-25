<?php
session_start();
header('Content-Type: application/json');

// Simple implementation - you'll want to expand this
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$destinationId = $input['destination_id'] ?? null;

if ($destinationId) {
    // Here you would add to user_wishlist table
    // For now, just return success
    echo json_encode(['success' => true, 'message' => 'Added to wishlist']);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid destination']);
}
?>