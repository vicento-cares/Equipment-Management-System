<?php 
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');
require('../lib/validate.php');
require('../lib/main.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');

// Count
if ($method == 'count_machine_history') {
	$history_date_from = $_POST['history_date_from'];
	if (!empty($history_date_from)) {
		$history_date_from = date_create($history_date_from);
		$history_date_from = date_format($history_date_from,"Y-m-d H:i:s");
	}
	$history_date_to = $_POST['history_date_to'];
	if (!empty($history_date_to)) {
		$history_date_to = date_create($history_date_to);
		$history_date_to = date_format($history_date_to,"Y-m-d H:i:s");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$car_model = addslashes($_POST['car_model']);
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);

	$sql = "SELECT count(id) AS total FROM machine_history";
	if (!empty($car_model) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || (!empty($history_date_from) && !empty($history_date_to))) {
		$sql = $sql . ' WHERE';
		if (!empty($car_model) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
			$sql = $sql . " car_model LIKE '$car_model%' AND machine_name LIKE '$machine_name%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%'";
			if (!empty($history_date_from) && !empty($history_date_to)) {
				$sql = $sql . " AND (history_date_time >= '$history_date_from' AND history_date_time <= '$history_date_to')";
			}
		} else if (!empty($history_date_from) && !empty($history_date_to)) {
			$sql = $sql . " (history_date_time >= '$history_date_from' AND history_date_time <= '$history_date_to')";
		}
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Read / Load
if ($method == 'get_machine_history') {
	$id = $_POST['id'];
	$history_date_from = $_POST['history_date_from'];
	if (!empty($history_date_from)) {
		$history_date_from = date_create($history_date_from);
		$history_date_from = date_format($history_date_from,"Y-m-d H:i:s");
	}
	$history_date_to = $_POST['history_date_to'];
	if (!empty($history_date_to)) {
		$history_date_to = date_create($history_date_to);
		$history_date_to = date_format($history_date_to,"Y-m-d H:i:s");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$car_model = addslashes($_POST['car_model']);
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);
	$c = $_POST['c'];

	$sql = "SELECT id, number, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, ns-iv_no, machine_status, new_car_model, new_location, new_grid, pic, status_date, history_date_time FROM machine_history";

	if (empty($id)) {
		if (!empty($car_model) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || (!empty($history_date_from) && !empty($history_date_to))) {
			$sql = $sql . ' WHERE';
			if (!empty($car_model) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
				$sql = $sql . " car_model LIKE '$car_model%' AND machine_name LIKE '$machine_name%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%'";
				if (!empty($history_date_from) && !empty($history_date_to)) {
					$sql = $sql . " AND (history_date_time >= '$history_date_from' AND history_date_time <= '$history_date_to')";
				}
			} else if (!empty($history_date_from) && !empty($history_date_to)) {
				$sql = $sql . " (history_date_time >= '$history_date_from' AND history_date_time <= '$history_date_to')";
			}
		}
	} else {
		$sql = $sql . " WHERE id < '$id'";
		if (!empty($car_model) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || (!empty($history_date_from) && !empty($history_date_to))) {
			$sql = $sql . ' AND';
			if (!empty($car_model) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
				$sql = $sql . " (car_model LIKE '$car_model%' AND machine_name LIKE '$machine_name%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%')";
				if (!empty($history_date_from) && !empty($history_date_to)) {
					$sql = $sql . " AND (history_date_time >= '$history_date_from' AND history_date_time <= '$history_date_to')";
				}
			} else if (!empty($history_date_from) && !empty($history_date_to)) {
				$sql = $sql . " (history_date_time >= '$history_date_from' AND history_date_time <= '$history_date_to')";
			}
		}
	}
	$sql = $sql . " ORDER BY id DESC LIMIT 25";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr id="'.$row['id'].'">';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['history_date_time'])).'</td>';
			echo '<td>'.$row['number'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_spec']).'</td>';
			echo '<td>'.htmlspecialchars($row['car_model']).'</td>';
			echo '<td>'.htmlspecialchars($row['location']).'</td>';
			echo '<td>'.htmlspecialchars($row['grid']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['asset_tag_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['trd_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['ns-iv_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_status']).'</td>';
			echo '<td>'.htmlspecialchars($row['new_car_model']).'</td>';
			echo '<td>'.htmlspecialchars($row['new_location']).'</td>';
			echo '<td>'.htmlspecialchars($row['new_grid']).'</td>';
			echo '<td>'.htmlspecialchars($row['pic']).'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['status_date'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="18" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

$conn = null;
?>