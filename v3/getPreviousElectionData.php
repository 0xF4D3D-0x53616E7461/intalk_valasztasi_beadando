<?php
header('Content-Type: application/json; charset=utf-8');
include_once 'utils/initPDO.php';

// Enable error reporting and logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/your/error.log');  // Set this to the path where you want to log errors

function main($conn) {
    try {
        // Fetch the year from the query parameters
        $year = isset($_GET['year']) ? (int)$_GET['year'] : null;
        $valid_years = array(2014, 2018, 2022);

        // Check if the provided year is valid
        if (in_array($year, $valid_years)) {
            // Prepare and execute the SQL query
            $stmt = $conn->prepare("SELECT * FROM ElectionResults WHERE year = ?");
            $stmt->execute([$year]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Process the results
            $korabbi_valasztasok = [];
            foreach ($rows as $row) {
                // Check if the year is already in the result array
                $yearIndex = null;
                foreach ($korabbi_valasztasok as $index => $valasztas) {
                    if ($valasztas['év'] == $row['year']) {
                        $yearIndex = $index;
                        break;
                    }
                }

                // If the year is not in the result array, add it
                if ($yearIndex === null) {
                    $korabbi_valasztasok[] = [
                        'ev' => $row['year'],
                        'data' => []
                    ];
                    $yearIndex = count($korabbi_valasztasok) - 1;
                }

                // Add the candidate data to the corresponding year
                $korabbi_valasztasok[$yearIndex]['data'][] = [
                    'indulo_neve' => $row['name'],
                    'valasztokerulet' => $row['district'],
                    'orszagoslista' => $row['affiliation'],
                    'szavazatot_kapott' => [
                        'darab' => (int)$row['number_votes'],
                        'szazalek' => (float)$row['share_votes']
                    ],
                    'nyert' => (bool)$row['nyert']
                ];
            }

            // Output the JSON
            echo json_encode($korabbi_valasztasok, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            // Output an error message for an invalid year
            echo json_encode(array("error" => "Invalid year"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    } catch (Exception $e) {
        // Log the exception and output an error message
        error_log($e->getMessage());
        echo json_encode(array("error" => "Internal server error"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Close the connection
    $conn = null;
}

main($conn);
