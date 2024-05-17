<?php
include_once 'init.php';
include_once '../queries/queries.php';
//we need an input for the year
//basic
//url.com/api/previous_election_result.php?year=num
//template_key
//url.com/api/int.php?=argumentum=1

if(isset($_GET['year'])) {
    $valid_years = array(2014,2018,2022);
    $year = $_GET['year'];
    if(in_array($year,$valid_years)){
        $sql = "SELECT E.nev AS 'Induló neve', M.nev AS 'Megye', P.nev AS 'Induló pártja', O.nev AS 'Országos lista', V.szavazat AS 'Szavazatok száma', CASE WHEN V.szavazat = MAX(V.szavazat) OVER(PARTITION BY V.valasztokerulet_id) THEN 'Igen' ELSE 'Nem' END AS 'Nyert?' FROM  Valasztasiadatok V INNER JOIN  Egyeni E ON V.egyeni_id = E.id INNER JOIN  Valasztasikerulet VK ON V.valasztokerulet_id = VK.id INNER JOIN  Megye M ON VK.megye_id = M.id INNER JOIN  Orszagoslistak O ON V.orszagoslista_id = O.id INNER JOIN  Partok P ON E.tamogatott_part_ = P.id WHERE  V.ev = yyyy;";
        $sql1 = "SELECT * FROM megye;";
        //the sql statement should be coming from ../queries/queries.php via keys
        $result = $conn->query($sql);
        //post the json results
        if($result->num_rows > 0){
            $rows = array();
            while($row = $result->fetch_assoc()){
                $rows[] = $row;
            }
            echo json_encode($rows);
        }else{
            echo json_encode(array("error" => "No results found"));    
        }
    } else {
        echo json_encode(array("error" => "Invalid year"));
    }
    $conn->close();
} else {
    echo json_encode(array("error" => "Year not specified"));
}
//previous_election_result.php