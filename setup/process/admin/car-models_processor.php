<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];

// Get Car Model Dropdown
if ($method == 'fetch_car_model_dropdown') {
	$sql = "SELECT `car_model` FROM `car_models` ORDER BY car_model ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option disabled selected value="">Select Car Model</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		}
	} else {
		echo '<option disabled selected value="">Select Car Model</option>';
	}
}

// Get Car Model Dropdown
if ($method == 'fetch_car_model_dropdown_search') {
	$sql = "SELECT `car_model` FROM `car_models` ORDER BY car_model ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		echo '<option selected value="All">All Car Models</option>';
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.htmlspecialchars($row['car_model']).'">'.htmlspecialchars($row['car_model']).'</option>';
		}
	} else {
		echo '<option selected value="All">All Car Models</option>';
	}
}

// Get Car Model Datalist
if ($method == 'fetch_car_model_datalist') {
	$process = $_POST['process'];
	$sql = "SELECT `car_model` ";
	if ($process == 'Initial') {
		$sql = $sql . "FROM `line_no_initial` GROUP BY `car_model` ORDER BY `car_model` ASC";
	} else if ($process == 'Final') {
		$sql = $sql . "FROM `line_no_final` ORDER BY `car_model` ASC";
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['car_model'].'">';
		}
	}
}

if ($method == 'fetch_car_model_datalist_search') {
	$sql = "SELECT `car_model` FROM `line_no_initial` GROUP BY `car_model` ORDER BY `car_model` ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['car_model'].'">';
		}
	}
	
	$sql = "SELECT `car_model` FROM `line_no_final` ORDER BY `car_model` ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			echo '<option value="'.$row['car_model'].'">';
		}
	}
}

if ($method == 'get_car_model_details') {
	$car_model = $_POST['car_model'];
	$location = '';

	if (!empty($car_model)) {
		$car_model = addslashes($car_model);
		$sql = "SELECT `car_model`, `location` FROM `line_no_final` WHERE `car_model` = '$car_model'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		if ($stmt -> rowCount() > 0) {
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
				$car_model = $row['car_model'];
				$location = $row['location'];
			}
		}
	}

	$response_arr = array(
		'car_model' => $car_model,
		'location' => $location
	);

	echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

$conn = null;