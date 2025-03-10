<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];

if ($method == 'fetch_car_model_datalist_search') {
	$sql = "SELECT car_model FROM line_no_initial GROUP BY car_model ORDER BY car_model ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['car_model'].'">';
		}
	}
	
	$sql = "SELECT car_model FROM line_no_final ORDER BY car_model ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['car_model'].'">';
		}
	}
}

$conn = null;
?>