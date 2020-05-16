<?php 	

$localhost = "localhost";
$username = "root";
$password = "root";
$dbname = "store";
$store_url = "http://localhost/php-inventory-management-system/";
// db connection
$connect = new mysqli($localhost, $username, $password, $dbname);
// check connection
if($connect->connect_error) {
  die("Connection Failed : " . $connect->connect_error);
} else {
  // echo "Successfully connected";
}

?>