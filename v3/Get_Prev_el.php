<?php
class Database {
    private $host = 'localhost';
    private $db_name = 'ElectionResultsDB';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>


<?php
include_once 'Database.php';

class ElectionResults {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getPreviousElectionResults() {
        $query = "SELECT 
    er.year AS év,
    er.name AS indulo_neve,
    er.district AS valasztokerulet,
    er.affiliation AS orszagoslista,
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
    AND er.year = 2022
ORDER BY 
    er.district, er.number_votes DESC;
;";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $results = [];
        $yearlyData = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $year = $row['év'];
            if (!isset($yearlyData[$year])) {
                $yearlyData[$year] = [
                    'év' => $year,
                    'data' => []
                ];
            }
            $yearlyData[$year]['data'][] = [
                'indulo_neve' => $row['indulo_neve'],
                'valasztokerulet' => $row['valasztokerulet'],
                'orszagoslista' => $row['orszagoslista'],
                'szavazatot_kapott' => [
                    'darab' => $row['szavazatot_kapott_darab'],
                    'szazalek' => $row['szavazatot_kapott_szazalek']
                ],
                'nyert' => $row['nyert'] == 1
            ];
        }

        foreach ($yearlyData as $year => $data) {
            $results[] = $data;
        }

        return $results;
    }
}
?>

<?php
header('Content-Type: application/json');

$database = new Database();
$db = $database->getConnection();
