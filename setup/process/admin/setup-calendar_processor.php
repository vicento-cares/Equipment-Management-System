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

function update_notif_count_setup_activities($interface, $setup_activity_status, $conn) {
	$sql = "UPDATE `notif_setup_activities`";
	if ($setup_activity_status == 'For Confirmation') {
		$sql = $sql . " SET `new_act_sched`= new_act_sched + 1";
	} else if ($setup_activity_status == 'Accepted') {
		$sql = $sql . " SET `accepted_act_sched`= accepted_act_sched + 1";
	} else if ($setup_activity_status == 'Declined') {
		$sql = $sql . " SET `declined_act_sched`= declined_act_sched + 1";
	}
	$sql = $sql . " WHERE interface = '$interface'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

function setup_activities_mark_as_read($id, $setup_activity_status, $interface, $conn) {
	$sql = "UPDATE `machine_setup_activities`";
	if ($interface == 'PUBLIC-PAGE') {
		$sql = $sql . " SET `is_read`= 1";
	} else if ($interface == 'ADMIN-SETUP') {
		$sql = $sql . " SET `is_read_setup`= 1";
	}
	$sql = $sql . " WHERE `id`= '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$sql = "UPDATE `notif_setup_activities`";
	if ($setup_activity_status == 'For Confirmation') {
		$sql = $sql . " SET `new_act_sched` = CASE WHEN new_act_sched > 0 THEN new_act_sched - 1 END";
	} else if ($setup_activity_status == 'Accepted') {
		$sql = $sql . " SET `accepted_act_sched` = CASE WHEN accepted_act_sched > 0 THEN accepted_act_sched - 1 END";
	} else if ($setup_activity_status == 'Declined') {
		$sql = $sql . " SET `declined_act_sched` = CASE WHEN declined_act_sched > 0 THEN declined_act_sched - 1 END";
	}
	$sql = $sql . " WHERE interface = '$interface'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

if ($method == 'get_setup_activities_day') {
	$activity_date = date_create($date_updated);
	$activity_date = date_format($activity_date,"Y-m-d");
	$data = '';

	$sql = "SELECT `activity_details` FROM `machine_setup_activities` WHERE `activity_date`= '$activity_date' AND `activity_status`!= 'Declined' AND `activity_status`!= 'For Confirmation' ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$data = $data . '<tr><td class="text-left">'.nl2br(htmlspecialchars($row['activity_details'])).'</td></tr>';
		}
	} else {
		$data = $data . '<tr><td colspan="1" style="text-align:center; color:red;">No Scheduled Activity Found</td></tr>';
	}

	$response_arr = array(
		'activity_date' => $activity_date,
		'data' => $data
	);

	echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'get_previous_setup_activities') {
	$activity_date = $_POST['activity_date'];
	$activity_date = date_create($activity_date);
	$activity_date = date_format($activity_date,"Y-m-d");
	$activity_date = date('Y-m-d', strtotime('-1 day', strtotime($activity_date)));
	$data = '';

	$sql = "SELECT `activity_details` FROM `machine_setup_activities` WHERE `activity_date`= '$activity_date' AND `activity_status`!= 'Declined' AND `activity_status`!= 'For Confirmation' ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$data = $data . '<tr><td class="text-left">'.nl2br(htmlspecialchars($row['activity_details'])).'</td></tr>';
		}
	} else {
		$data = $data . '<tr><td colspan="1" style="text-align:center; color:red;">No Scheduled Activity Found</td></tr>';
	}

	$response_arr = array(
		'activity_date' => $activity_date,
		'data' => $data
	);

	echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'get_next_setup_activities') {
	$activity_date = $_POST['activity_date'];
	$activity_date = date_create($activity_date);
	$activity_date = date_format($activity_date,"Y-m-d");
	$activity_date = date('Y-m-d', strtotime('+1 day', strtotime($activity_date)));
	$data = '';

	$sql = "SELECT `activity_details` FROM `machine_setup_activities` WHERE `activity_date`= '$activity_date' AND `activity_status`!= 'Declined' AND `activity_status`!= 'For Confirmation' ORDER BY id ASC";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$data = $data . '<tr><td class="text-left">'.nl2br(htmlspecialchars($row['activity_details'])).'</td></tr>';
		}
	} else {
		$data = $data . '<tr><td colspan="1" style="text-align:center; color:red;">No Scheduled Activity Found</td></tr>';
	}

	$response_arr = array(
		'activity_date' => $activity_date,
		'data' => $data
	);

	echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'get_setup_activities_years') {
	$year_start  = 2020;
    $year_end = date('Y'); // current Year
    $selected_year = date('Y'); // selected option of year

    for ($i_year = $year_start; $i_year <= $year_end; $i_year++) {
        $selected = $selected_year == $i_year ? ' selected' : '';
        echo '<option value="'.$i_year.'"'.$selected.'>'.$i_year.'</option>'."\n";
    }
}

