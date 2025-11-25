<?php
require_once '../connection.php';
header('Content-Type: application/json');

try {
    // Get parameters
    $destination = isset($_GET['destination']) ? trim($_GET['destination']) : '';
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $type = isset($_GET['type']) ? $_GET['type'] : '';
    $price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';
    $rating = isset($_GET['rating']) ? $_GET['rating'] : '';

    error_log("=== NEW ACCOMMODATIONS SEARCH ===");
    error_log("Destination: '{$destination}'");
    error_log("Search: '{$search}'");

    $accommodations = [];
    $params = [];

    // STRATEGY 1: Find by destination through mapping table (MOST ACCURATE)
    if (!empty($destination)) {
        error_log("Strategy 1: Searching via destination mapping");
        
        $sql = "
            SELECT DISTINCT a.*, d.name as linked_destination, d.country as linked_country
            FROM accommodations a
            INNER JOIN accommodation_destinations ad ON a.accommodation_id = ad.accommodation_id
            INNER JOIN destinations d ON ad.destination_id = d.destination_id
            WHERE (d.name LIKE ? OR d.country LIKE ?)
        ";
        
        $destinationParam = "%" . $destination . "%";
        $params = [$destinationParam, $destinationParam];
        
        error_log("SQL: " . $sql);
        error_log("Params: " . json_encode($params));
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $accommodations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("Strategy 1 found: " . count($accommodations) . " accommodations");
        
        // Log what we found
        foreach ($accommodations as $acc) {
            error_log("Found: {$acc['name']} -> Linked to: {$acc['linked_destination']} ({$acc['linked_country']})");
        }
    }

    // STRATEGY 2: If no results from mapping, try direct country match
    if (empty($accommodations) && !empty($destination)) {
        error_log("Strategy 2: Searching via direct country match");
        
        $sql = "SELECT * FROM accommodations WHERE country LIKE ?";
        $countryParam = "%" . $destination . "%";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$countryParam]);
        $accommodations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("Strategy 2 found: " . count($accommodations) . " accommodations");
    }

    // STRATEGY 3: If still no results, show all accommodations
    if (empty($accommodations)) {
        error_log("Strategy 3: Showing all accommodations");
        
        $sql = "SELECT * FROM accommodations WHERE 1=1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $accommodations = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("Strategy 3 found: " . count($accommodations) . " accommodations");
    }

    // Apply additional filters
    $filteredAccommodations = [];
    foreach ($accommodations as $acc) {
        // Type filter
        if (!empty($type) && $acc['type'] !== $type) {
            continue;
        }
        
        // Price filter
        if (!empty($price_range)) {
            $price = floatval($acc['price_per_night']);
            switch($price_range) {
                case '0-100':
                    if ($price > 100) continue 2;
                    break;
                case '100-200':
                    if ($price <= 100 || $price > 200) continue 2;
                    break;
                case '200-500':
                    if ($price <= 200 || $price > 500) continue 2;
                    break;
                case '500+':
                    if ($price <= 500) continue 2;
                    break;
            }
        }
        
        // Rating filter
        if (!empty($rating) && intval($acc['rating']) < intval($rating)) {
            continue;
        }
        
        // Search filter
        if (!empty($search)) {
            $searchLower = strtolower($search);
            $nameLower = strtolower($acc['name']);
            $typeLower = strtolower($acc['type']);
            $countryLower = strtolower($acc['country'] ?? '');
            
            if (strpos($nameLower, $searchLower) === false && 
                strpos($typeLower, $searchLower) === false &&
                strpos($countryLower, $searchLower) === false) {
                continue;
            }
        }
        
        $filteredAccommodations[] = $acc;
    }

    error_log("Final filtered results: " . count($filteredAccommodations));

    echo json_encode([
        'success' => true,
        'accommodations' => $filteredAccommodations,
        'count' => count($filteredAccommodations),
        'debug' => [
            'requested_destination' => $destination,
            'total_before_filtering' => count($accommodations),
            'total_after_filtering' => count($filteredAccommodations)
        ]
    ]);

} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>