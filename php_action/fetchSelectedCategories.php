<?php 	

require_once 'core.php';

$categoriesId = $_POST['categoriesId'];

$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_id = $categoriesId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);