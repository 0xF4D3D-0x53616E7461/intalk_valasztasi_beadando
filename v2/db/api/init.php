<?php
$host = "localhost";
$db_name = "valasztasok";
$username = "root";
$password = "";
$port = 3306;
$conn = new mysqli($servername, $username, $password,$db_name,$port);
// Check connection
// D:\gdfamitmegtartok\suli2\7\intalk2\intalk_valasztasi_beadando\v2\db\api\init.php
// C:\xampp\htdocs
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM partok";
$result = array($conn->query($sql));
echo json_encode($result);
$conn->close();
?>
