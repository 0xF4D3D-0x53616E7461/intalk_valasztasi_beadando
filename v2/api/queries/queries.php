<?php
//$what_to_replace can be changed due to the different sql statments like year(yyyy), country(cccc)
function getStringByKey($sql_key,$what_to_replace,$replace_to){
    $sqlFilename = "/sql/ " . $sql_key . ".sql"; //This must be also cheched for bugs!!!!
    //we need to change the debugg message type
    if(!file_exists($sqlFilename)){
        return "File not found for key: $sql_key";
    }
    $sqlStatement = file_get_contents($sqlFilename);
    
    //we need to change the debugg message type
    if(!$sqlStatement === false) {
        return "Unable to read file for key: $sql_key";
    }

    $sqlStatement = str_replace($what_to_replace,$replace_to,$sqlStatement); //

    return $sqlStatement;
}
?>