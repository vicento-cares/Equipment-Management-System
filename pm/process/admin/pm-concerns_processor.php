<?php 
// Processor
date_default_timezone_set('Asia/Manila');
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();
require('../db/conn.php');
require('../lib/validate.php');
require('../lib/main.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');

function update_notif_count_pm_concerns($interface, $pm_concern_status, $conn) {
	$sql = "UPDATE `notif_pm_concerns`";
	if ($pm_concern_status == 'New') {
		$sql = $sql . " SET `new_pm_concerns`= new_pm_concerns + 1";
	} else if ($pm_concern_status == 'Done') {
		$sql = $sql . " SET `done_pm_concerns`= done_pm_concerns + 1";
	} else if ($pm_concern_status == 'Pending') {
		$sql = $sql . " SET `pending_pm_concerns`= pending_pm_concerns + 1";
	}
	$sql = $sql . " WHERE interface = '$interface'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

function update_notif_count_no_spare($conn) {
	$sql = "UPDATE `notif_pm_no_spare` SET `new_pm_concerns`= new_pm_concerns + 1 WHERE interface = 'ADMIN-SP'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

function pm_concern_mark_as_read($id, $pm_concern_status, $interface, $conn) {
	$sql = "UPDATE `machine_pm_concerns`";
	if ($interface == 'PUBLIC-PAGE') {
		$sql = $sql . " SET `is_read`= 1";
	} else if ($interface == 'ADMIN-PM') {
		$sql = $sql . " SET `is_read_pm`= 1";
	}
	$sql = $sql . " WHERE `id`= '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$sql = "UPDATE `notif_pm_concerns`";
	if ($pm_concern_status == 'New') {
		$sql = $sql . " SET `new_pm_concerns` = CASE WHEN new_pm_concerns > 0 THEN new_pm_concerns - 1 END";
	} else if ($pm_concern_status == 'Done') {
		$sql = $sql . " SET `done_pm_concerns` = CASE WHEN done_pm_concerns > 0 THEN done_pm_concerns - 1 END";
	} else if ($pm_concern_status == 'Pending') {
		$sql = $sql . " SET `pending_pm_concerns` = CASE WHEN pending_pm_concerns > 0 THEN pending_pm_concerns - 1 END";
	}
	$sql = $sql . " WHERE interface = '$interface'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

function check_all_no_spare_status($pm_concern_id, $conn) {
	$total_close = 0;
	$no_of_parts = 0;

	$sql = "SELECT count(id) AS total FROM `machine_pm_no_spare` WHERE `pm_concern_id`= '$pm_concern_id' AND `no_spare_status`= 'CLOSE'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$total_close = $row['total'];
		}
	}

	$sql = "SELECT `no_of_parts` FROM `machine_pm_concerns` WHERE `pm_concern_id`= '$pm_concern_id'";
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
if ($method == 'count_pm_concerns') {
	$sql = "SELECT count(id) AS total FROM `machine_pm_concerns` WHERE `comment`= '' AND `confirm_by`= ''";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Read / Load
if ($method == 'get_pm_concerns') {
	$c = 0;
	$status = 'New';
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-orange');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `confirm_by`, `comment`, `concern_date_time`, `status`, `is_read_pm` FROM `machine_pm_concerns` WHERE `status`= '$status'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if (intval($row['is_read_pm']) == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="N_'.$row['id'].'" data-toggle="modal" data-target="#PmConcernInfoModal" data-id="'.$row['id'].'" data-pm_concern_id="'.$row['pm_concern_id'].'" data-machine_line="'.htmlspecialchars($row['machine_line']).'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-car-model="'.htmlspecialchars($row['car_model']).'" data-trd_no="'.$row['trd_no'].'" data-ns-iv_no="'.$row['ns-iv_no'].'" data-problem="'.htmlspecialchars($row['problem']).'" data-request_by="'.htmlspecialchars($row['request_by']).'" data-confirm_by="'.$row['confirm_by'].'" data-comment="'.htmlspecialchars($row['comment']).'" data-concern_date_time="'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'" data-status="'.$row['status'].'" onclick="get_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['pm_concern_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_line']).'</td>';
			echo '<td>'.htmlspecialchars($row['problem']).'</td>';
			echo '<td>'.htmlspecialchars($row['request_by']).'</td>';
			echo '<td>'.$row['confirm_by'].'</td>';
			echo '<td>'.htmlspecialchars($row['comment']).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Read / Load
if ($method == 'get_pm_concerns_public') {
	$c = 0;
	$status = 'New';
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-orange');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `confirm_by`, `comment`, `concern_date_time`, `status`, `is_read` FROM `machine_pm_concerns` WHERE `status`= '$status'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if (intval($row['is_read']) == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="N_'.$row['id'].'" data-toggle="modal" data-target="#PmConcernInfoModal" data-id="'.$row['id'].'" data-pm_concern_id="'.$row['pm_concern_id'].'" data-machine_line="'.htmlspecialchars($row['machine_line']).'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-car-model="'.htmlspecialchars($row['car_model']).'" data-trd_no="'.$row['trd_no'].'" data-ns-iv_no="'.$row['ns-iv_no'].'" data-problem="'.htmlspecialchars($row['problem']).'" data-request_by="'.htmlspecialchars($row['request_by']).'" data-confirm_by="'.$row['confirm_by'].'" data-comment="'.htmlspecialchars($row['comment']).'" data-concern_date_time="'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'" data-status="'.$row['status'].'" onclick="get_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['pm_concern_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_line']).'</td>';
			echo '<td>'.htmlspecialchars($row['problem']).'</td>';
			echo '<td>'.htmlspecialchars($row['request_by']).'</td>';
			echo '<td>'.$row['confirm_by'].'</td>';
			echo '<td>'.htmlspecialchars($row['comment']).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

if ($method == 'pm_concern_mark_as_read') {
	pm_concern_mark_as_read($_POST['id'], $_POST['status'], 'ADMIN-PM', $conn);
}
if ($method == 'pm_concern_mark_as_read_public') {
	pm_concern_mark_as_read($_POST['id'], $_POST['status'], 'PUBLIC-PAGE', $conn);
}

// Create / Insert
if ($method == 'send_pm_concern') {
	$machine_line = '';
	$machine_name = custom_trim($_POST['machine_name']);
	$car_model = custom_trim($_POST['car_model']);
	$trd_no = custom_trim($_POST['trd_no']);
	$ns_iv_no = custom_trim($_POST['ns_iv_no']);
	$request_by = custom_trim($_POST['request_by']);
	$problem = custom_trim($_POST['problem']);

	$is_valid = false;
	$machine_info = get_machine_details($machine_name, $conn);
	if (!empty($machine_name)) {
		if (!empty($car_model)) {
			if ($machine_info['trd'] == 1 && empty($trd_no)) {
				echo 'TRD No. Empty';
			} else if ($machine_info['ns_iv'] == 1 && empty($ns_iv_no)) {
				echo 'NS-IV No. Empty';
			} else if (!empty($request_by)) {
				if (!empty($problem)) {
					$is_valid = true;
				} else echo 'Problem Empty';
			} else echo 'Request By Empty';
		} else echo 'Car Model Empty';
	} else echo 'Machine Name Empty';

	if ($is_valid == true) {
		$pm_concern_id = date("ymdh");
		$rand = substr(md5(microtime()),rand(0,26),5);
		$pm_concern_id = 'PM-C:'.$pm_concern_id;
		$pm_concern_id = $pm_concern_id.''.$rand;

		if ($machine_info['trd'] == 1) {
			$machine_line = $car_model . '/' . $trd_no . '/';
		} else if ($machine_info['ns_iv'] == 1) {
			$machine_line = $car_model . '/' . $ns_iv_no . '/';
		} else {
			$machine_line = $car_model . '/' . $machine_name . '/';
		}
		
		$machine_line = addslashes($machine_line);
		$machine_name = addslashes($machine_name);
		$car_model = addslashes($car_model);
		$request_by = addslashes($request_by);
		$problem = addslashes($problem);

		$sql = "INSERT INTO `machine_pm_concerns` (`pm_concern_id`, `machine_line`, `machine_name`,  `car_model`, `problem`, `request_by`, `concern_date_time`, `status`) VALUES ('$pm_concern_id', '$machine_line', '$machine_name', '$car_model', '$problem', '$request_by', '$date_updated', 'New')";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		update_notif_count_pm_concerns('ADMIN-PM', 'New', $conn);
		echo 'success';
	}
}

if ($method == 'add_no_spare_parts') {
	$pm_concern_id = $_POST['pm_concern_id'];
	$parts_code = custom_trim($_POST['parts_code']);
	$quantity = intval($_POST['quantity']);

	$is_valid = false;

	if (!empty($parts_code)) {
		if (!empty($quantity)) {
			$is_valid = true;
		} else echo 'Quantity Empty';
	} else echo 'Parts Code Empty';

	if ($is_valid == true) {
		$pm_concern_info = array();
		$no_of_parts = 0;

		$sql = "SELECT count(id) AS total FROM `machine_pm_no_spare` WHERE `pm_concern_id`= '$pm_concern_id'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		if ($stmt -> rowCount() > 0) {
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
				$no_of_parts = intval($row['total']);
			}
		}

		if ($no_of_parts >= 6) {
			echo 'Max Spare Parts Reached';
		} else {
			$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `confirm_by`, `confirm_by_username`, `comment`, `concern_date_time`, `status` FROM `machine_pm_concerns` WHERE `pm_concern_id`= '$pm_concern_id'";
			$stmt = $conn -> prepare($sql);
			$stmt -> execute();
			foreach($stmt -> fetchAll() as $row) {
				$pm_concern_info = array(
					'machine_line' => $row['machine_line'],
					'machine_name' => $row['machine_name'],
					'car_model' => $row['car_model'],
					'trd_no' => $row['trd_no'],
					'ns-iv_no' => $row['ns-iv_no'],
					'problem' => $row['problem'],
					'request_by' => $row['request_by'],
					'request_by_id_no' => $row['request_by_id_no'],
					'concern_date_time' => $row['concern_date_time']
				);
			}

			$machine_line = addslashes($pm_concern_info['machine_line']);
			$machine_name = addslashes($pm_concern_info['machine_name']);
			$car_model = addslashes($pm_concern_info['car_model']);
			$trd_no = addslashes($pm_concern_info['trd_no']);
			$ns_iv_no = addslashes($pm_concern_info['ns-iv_no']);
			$problem = addslashes($pm_concern_info['problem']);
			$request_by = addslashes($pm_concern_info['request_by']);
			$request_by_id_no = addslashes($pm_concern_info['request_by_id_no']);
			$concern_date_time = date_create($pm_concern_info['concern_date_time']);
			$concern_date_time = date_format($concern_date_time,"Y-m-d H:i:s");
			$confirm_by = $_COOKIE['pm_name'];
			$confirm_by_username = $_SESSION['pm_username'];
			$comment = 'NO SPARE';
			$status = 'Pending';

			$sql = "INSERT INTO `machine_pm_no_spare` (`pm_concern_id`, `machine_line`, `machine_name`,  `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `concern_date_time`, `confirm_by`, `confirm_by_username`, `comment`, `parts_code`, `quantity`, `status`) VALUES ('$pm_concern_id', '$machine_line', '$machine_name', '$car_model', '$trd_no', '$ns_iv_no', '$problem', '$request_by', '$request_by_id_no', '$concern_date_time', '$confirm_by', '$confirm_by_username', '$comment', '$parts_code', '$quantity', '$status')";
			$stmt = $conn -> prepare($sql);
			$stmt -> execute();

			echo 'success';
		}
	}
}

if ($method == 'display_no_spare_parts') {
	$pm_concern_id = $_POST['pm_concern_id'];
	$c = 0;
	$sql = "SELECT `id`, `pm_concern_id`, `parts_code`, `quantity` FROM `machine_pm_no_spare` WHERE `pm_concern_id`= '$pm_concern_id' ORDER BY `id` DESC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr id="DNS_'.$row['id'].'">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.htmlspecialchars($row['parts_code']).'</td>';
			echo '<td>'.htmlspecialchars($row['quantity']).'</td>';
			echo '<td><center><i class="fas fa-trash" style="cursor:pointer;" data-id="'.$row['id'].'" data-pm_concern_id="'.$row['pm_concern_id'].'" onclick="delete_no_spare_parts(this)"></i></center></td>';
			echo '</tr>';
		}
	}
}

if ($method == 'delete_no_spare_parts') {
	$id = $_POST['id'];
	$pm_concern_id = $_POST['pm_concern_id'];
	$sql = "DELETE FROM `machine_pm_no_spare` WHERE `pm_concern_id`= '$pm_concern_id' AND `id`= '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	echo "success";
}

if ($method == 'set_pending_no_spare_pm_concern') {
	$pm_concern_id = $_POST['pm_concern_id'];
	$comment = 'NO SPARE';
	$confirm_by = $_COOKIE['pm_name'];
	$confirm_by_username = $_SESSION['pm_username'];
	$no_of_parts = 0;

	$sql = "SELECT count(id) AS total FROM `machine_pm_no_spare` WHERE `pm_concern_id`= '$pm_concern_id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$no_of_parts = intval($row['total']);
		}
	}

	$sql = "UPDATE `machine_pm_concerns` SET `comment`= '$comment', `confirm_by`= '$confirm_by', `confirm_by_username`= '$confirm_by_username', `no_spare`= 1, `no_of_parts`= '$no_of_parts', `status`= 'Pending', `is_read`= 0 WHERE `pm_concern_id`= '$pm_concern_id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	update_notif_count_pm_concerns('PUBLIC-PAGE', 'Pending', $conn);
	update_notif_count_no_spare($conn);
	echo 'success';
}

