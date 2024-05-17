<?php
include_once 'init.php';
//we need an input for the year
//basic
//url.com/api/previous_election_result.php?year=num
//template_key
//url.com/api/int.php?=argumentum=1

if(isset($_GET['party'])) {
    $valid_years = array(2014,2018,2022);
    $party = $_GET['party'];
    if(in_array($year,$valid_years)){
        $sql = "SELECT E.nev AS 'Induló neve', M.nev AS 'Megye', P.nev AS 'Induló pártja', O.nev AS 'Országos lista', V.szavazat AS 'Szavazatok száma', CASE WHEN V.szavazat = MAX(V.szavazat) OVER(PARTITION BY V.valasztokerulet_id) THEN 'Igen' ELSE 'Nem' END AS 'Nyert?' FROM  Valasztasiadatok V INNER JOIN  Egyeni E ON V.egyeni_id = E.id INNER JOIN  Valasztasikerulet VK ON V.valasztokerulet_id = VK.id INNER JOIN  Megye M ON VK.megye_id = M.id INNER JOIN  Orszagoslistak O ON V.orszagoslista_id = O.id INNER JOIN  Partok P ON E.tamogatott_part_ = P.id WHERE  V.ev = $year;";
        $result = array($conn->query($sql));
        //post the json results
        echo json_encode($result);
    } else {
        echo "error";
    }
    $conn->close();
} else {
    echo "something";
}
