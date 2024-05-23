<?php
// api endpoints
// return $"{_url}/v3/getPreviousElectionData.php?year={ev}";
// return $"{_url}/v3/getPrediction.php?county={megye}";
// return $"{_url}/v3/getPartyData.php?party={part}";
// return $"{_url}/v3/getLastElectionData?county={megye}";

$dsn = 'mysql:host=db;dbname=ElectionResultsDB';
$username = 'root';
$password = 'root_password';
try {
  // Set up the connection parameters
  //$dsn = "sqlsrv:Server=$serverName;Database=$database"; 
  // Create a PDO instance (connect to the database)
  $conn= new PDO($dsn, $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);// Fetch results as associative arrays
} catch (PDOException $e) {
    // Handle connection errors
    echo "Connection failed: " . $e->getMessage();
}
