<?php
header('Content-Type: application/json; charset=utf-8');
include_once 'utils/initPDO.php';

// Enable error reporting and logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/your/error.log');  // Set this to the path where you want to log errors

// Fetch the county from the query parameters
$county = isset($_GET['county']) ? $_GET['county'] : null;

function main($conn, $county) {
    try {
        if ($county) {
            // Prepare and execute the SQL query
            $stmt = $conn->prepare("
                SELECT 
                    er.district AS valasztokerulet,
                    er.name AS indulo_neve,
                    er.affiliation AS orszagoslistaja,
                    er.number_votes AS szavazatot_kapott_darab,
                    er.share_votes AS szavazatot_kapott_szazalek,
                    CASE 
                        WHEN er.number_votes = mv.max_votes THEN 1
                        ELSE 0
                    END AS nyert
                FROM 
                    ElectionResults er
                INNER JOIN 
                    (SELECT district, MAX(number_votes) AS max_votes
                     FROM ElectionResults
                     WHERE year = 2022
                     GROUP BY district) mv
                ON 
                    er.district = mv.district
                WHERE 
                    er.district = ?
                ORDER BY 
                    er.number_votes DESC
            ");
            $stmt->execute([$county]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Process the results
            $utolso_valasztasok = [];

            foreach ($rows as $row) {
                // Check if the district is already in the result array
                $districtIndex = null;
                foreach ($utolso_valasztasok as $index => $valasztas) {
                    if ($valasztas['valasztokerulet'] == $row['valasztokerulet']) {
                        $districtIndex = $index;
                        break;
                    }
                }

                // If the district is not in the result array, add it
                if ($districtIndex === null) {
                    $utolso_valasztasok[] = [
                        'valasztokerulet' => $row['valasztokerulet'],
                        'data' => []
                    ];
                    $districtIndex = count($utolso_valasztasok) - 1;
                }

                // Add the candidate data to the corresponding district
                $utolso_valasztasok[$districtIndex]['data'][] = [
                    'indulo_neve' => $row['indulo_neve'],
                    'orszagoslistaja' => $row['orszagoslistaja'],
                    'szavazatot_kapott' => [
                        'darab' => (int)$row['szavazatot_kapott_darab'],
                        'szazalek' => (float)$row['szavazatot_kapott_szazalek']
                    ],
                    'nyert' => (bool)$row['nyert']
                ];
            }

            // Output the JSON
            echo json_encode($utolso_valasztasok, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } else {
            // Output an error message for a missing or invalid county
            echo json_encode(array("error" => "Invalid or missing county parameter"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }
    } catch (Exception $e) {
        // Log the exception and output an error message
        error_log($e->getMessage());
        echo json_encode(array("error" => "Internal server error"), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    // Close the connection
    $conn = null;
}

main($conn, $county);
?>