if ($method == 'set_done_pm_concern') {
	$id = $_POST['id'];
	$pm_concern_id = $_POST['pm_concern_id'];
	$comment = 'DONE';
	$confirm_by = $_COOKIE['pm_name'];
	$confirm_by_username = $_SESSION['pm_username'];

	$no_spare = 0;

	$sql = "SELECT `no_spare` FROM `machine_pm_concerns` WHERE `id`= '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$no_spare = intval($row['no_spare']);
		}
	}

	$sql = "INSERT INTO `machine_pm_concerns_history`(`pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `concern_date_time`, `confirm_by`, `confirm_by_username`, `comment`, `no_spare`, `no_of_parts`, `status`, `is_read`, `is_read_pm`, `is_read_sp`)
		SELECT `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `concern_date_time`, `confirm_by`, `confirm_by_username`, `comment`, `no_spare`, `no_of_parts`, `status`, `is_read`, `is_read_pm`, `is_read_sp` FROM `machine_pm_concerns`
		WHERE `id`= '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$sql = "UPDATE `machine_pm_concerns_history` SET `comment`= '$comment', `confirm_by`= '$confirm_by', `confirm_by_username`= '$confirm_by_username', `status`= 'Done', `is_read`= 0 WHERE `pm_concern_id`= '$pm_concern_id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$sql = "DELETE FROM `machine_pm_concerns` WHERE `id`= '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	if ($no_spare == 1) {

		$sql = "INSERT INTO `machine_pm_no_spare_history`(`pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `concern_date_time`, `confirm_by`, `confirm_by_username`, `comment`, `parts_code`, `quantity`, `po_date`, `po_no`, `no_spare_status`, `date_arrived`, `status`)
		SELECT `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `request_by_id_no`, `concern_date_time`, `confirm_by`, `confirm_by_username`, `comment`, `parts_code`, `quantity`, `po_date`, `po_no`, `no_spare_status`, `date_arrived`, `status` FROM `machine_pm_no_spare`
		WHERE `pm_concern_id`= '$pm_concern_id'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		$sql = "UPDATE `machine_pm_no_spare_history` SET `comment`= '$comment', `confirm_by`= '$confirm_by', `confirm_by_username`= '$confirm_by_username', `status`= 'Done' WHERE `pm_concern_id`= '$pm_concern_id'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		$sql = "DELETE FROM `machine_pm_no_spare` WHERE `pm_concern_id`= '$pm_concern_id'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

	}

	update_notif_count_pm_concerns('PUBLIC-PAGE', 'Done', $conn);
	echo 'success';
}

if ($method == 'set_pending_pm_concern') {
	$id = $_POST['id'];
	$comment = addslashes(custom_trim($_POST['comment']));
	$confirm_by = $_COOKIE['pm_name'];
	$confirm_by_username = $_SESSION['pm_username'];
	$sql = "UPDATE `machine_pm_concerns` SET `comment`= '$comment', `confirm_by`= '$confirm_by', `confirm_by_username`= '$confirm_by_username', `status`= 'Pending', `is_read`= 0 WHERE `id`= '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	update_notif_count_pm_concerns('PUBLIC-PAGE', 'Pending', $conn);
	echo 'success';
}

// Count
if ($method == 'count_pm_concerns_history') {
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

	$sql = "SELECT count(id) AS total FROM `machine_pm_concerns_history`";

	if (!empty($machine_name) || !empty($car_model) || !empty($pm_concern_id) || (!empty($concern_date_from) && !empty($concern_date_to))) {
		$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `car_model` LIKE '$car_model%' AND `pm_concern_id` LIKE '$pm_concern_id%' AND (concern_date_time >= '$concern_date_from' AND concern_date_time <= '$concern_date_to') AND `status`= 'Done'";
	} else {
		$sql = $sql . " WHERE `status`= 'Done'";
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
if ($method == 'get_pm_concerns_history') {
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
	$c = $_POST['c'];
	
	$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `confirm_by`, `comment`, `concern_date_time`, `no_of_parts` FROM `machine_pm_concerns_history`";

	if (empty($id)) {
		if (!empty($machine_name) || !empty($car_model) || !empty($pm_concern_id) || (!empty($concern_date_from) && !empty($concern_date_to))) {
			$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `car_model` LIKE '$car_model%' AND `pm_concern_id` LIKE '$pm_concern_id%' AND (concern_date_time >= '$concern_date_from' AND concern_date_time <= '$concern_date_to')";
		}
	} else {
		$sql = $sql . " WHERE `id` < '$id'";
		if (!empty($machine_name) || !empty($car_model) || !empty($pm_concern_id) || (!empty($concern_date_from) && !empty($concern_date_to))) {
			$sql = $sql . " AND (`machine_name` LIKE '$machine_name%' AND `car_model` LIKE '$car_model%' AND `pm_concern_id` LIKE '$pm_concern_id%' AND (concern_date_time >= '$concern_date_from' AND concern_date_time <= '$concern_date_to'))";
		}
	}

	$sql = $sql . " AND `status`= 'Done' ORDER BY id DESC LIMIT 25";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr id="'.$row['id'].'">';
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
if ($method == 'get_recent_pm_concerns_pending') {
	$c = 0;
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-warning', 'modal-trigger bg-success');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `confirm_by`, `comment`, `concern_date_time`, `status`, `is_read` FROM `machine_pm_concerns` WHERE `status`= 'Done' OR `status`= 'Pending' ORDER BY `id` DESC LIMIT 25";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if (intval($row['is_read']) == 0) {
				if ($row['status'] == 'Done') {
					$row_class = $row_class_arr[2];
				} else if ($row['status'] == 'Pending') {
					$row_class = $row_class_arr[1];
				}
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="C_'.$row['id'].'" data-toggle="modal" data-target="#RecentPmConcernHistoryInfoModal" data-id="'.$row['id'].'" data-pm_concern_id="'.$row['pm_concern_id'].'" data-machine_line="'.htmlspecialchars($row['machine_line']).'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-car-model="'.htmlspecialchars($row['car_model']).'" data-trd_no="'.$row['trd_no'].'" data-ns-iv_no="'.$row['ns-iv_no'].'" data-problem="'.htmlspecialchars($row['problem']).'" data-request_by="'.htmlspecialchars($row['request_by']).'" data-confirm_by="'.$row['confirm_by'].'" data-comment="'.htmlspecialchars($row['comment']).'" data-concern_date_time="'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'" data-status="'.$row['status'].'" onclick="get_details_history(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['pm_concern_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_line']).'</td>';
			echo '<td>'.htmlspecialchars($row['problem']).'</td>';
			echo '<td>'.htmlspecialchars($row['request_by']).'</td>';
			echo '<td>'.$row['confirm_by'].'</td>';
			echo '<td>'.htmlspecialchars($row['comment']).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Count
if ($method == 'count_pending_pm_concerns') {
	$sql = "SELECT count(id) AS total FROM `machine_pm_concerns` WHERE `comment`!= '' AND `no_spare`= 0 AND `status`= 'Pending'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Read / Load
if ($method == 'get_pending_pm_concerns') {
	$c = 0;
	$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `confirm_by`, `comment`, `concern_date_time`, `status` FROM `machine_pm_concerns` WHERE `comment`!= '' AND `no_spare`= 0 AND `status`= 'Pending'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="P_'.$row['id'].'" data-toggle="modal" data-target="#PendingPmConcernInfoModal" data-id="'.$row['id'].'" data-pm_concern_id="'.$row['pm_concern_id'].'" data-machine_line="'.htmlspecialchars($row['machine_line']).'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-car-model="'.htmlspecialchars($row['car_model']).'" data-trd_no="'.$row['trd_no'].'" data-ns-iv_no="'.$row['ns-iv_no'].'" data-problem="'.htmlspecialchars($row['problem']).'" data-request_by="'.htmlspecialchars($row['request_by']).'" data-confirm_by="'.$row['confirm_by'].'" data-comment="'.htmlspecialchars($row['comment']).'" data-concern_date_time="'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'" data-status="'.$row['status'].'" onclick="get_details_pending_info(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['pm_concern_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_line']).'</td>';
			echo '<td>'.htmlspecialchars($row['problem']).'</td>';
			echo '<td>'.htmlspecialchars($row['request_by']).'</td>';
			echo '<td>'.$row['confirm_by'].'</td>';
			echo '<td>'.htmlspecialchars($row['comment']).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['concern_date_time'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Count
if ($method == 'count_no_spare_pm_concerns') {
	$sql = "SELECT count(id) AS total FROM `machine_pm_concerns` WHERE `comment`= 'NO SPARE' AND `no_spare`= 1 AND `status`= 'Pending'";
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
	$c = 0;
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-success');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `confirm_by`, `comment`, `concern_date_time`, `no_of_parts`, `status` FROM `machine_pm_concerns` WHERE `comment`= 'NO SPARE' AND `no_spare`= 1 AND `status`= 'Pending' ORDER BY `id` DESC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			$no_spare_status = check_all_no_spare_status($row['pm_concern_id'], $conn);
			if ($no_spare_status == 'CLOSE') {
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
if ($method == 'get_no_spare_by_pm_concerns_id_pm') {
	$pm_concern_id = $_POST['pm_concern_id'];
	$c = 0;
	$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `confirm_by`, `comment`, `concern_date_time`, `parts_code`, `quantity`, `po_date`, `po_no`, `no_spare_status`, `date_arrived`, `status` FROM `machine_pm_no_spare` WHERE `pm_concern_id`= '$pm_concern_id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr id="NSI_'.$row['id'].'">';
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

if ($method == 'check_all_no_spare_status') {
	$pm_concern_id = $_POST['pm_concern_id'];
	echo check_all_no_spare_status($pm_concern_id, $conn);
}

$conn = null;
?>