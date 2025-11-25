<?php
require '../connection.php';

echo "<h2>Testing Destination-Accommodation Relationships</h2>";

// Test specific destinations
$testDestinations = ['Seoul', 'Tokyo', 'Paris', 'Hawaii', 'Marrakech'];

foreach ($testDestinations as $testDest) {
    echo "<h3>Testing: {$testDest}</h3>";
    
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
        WHERE d.name LIKE ?
    ";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%{$testDest}%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($results)) {
        echo "No destination found with name: {$testDest}<br>";
        continue;
    }
    
    $accommodations = array_filter($results, function($row) {
        return !is_null($row['accommodation_id']);
    });
    
    echo "Destination: {$results[0]['destination_name']} ({$results[0]['destination_country']})<br>";
    echo "Linked accommodations: " . count($accommodations) . "<br>";
    
    foreach ($accommodations as $acc) {
        echo "&nbsp;&nbsp;- {$acc['accommodation_name']} ({$acc['accommodation_country']})<br>";
    }
    
    echo "<hr>";
}
?>