if ($method == 'get_setup_activities_months') {
	$selected_month = date('m'); //current month
    for ($i_month = 1; $i_month <= 12; $i_month++) { 
        $selected = $selected_month == $i_month ? ' selected' : '';
        echo '<option value="'.$i_month.'"'.$selected.'>'. date('F', mktime(0,0,0,$i_month)).'</option>'."\n";
    }
}

// Count
if ($method == 'count_setup_activities') {
	$setup_activity_year = $_POST['setup_activity_year'];
	$setup_activity_month = sprintf("%02d", $_POST['setup_activity_month']);
	$activity_date = $setup_activity_year . "-" . $setup_activity_month;

	$sql = "SELECT count(id) AS total FROM `machine_setup_activities` WHERE `activity_date` LIKE '$activity_date%' AND `activity_status`= 'Accepted'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Read / Load
if ($method == 'get_setup_activities') {
	$setup_activity_year = $_POST['setup_activity_year'];
	$setup_activity_month = sprintf("%02d", $_POST['setup_activity_month']);
	$activity_date = $setup_activity_year . "-" . $setup_activity_month;

	$row_class_arr = array('modal-trigger', 'modal-trigger bg-lime');
	$row_class = $row_class_arr[0];
	$date_today = date("Y-m-d");

	$sql = "SELECT `id`, `activity_details`, `activity_status`, `activity_date` FROM `machine_setup_activities` WHERE `activity_date` LIKE '$activity_date%' AND `activity_status`= 'Accepted' ORDER BY `activity_date` ASC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			if ($date_today == $row['activity_date']) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="'.$row['id'].'" data-toggle="modal" data-target="#ActSchedInfoModal" data-id="'.$row['id'].'" data-activity_details="'.htmlspecialchars($row['activity_details']).'" data-activity_date="'.$row['activity_date'].'" onclick="get_details(this)">';
			echo '<td>'.date("D M d, Y", strtotime($row['activity_date'])).'</td>';
			echo '<td class="text-left">'.nl2br(htmlspecialchars($row['activity_details'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="2" style="text-align:center; color:red;">No Scheduled Activity Found</td>';
		echo '</tr>';
	}
}

if ($method == 'setup_activities_mark_as_read') {
	setup_activities_mark_as_read($_POST['id'], $_POST['activity_status'], 'ADMIN-SETUP', $conn);
}
if ($method == 'setup_activities_mark_as_read_public') {
	setup_activities_mark_as_read($_POST['id'], $_POST['activity_status'], 'PUBLIC-PAGE', $conn);
}

if ($method == 'save_act_sched') {
	$activity_date = $_POST['activity_date'];
	$activity_details = addslashes($_POST['activity_details']);

	$is_valid = false;
	if (!empty($activity_date)) {
		if (!empty($activity_details)) {
			$is_valid = true;
		} else echo 'Activity Details Empty';
	} else echo 'Activity Date Not Set';

	if ($is_valid == true) {
		$activity_date = date_create($activity_date);
		$activity_date = date_format($activity_date,"Y-m-d");
		$start_date_time = $activity_date . " 00:00:00";
		$end_date_time = $activity_date . " 23:59:59";

		$sql = "INSERT INTO `machine_setup_activities` (`activity_details`, `activity_status`, `activity_date`, `start_date_time`, `end_date_time`, `date_updated`) VALUES ('$activity_details', 'Accepted', '$activity_date', '$start_date_time', '$end_date_time', '$date_updated')";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		echo 'success';
	}
}

if ($method == 'update_act_sched') {
	$id = $_POST['id'];
	$activity_date = $_POST['activity_date'];
	$activity_details = addslashes($_POST['activity_details']);

	$is_valid = false;
	if (!empty($activity_date)) {
		if (!empty($activity_details)) {
			$is_valid = true;
		} else echo 'Activity Details Empty';
	} else echo 'Activity Date Not Set';

	if ($is_valid == true) {
		$activity_date = date_create($activity_date);
		$activity_date = date_format($activity_date,"Y-m-d");
		$start_date_time = $activity_date . " 00:00:00";
		$end_date_time = $activity_date . " 23:59:59";

		$sql = "UPDATE `machine_setup_activities` SET `activity_details`= '$activity_details', `activity_date`= '$activity_date', `start_date_time`= '$start_date_time', `end_date_time`= '$end_date_time', `date_updated`= '$date_updated' WHERE `id`= '$id'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		echo 'success';
	}
}

if ($method == 'delete_act_sched') {
	$id = $_POST['id'];
	
	$sql = "DELETE FROM `machine_setup_activities` WHERE id = '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	echo 'success';
}

if ($method == 'send_req_act_sched') {
	$activity_date = $_POST['activity_date'];
	$car_model = custom_trim($_POST['car_model']);
	$requestor_name = custom_trim($_POST['requestor_name']);
	$activity_details = $_POST['activity_details'];

	$is_valid = false;
	if (!empty($activity_date)) {
		if (!empty($car_model)) {
			if (!empty($requestor_name)) {
				if (!empty($activity_details)) {
					$is_valid = true;
				} else echo 'Activity Details Empty';
			} else echo 'Requestor Name Empty';
		} else echo 'Car Model Empty';
	} else echo 'Activity Date Not Set';

	if ($is_valid == true) {
		$car_model = addslashes($car_model);
		$requestor_name = addslashes($requestor_name);
		$activity_details = addslashes($activity_details);
		$activity_date = date_create($activity_date);
		$activity_date = date_format($activity_date,"Y-m-d");
		$start_date_time = $activity_date . " 00:00:00";
		$end_date_time = $activity_date . " 23:59:59";

		$sql = "INSERT INTO `machine_setup_activities` (`car_model`, `requestor_name`, `activity_details`, `activity_status`, `activity_date`, `start_date_time`, `end_date_time`, `date_updated`) VALUES ('$car_model', '$requestor_name', '$activity_details', 'For Confirmation', '$activity_date', '$start_date_time', '$end_date_time', '$date_updated')";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		update_notif_count_setup_activities('ADMIN-SETUP', 'For Confirmation', $conn);
		echo 'success';
	}
}

// Count
if ($method == 'count_requested_setup_activities') {
	$sql = "SELECT count(id) AS total FROM `machine_setup_activities` WHERE `car_model`!= '' AND `requestor_name`!= '' AND `activity_status`= 'For Confirmation'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Read / Load
if ($method == 'get_requested_setup_activities') {
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-lime');
	$row_class = $row_class_arr[0];
	$c = 0;

	$sql = "SELECT `id`, `car_model`, `requestor_name`, `activity_details`, `activity_status`, `activity_date`, `date_updated`, `is_read_setup` FROM `machine_setup_activities` WHERE `car_model`!= '' AND `requestor_name`!= '' AND `activity_status`= 'For Confirmation' ORDER BY `id` DESC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if (intval($row['is_read_setup']) == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="'.$row['id'].'" data-toggle="modal" data-target="#ReqActSchedInfoModal" data-id="'.$row['id'].'" data-car_model="'.htmlspecialchars($row['car_model']).'" data-requestor_name="'.htmlspecialchars($row['requestor_name']).'" data-activity_details="'.htmlspecialchars($row['activity_details']).'" data-activity_date="'.$row['activity_date'].'" data-activity_status="'.$row['activity_status'].'" onclick="get_details_req(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.date("D M d, Y", strtotime($row['activity_date'])).'</td>';
			echo '<td>'.htmlspecialchars($row['car_model']).'</td>';
			echo '<td>'.htmlspecialchars($row['requestor_name']).'</td>';
			echo '<td class="text-left">'.nl2br(htmlspecialchars($row['activity_details'])).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="6" style="text-align:center; color:red;">No Scheduled Activity Found</td>';
		echo '</tr>';
	}
}

// Read / Load
if ($method == 'get_requested_setup_activities_public') {
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-lime');
	$row_class = $row_class_arr[0];
	$c = 0;

	$sql = "SELECT `id`, `car_model`, `requestor_name`, `activity_details`, `activity_status`, `activity_date`, `date_updated`, `is_read` FROM `machine_setup_activities` WHERE `car_model`!= '' AND `requestor_name`!= '' AND `activity_status`= 'For Confirmation' ORDER BY `id` DESC";

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
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="'.$row['id'].'" data-toggle="modal" data-target="#ReqActSchedInfoModal" data-id="'.$row['id'].'" data-car_model="'.htmlspecialchars($row['car_model']).'" data-requestor_name="'.htmlspecialchars($row['requestor_name']).'" data-activity_details="'.htmlspecialchars($row['activity_details']).'" data-activity_date="'.$row['activity_date'].'" data-activity_status="'.$row['activity_status'].'"  onclick="get_details_req(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.date("D M d, Y", strtotime($row['activity_date'])).'</td>';
			echo '<td>'.htmlspecialchars($row['car_model']).'</td>';
			echo '<td>'.htmlspecialchars($row['requestor_name']).'</td>';
			echo '<td class="text-left">'.nl2br(htmlspecialchars($row['activity_details'])).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="6" style="text-align:center; color:red;">No Scheduled Activity Found</td>';
		echo '</tr>';
	}
}

// Count
if ($method == 'count_recent_setup_activities_history') {
	$sql = "SELECT count(id) AS total FROM `machine_setup_activities` WHERE `car_model`!= '' AND `requestor_name`!= '' AND (`activity_status`= 'Accepted' OR `activity_status`= 'Declined')";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Read / Load
if ($method == 'get_recent_setup_activities_history') {
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-danger', 'modal-trigger bg-success');
	$row_class = $row_class_arr[0];
	$c = 0;

	$sql = "SELECT `id`, `car_model`, `requestor_name`, `activity_details`, `activity_status`, `activity_date`, `date_updated`, `decline_reason`, `is_read_setup` FROM `machine_setup_activities` WHERE `car_model`!= '' AND `requestor_name`!= '' AND (`activity_status`= 'Accepted' OR `activity_status`= 'Declined') ORDER BY `id` DESC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($row['activity_status'] == 'Accepted') {
				$row_class = $row_class_arr[2];
			} else if ($row['activity_status'] == 'Declined') {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="'.$row['id'].'" data-toggle="modal" data-target="#RecentActSchedHistoryInfoModal" data-id="'.$row['id'].'" data-car_model="'.htmlspecialchars($row['car_model']).'" data-requestor_name="'.htmlspecialchars($row['requestor_name']).'" data-activity_details="'.htmlspecialchars($row['activity_details']).'" data-activity_date="'.$row['activity_date'].'" data-activity_status="'.$row['activity_status'].'" data-decline_reason="'.htmlspecialchars($row['decline_reason']).'" onclick="get_details_history(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.date("D M d, Y", strtotime($row['activity_date'])).'</td>';
			echo '<td>'.htmlspecialchars($row['car_model']).'</td>';
			echo '<td>'.htmlspecialchars($row['requestor_name']).'</td>';
			echo '<td class="text-left">'.nl2br(htmlspecialchars($row['activity_details'])).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="6" style="text-align:center; color:red;">No Scheduled Activity Found</td>';
		echo '</tr>';
	}
}

if ($method == 'accept_activity_schedule') {
	$id = $_POST['id'];
	$sql = "UPDATE `machine_setup_activities` SET `activity_status`= 'Accepted' WHERE id = '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	update_notif_count_setup_activities('PUBLIC-PAGE', 'Accepted', $conn);
	echo 'success';
}

if ($method == 'decline_activity_schedule') {
	$id = $_POST['id'];
	$decline_reason = addslashes(custom_trim($_POST['decline_reason']));
	$sql = "UPDATE `machine_setup_activities` SET `activity_status`= 'Declined', `decline_reason`= '$decline_reason' WHERE id = '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	update_notif_count_setup_activities('PUBLIC-PAGE', 'Declined', $conn);
	echo 'success';
}

$conn = null;
?>