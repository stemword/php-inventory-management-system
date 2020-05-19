<?php 	
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once 'core.php';
require_once '../libraries/phpexcel/PHPExcel.php';
require_once '../libraries/phpexcel/PHPExcel/IOFactory.php';

$valid['success'] = array('success' => false, 'messages' => array());
//print_r($_FILES);//exit;
if($_FILES) {

	$type = explode('.', $_FILES['brandfile']['name']);
	$type = $type[count($type)-1];		
	$url = '../assests/images/stock/'.uniqid(rand()).'.'.$type;
	if(in_array($type, array("csv", "xls", "xlsx"))) {
		if(is_uploaded_file($_FILES['brandfile']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['brandfile']['tmp_name'], $url)) {
				$objPHPExcel = PHPExcel_IOFactory::load($url);
				$sheet = $objPHPExcel->getSheet(0);
				$highestRow = $sheet->getHighestRow();
				$no_error_data = array();
				$highestColumn = $sheet->getHighestColumn();
				$highestColumn = 'B';
    			$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				for ($row = 2; $row <= $highestRow; $row++) {
					$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,FALSE,TRUE);
					if(isset($rowData[0][0]) && !empty($rowData[0][0]) && isset($rowData[0][1])) { // check for amount ,rest id and service name
						$no_error_data[$row-1] = $rowData[0];
					} else {
						$error[] = $rowData[0];
					}
				}
				if(!empty($no_error_data)) {
					foreach ($no_error_data as $value) {
						$select_sql = "SELECT * FROM brands WHERE brand_name ='$value[0]'";
						$result = $connect->query($select_sql);
						if($result->num_rows == 0) { 
						$sql = "INSERT INTO brands (brand_name, brand_active, brand_status) VALUES ('$value[0]', '$value[1]', '$value[1]')";
							if($connect->query($sql) === TRUE) {
								$valid['success'] = true;
								$valid['messages'] = "Successfully Added";
							} else {
								$valid['success'] = false;
								$valid['messages'] = "Error while adding the brands";
							}
						} else {
							$valid['success'] = true;
							$valid['messages'] = "Successfully Added";
						}
					}
				}
			} else {
				$valid['success'] = false;
					$valid['messages'] = "Error while adding the brands";
			}	// /else	
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while adding the brands";
		} // if
	} // if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST