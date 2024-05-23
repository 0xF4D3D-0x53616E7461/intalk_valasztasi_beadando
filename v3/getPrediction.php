<?php
header('Content-Type: application/json; charset=utf-8');
include_once 'utils/initPDO.php';

$county = $_GET['county'];
try {
    //call ai api and the result will be stored in FIDESZ
    $FIDESZ = 'FIDESZ-KDNP';
    $stmt = $conn->prepare("
SELECT 
    district AS valasztasikerulet,
    name AS indulo_neve,
    affiliation AS orszagoslista,
    number_votes AS szavazatot_kapott_darab,
    share_votes AS szavazatot_kapott_szazalek
FROM ElectionResults
WHERE district = ? AND affiliation = '$FIDESZ';");
    $stmt->execute([$county]);
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];
    foreach ($rows as $row) {
        $result[] = [
            'valasztasikerulet' => $row['valasztasikerulet'],
            'data' => [
                [
                    'indulo_neve' => $row['indulo_neve'],
                    'orszagoslista' => $row['orszagoslista'],
                    'szavazatot_kapott' => [
                        'darab' => (int) $row['szavazatot_kapott_darab'],
                        'szazalek' => (float) $row['szavazatot_kapott_szazalek']
                    ]
                ]
            ]
        ];
    }

    echo json_encode($result);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}

$conn = null;
?>
