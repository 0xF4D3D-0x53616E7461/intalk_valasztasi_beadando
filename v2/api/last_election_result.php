<?php
include_once 'init.php';
$sql = "SELECT * FROM partok";
$result = array($conn->query($sql));
echo json_encode($result);
$conn->close();