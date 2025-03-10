<?php 
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');
require('../lib/validate.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');

function pm_concern_mark_as_read($id, $conn) {
	$sql = "UPDATE machine_pm_concerns SET is_read_sp = 1  WHERE id = '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$sql = "UPDATE notif_pm_no_spare SET new_pm_concerns = CASE WHEN new_pm_concerns > 0 THEN new_pm_concerns - 1 END  WHERE interface = 'ADMIN-SP'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

function check_all_no_spare_status($pm_concern_id, $conn) {
	$total_close = 0;
	$no_of_parts = 0;

	$sql = "SELECT count(id) AS total FROM machine_pm_no_spare WHERE pm_concern_id = '$pm_concern_id' AND no_spare_status = 'CLOSE'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$total_close = $row['total'];
		}
	}

	$sql = "SELECT no_of_parts FROM machine_pm_concerns WHERE pm_concern_id = '$pm_concern_id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$no_of_parts = $row['no_of_parts'];
		}
	}

	if ($total_close == $no_of_parts) {
		return 'CLOSE';
	} else {
		return 'OPEN';
	}
}

// Count
if ($method == 'count_no_spare_pm_concerns') {
	$sql = "SELECT count(id) AS total FROM machine_pm_concerns WHERE comment = 'NO SPARE' AND no_spare = 1 AND status = 'Pending'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Read / Load
if ($method == 'get_no_spare_pm_concerns') {
	$status = 'New';
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-orange', 'modal-trigger bg-success');
	$row_class = $row_class_arr[0];
	$c = 0;
	$sql = "SELECT id, pm_concern_id, machine_line, machine_name, car_model, trd_no, `ns-iv_no`, problem, request_by, confirm_by, comment, concern_date_time, no_of_parts, status, is_read_sp FROM machine_pm_concerns WHERE comment = 'NO SPARE' AND no_spare = 1 AND status = 'Pending' ORDER BY id DESC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			$no_spare_status = check_all_no_spare_status($row['pm_concern_id'], $conn);
			if ($no_spare_status == 'CLOSE') {
				$row_class = $row_class_arr[2];
			} else if (intval($row['is_read_sp']) == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="NS_'.$row['id'].'" data-toggle="modal" data-target="#NoSparePmConcernModal" data-id="'.$row['id'].'" data-pm_concern_id="'.$row['pm_concern_id'].'" data-concern_date_time="'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'" onclick="get_details_no_spare(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['pm_concern_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_line']).'</td>';
			echo '<td>'.htmlspecialchars($row['problem']).'</td>';
			echo '<td>'.htmlspecialchars($row['request_by']).'</td>';
			echo '<td>'.$row['confirm_by'].'</td>';
			echo '<td>'.htmlspecialchars($row['comment']).'</td>';
			echo '<td>'.$row['no_of_parts'].'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="9" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Read / Load
if ($method == 'get_no_spare_by_pm_concerns_id_sp') {
	$pm_concern_id = $_POST['pm_concern_id'];
	$c = 0;
	$sql = "SELECT id, pm_concern_id, machine_line, machine_name, car_model, trd_no, `ns-iv_no`, problem, request_by, confirm_by, comment, concern_date_time, parts_code, quantity, po_date, po_no, no_spare_status, date_arrived, status FROM machine_pm_no_spare WHERE pm_concern_id = '$pm_concern_id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="NSI_'.$row['id'].'" data-dismiss="modal" data-toggle="modal" data-id="'.$row['id'].'" data-pm_concern_id="'.$row['pm_concern_id'].'" data-machine_line="'.htmlspecialchars($row['machine_line']).'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-car-model="'.htmlspecialchars($row['car_model']).'" data-trd_no="'.$row['trd_no'].'" data-ns-iv_no="'.$row['ns-iv_no'].'" data-problem="'.htmlspecialchars($row['problem']).'" data-request_by="'.htmlspecialchars($row['request_by']).'" data-confirm_by="'.$row['confirm_by'].'" data-comment="'.htmlspecialchars($row['comment']).'" data-concern_date_time="'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'" data-parts_code="'.htmlspecialchars($row['parts_code']).'" data-quantity="'.$row['quantity'].'" data-po_date="'.$row['po_date'].'" data-po_no="'.htmlspecialchars($row['po_no']).'" data-no_spare_status="'.$row['no_spare_status'].'" data-date_arrived="'.$row['date_arrived'].'" data-status="'.$row['status'].'" onclick="get_details_no_spare_info(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['pm_concern_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_line']).'</td>';
			echo '<td>'.htmlspecialchars($row['problem']).'</td>';
			echo '<td>'.htmlspecialchars($row['request_by']).'</td>';
			echo '<td>'.$row['confirm_by'].'</td>';
			echo '<td>'.htmlspecialchars($row['comment']).'</td>';
			echo '<td>'.htmlspecialchars($row['parts_code']).'</td>';
			echo '<td>'.$row['quantity'].'</td>';
			if (empty($row['po_date'])) {
				echo '<td></td>';
			} else {
				echo '<td>'.date("Y-m-d", strtotime($row['po_date'])).'</td>';
			}
			echo '<td>'.htmlspecialchars($row['po_no']).'</td>';
			echo '<td>'.$row['no_spare_status'].'</td>';
			if (empty($row['date_arrived'])) {
				echo '<td></td>';
			} else {
				echo '<td>'.date("Y-m-d", strtotime($row['date_arrived'])).'</td>';
			}
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="12" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

if ($method == 'pm_concern_mark_as_read') {
	pm_concern_mark_as_read($_POST['id'], $conn);
}

if ($method == 'save_no_spare_details') {
	$id = $_POST['id'];
	$pm_concern_id = $_POST['pm_concern_id'];
	$po_date = $_POST['po_date'];
	$po_no = custom_trim($_POST['po_no']);
	$date_arrived = $_POST['date_arrived'];

	$is_valid = false;

	if (!empty($po_date)) {
		if (!empty($po_no)) {
			$is_valid = true;
		} else echo 'PO No. Empty';
	} else echo 'PO Date Not Set';

	if ($is_valid == true) {
		$po_date = date_create($po_date);
		$po_date = date_format($po_date,"Y-m-d");
		$po_no = addslashes($po_no);

		$sql = "UPDATE machine_pm_no_spare SET po_date = '$po_date', po_no = '$po_no', date_updated = '$date_updated',";

		if (!empty($date_arrived)) {
			$date_arrived = date_create($date_arrived);
			$date_arrived = date_format($date_arrived,"Y-m-d");
			$sql = $sql . " no_spare_status = 'CLOSE', date_arrived = '$date_arrived'";
		} else {
			$sql = $sql . " no_spare_status = 'OPEN'";
		}

		$sql = $sql . " WHERE pm_concern_id = '$pm_concern_id' AND id = '$id'";

		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		echo 'success';
	}
}

// Count
if ($method == 'count_no_spare_history') {
	$concern_date_from = $_POST['concern_date_from'];
	if (!empty($concern_date_from)) {
		$concern_date_from = date_create($concern_date_from);
		$concern_date_from = date_format($concern_date_from,"Y-m-d H:i:s");
	}
	$concern_date_to = $_POST['concern_date_to'];
	if (!empty($concern_date_to)) {
		$concern_date_to = date_create($concern_date_to);
		$concern_date_to = date_format($concern_date_to,"Y-m-d H:i:s");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$car_model = addslashes($_POST['car_model']);
	$pm_concern_id = $_POST['pm_concern_id'];
	$pm_concern_status = $_POST['pm_concern_status'];

	$sql = "SELECT count(id) AS total";

	if ($pm_concern_status == 'Pending') {
		$sql = $sql . " FROM machine_pm_no_spare";
	} else if ($pm_concern_status == 'Done') {
		$sql = $sql . " FROM machine_pm_no_spare_history";
	}

	if (!empty($machine_name) || !empty($car_model) || !empty($pm_concern_id) || (!empty($concern_date_from) && !empty($concern_date_to))) {
		$sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND pm_concern_id LIKE '$pm_concern_id%' AND (concern_date_time >= '$concern_date_from' AND concern_date_time <= '$concern_date_to') AND no_spare_status = 'CLOSE'";
	} else {
		$sql = $sql . " WHERE no_spare_status = 'CLOSE') ";
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
if ($method == 'get_no_spare_history') {
	$id = $_POST['id'];
	$concern_date_from = $_POST['concern_date_from'];
	if (!empty($concern_date_from)) {
		$concern_date_from = date_create($concern_date_from);
		$concern_date_from = date_format($concern_date_from,"Y-m-d H:i:s");
	}
	$concern_date_to = $_POST['concern_date_to'];
	if (!empty($concern_date_to)) {
		$concern_date_to = date_create($concern_date_to);
		$concern_date_to = date_format($concern_date_to,"Y-m-d H:i:s");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$car_model = addslashes($_POST['car_model']);
	$pm_concern_id = $_POST['pm_concern_id'];
	$pm_concern_status = $_POST['pm_concern_status'];
	$c = $_POST['c'];
	
	$sql = "SELECT id, pm_concern_id, machine_line, machine_name, car_model, trd_no, `ns-iv_no`, problem, request_by, confirm_by, comment, concern_date_time, parts_code, quantity, po_date, po_no, no_spare_status, date_arrived, status, date_updated";

	if ($pm_concern_status == 'Pending') {
		$sql = $sql . " FROM machine_pm_no_spare";
	} else if ($pm_concern_status == 'Done') {
		$sql = $sql . " FROM machine_pm_no_spare_history";
	}

	if (empty($id)) {
		if (!empty($machine_name) || !empty($car_model) || !empty($pm_concern_id) || (!empty($concern_date_from) && !empty($concern_date_to))) {
			$sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND pm_concern_id LIKE '$pm_concern_id%' AND (concern_date_time >= '$concern_date_from' AND concern_date_time <= '$concern_date_to')";
		}
	} else {
		$sql = $sql . " WHERE id < '$id'";
		if (!empty($machine_name) || !empty($car_model) || !empty($pm_concern_id) || (!empty($concern_date_from) && !empty($concern_date_to))) {
			$sql = $sql . " AND (machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND pm_concern_id LIKE '$pm_concern_id%' AND (concern_date_time >= '$concern_date_from' AND concern_date_time <= '$concern_date_to'))";
		}
	}

	$sql = $sql . " AND no_spare_status = 'CLOSE' ORDER BY id DESC LIMIT 25";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr id="'.$row['id'].'">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '<td>'.$row['pm_concern_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_line']).'</td>';
			echo '<td>'.htmlspecialchars($row['problem']).'</td>';
			echo '<td>'.htmlspecialchars($row['request_by']).'</td>';
			echo '<td>'.$row['confirm_by'].'</td>';
			echo '<td>'.htmlspecialchars($row['comment']).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'</td>';
			echo '<td>'.htmlspecialchars($row['parts_code']).'</td>';
			echo '<td>'.$row['quantity'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['po_date'])).'</td>';
			echo '<td>'.htmlspecialchars($row['po_no']).'</td>';
			echo '<td>'.$row['no_spare_status'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['date_arrived'])).'</td>';
			echo '<td>'.$row['status'].'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="16" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

$conn = null;
?>