<?php
require_once '../connection.php';
header('Content-Type: application/json');

try {
    // Get all destinations with their accommodations
    $sql = "
        SELECT 
            d.destination_id,
            d.name as destination_name,
            d.country as destination_country,
            a.accommodation_id,
            a.name as accommodation_name,
            a.country as accommodation_country
        FROM destinations d
        LEFT JOIN accommodation_destinations ad ON d.destination_id = ad.destination_id
        LEFT JOIN accommodations a ON ad.accommodation_id = a.accommodation_id
        ORDER BY d.name, a.name
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Group by destination
    $grouped = [];
    foreach ($results as $row) {
        $destName = $row['destination_name'];
        if (!isset($grouped[$destName])) {
            $grouped[$destName] = [
                'destination' => $destName,
                'country' => $row['destination_country'],
                'accommodations' => []
            ];
        }
        if ($row['accommodation_name']) {
            $grouped[$destName]['accommodations'][] = [
                'name' => $row['accommodation_name'],
                'country' => $row['accommodation_country']
            ];
        }
    }
    
    echo "<pre>";
    echo "=== DESTINATION-ACCOMMODATION MAPPING ===\n\n";
    foreach ($grouped as $dest) {
        echo "DESTINATION: {$dest['destination']} ({$dest['country']})\n";
        echo "ACCOMMODATIONS: " . count($dest['accommodations']) . "\n";
        foreach ($dest['accommodations'] as $acc) {
            echo "  - {$acc['name']} ({$acc['country']})\n";
        }
        echo "\n";
    }
    echo "</pre>";
    
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>