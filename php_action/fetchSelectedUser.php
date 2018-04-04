<?php 	

require_once 'core.php';

$userid = $_POST['userid'];

$sql = "SELECT * FROM users WHERE user_id = $userid";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);