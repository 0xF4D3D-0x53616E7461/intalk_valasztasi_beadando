<?php
header('Content-Type: application/json; charset=utf-8');
include_once 'utils/initPDO.php';
// Enable error reporting and logging
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', '/logs/party_php.log');  // Set this to the path where you want to log errors
// Fetch the party from the query parameters
$party = isset($_GET['party']) ? (string)$_GET['party'] : null;

function fetchPartyData(PDO $conn, string $party): array {
    $partyData = [
        'neve' => $party,
        'ossze_induloja' => 0,
        'indulasi_evek' => [],
        'adatok' => []
    ];
    // Get general information and detailed candidate data in a single query
    $stmt = $conn->prepare(
        "SELECT
    er.affiliation AS neve,
    COUNT(er2.name) AS ossze_induloja,
    er.year AS ev,
    AVG(er.share_votes) AS orszagos_eredmeny,
    er2.name AS indulo_neve,
    er2.district AS valasztasi_terulet,
    MAX(er2.number_votes) AS szavazatot_kapott_darab,
    MAX(er2.share_votes) AS szavazatot_kapott_szazalek,
    (
        SELECT MAX(er3.year) 
        FROM ElectionResults er3 
        WHERE er3.name = er2.name 
          AND er3.district = er2.district 
          AND er3.number_votes = (SELECT MAX(er4.number_votes)
                                  FROM ElectionResults er4
                                  WHERE er4.name = er2.name
                                    AND er4.district = er2.district)
    ) AS utoljara_nyert
FROM 
    ElectionResults er
JOIN
    ElectionResults er2 ON er.affiliation = er2.affiliation
WHERE 
    er.affiliation = ?
GROUP BY 
    er.affiliation, er.year, er2.name, er2.district
ORDER BY 
    er.year, er2.district;");
        $stmt->execute([$party]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Add general and detailed candidate results
        $is_2014 = FALSE;
        $is_2018 = FALSE;
        $is_2022 = FALSE;
        foreach ($results as $result) {
            if(($result['ev']=='2014'&&$is_2014==FALSE)||($result['ev']=='2018'&&$is_2018==FALSE)||($result['ev']=='2022'&&$is_2022==FALSE)){
                $partyData['ossze_induloja'] += $result['ossze_induloja'];
                $partyData['indulasi_evek'][] = [
                    'ev' => $result['ev'],
                    'orszagos_eredmeny' => (float) $result['orszagos_eredmeny']
                ];
                if(($result['ev']=='2014'&&$is_2014==FALSE)){
                    $is_2014 = TRUE;
                }
                if(($result['ev']=='2018'&&$is_2018==FALSE)){
                    $is_2018 = TRUE;
                }
                if(($result['ev']=='2022'&&$is_2022==FALSE)){
                    $is_2022 = TRUE;
                }
            }
            $partyData['adatok'][] = [
                'indulo_neve' => $result['indulo_neve'],
                'valasztasi_terulet' => $result['valasztasi_terulet'],
                'szavazatot_kapott' => [
                    'darab' => (int) $result['szavazatot_kapott_darab'],
                    'szazalek' => (float) $result['szavazatot_kapott_szazalek']
                ],
                'utoljara_nyert' => $result['utoljara_nyert'] ? (int) $result['utoljara_nyert'] : null
            ];
        }

    return $partyData;
}

// Fetch party data
$partyData = fetchPartyData($conn, $party);

// Output JSON response
echo json_encode(array($partyData), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

// Close the database connection
$conn = null;

