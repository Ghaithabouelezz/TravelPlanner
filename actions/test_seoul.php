<?php
require_once '../connection.php';
header('Content-Type: application/json');

try {
    // Test query for Seoul accommodations
    $sql = "SELECT a.*, d.name as destination_name, d.country as destination_country 
            FROM accommodations a
            LEFT JOIN accommodation_destinations ad ON a.accommodation_id = ad.accommodation_id 
            LEFT JOIN destinations d ON ad.destination_id = d.destination_id
            WHERE d.name LIKE '%Seoul%' OR a.country LIKE '%South Korea%'";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $accommodations = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'accommodations' => $accommodations,
        'count' => count($accommodations),
        'debug_sql' => $sql
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>