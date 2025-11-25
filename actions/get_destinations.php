<?php
session_start();
header('Content-Type: application/json');

require_once '../connection.php';

try {
    // Get filters from request
    $region = isset($_GET['region']) ? $_GET['region'] : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : 'popular';
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $limit = 8;
    $offset = ($page - 1) * $limit;

    // Build query
    $sql = "SELECT * FROM destinations WHERE 1=1";
    $params = [];

    // Improved region filter with proper country mapping
   // In your get_destinations.php, replace the region filtering part with:
if (!empty($region)) {
    $sql .= " AND region = ?";
    $params[] = $region;
}
    // Add sorting
    switch ($sort) {
        case 'rating':
            $sql .= " ORDER BY name ASC";
            break;
        case 'name':
            $sql .= " ORDER BY name ASC";
            break;
        case 'popular':
        default:
            $sql .= " ORDER BY destination_id DESC";
            break;
    }

    // Add pagination - using positional parameters for consistency
    $sql .= " LIMIT ? OFFSET ?";
    $params[] = $limit;
    $params[] = $offset;

    $stmt = $pdo->prepare($sql);
    
    // Bind all parameters as positional parameters
    foreach ($params as $index => $value) {
        $stmt->bindValue($index + 1, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
    
    $stmt->execute();
    $destinations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get total count for pagination (remove LIMIT and OFFSET for count)
    $countSql = "SELECT COUNT(*) as total FROM destinations WHERE 1=1";
    $countParams = [];
    
    if (!empty($region) && isset($regionMap[$region])) {
        $placeholders = str_repeat('?,', count($regionMap[$region]) - 1) . '?';
        $countSql .= " AND country IN ($placeholders)";
        $countParams = $regionMap[$region];
    }
    
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute($countParams);
    $totalResult = $countStmt->fetch(PDO::FETCH_ASSOC);
    $totalDestinations = $totalResult['total'];

    // Format response
    foreach ($destinations as &$dest) {
        $dest['avg_rating'] = $dest['avg_rating'] ?? 0;
        $dest['review_count'] = $dest['review_count'] ?? 0;
        
        // Optimize image URL
        if (!empty($dest['image_url'])) {
            $dest['image_url'] = optimizeImageUrl($dest['image_url']);
        } else {
            $dest['image_url'] = 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&h=300&q=80';
        }
    }

    echo json_encode([
        'success' => true,
        'destinations' => $destinations,
        'total' => $totalDestinations,
        'hasMore' => ($offset + count($destinations)) < $totalDestinations,
        'debug' => [
            'region' => $region,
            'found' => count($destinations),
            'total' => $totalDestinations
        ]
    ]);

} catch(PDOException $e) {
    error_log("Database error in get_destinations.php: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}

// Helper function to optimize image URLs
function optimizeImageUrl($url) {
    // If it's an Unsplash URL, optimize it
    if (strpos($url, 'unsplash.com') !== false) {
        // Remove existing query parameters
        $url = strtok($url, '?');
        // Add optimized parameters
        $url .= '?auto=format&fit=crop&w=500&h=300&q=80';
    }
    return $url;
}
?>