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

// Check Work Order File
function check_work_order_file($work_order_file_info, $conn) {
	$message = "";
	$hasError = 0;
	$file_valid_arr = array(0,0,0,0);

	$mimes = array('application/vnd.ms-excel', 'application/excel', 'application/msexcel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-word', 'application/word', 'application/vnd.msword', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.oasis.opendocument.text');
	
	/*$mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');*/

	/*$mimes = array('application/pdf', 'application/x-pdf', 'application/x-bzpdf', 'application/x-gzpdf', 'applications/vnd.pdf', 'application/acrobat', 'application/x-google-chrome-pdf', 'text/pdf', 'text/x-pdf');*/

	// Check File Mimes
	if (!in_array($work_order_file_info['work_order_filetype'], $mimes)) {
		$hasError = 1;
		$file_valid_arr[0] = 1;
	}
	// Check File Size
	if ($work_order_file_info['work_order_size'] > 25000000) {
		$hasError = 1;
		$file_valid_arr[1] = 1;
	}

	// Check File Exists
	if (file_exists($work_order_file_info['target_file'])) {
		$hasError = 1;
		$file_valid_arr[2] = 1;
	}
	// Check File Information Exists on Database
	$work_order_filename = addslashes($work_order_file_info['work_order_filename']);
	$work_order_filetype = addslashes($work_order_file_info['work_order_filetype']);
	$work_order_url = addslashes($work_order_file_info['work_order_url']);
	$sql = "SELECT id FROM `machine_pm_wo` WHERE `file_name`= '$work_order_filename' AND `file_type`= '$work_order_filetype' AND `file_url`= '$work_order_url'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		$hasError = 1;
		$file_valid_arr[3] = 1;
	}

	// Error Collection and Output
	if ($hasError == 1) {
		if ($file_valid_arr[0] == 1) {
		 	$message = $message . 'Work Order file format not accepted! ';
		}
		if ($file_valid_arr[1] == 1) {
		 	$message = $message . 'Work Order file is too large. ';
		}
		if ($file_valid_arr[2] == 1) {
		 	$message = $message . 'Work Order file exists. ';
		}
		if ($file_valid_arr[3] == 1) {
		 	$message = $message . 'Work Order file information exists on the system. ';
		}
	}

	return $message;
}

// Insert File Information
function save_work_order_info($work_order_file_info, $conn) {
	$wo_id = date("ymdh");
	$rand = substr(md5(microtime()),rand(0,26),5);
	$wo_id = 'PM-WO:'.$wo_id;
	$wo_id = $wo_id.''.$rand;

	$machine_no = addslashes($work_order_file_info['machine_no']);
	$equipment_no = addslashes($work_order_file_info['equipment_no']);
	$process = $work_order_file_info['process'];
	$machine_name = addslashes($work_order_file_info['machine_name']);
	$work_order_filename = basename($work_order_file_info['work_order_filename']);
	$work_order_filetype = addslashes($work_order_file_info['work_order_filetype']);
	$work_order_url = addslashes($work_order_file_info['work_order_url']);
	$date_updated = date('Y-m-d H:i:s');

	$sql = "INSERT INTO `machine_pm_wo` (`wo_id`, `process`, `machine_name`, `machine_no`, `equipment_no`, `file_name`, `file_type`, `file_url`, `date_updated`) VALUES ('$wo_id', '$process', '$machine_name', '$machine_no', '$equipment_no', '$work_order_filename', '$work_order_filetype', '$work_order_url', '$date_updated')";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

// Count
if ($method == 'count_work_orders') {
	$wo_date_from = $_POST['wo_date_from'];
	if (!empty($wo_date_from)) {
		$wo_date_from = date_create($wo_date_from);
		$wo_date_from = date_format($wo_date_from,"Y-m-d H:i:s");
	}
	$wo_date_to = $_POST['wo_date_to'];
	if (!empty($wo_date_to)) {
		$wo_date_to = date_create($wo_date_to);
		$wo_date_to = date_format($wo_date_to,"Y-m-d H:i:s");
	}
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);
	$machine_name = addslashes($_POST['machine_name']);
	$sql = "SELECT count(id) AS total FROM `machine_pm_wo`";
	if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || (!empty($wo_date_from) && !empty($wo_date_to))) {
		$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND (date_updated >= '$wo_date_from' AND date_updated <= '$wo_date_to')";
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
if ($method == 'get_work_orders') {
	$id = $_POST['id'];
	$wo_date_from = $_POST['wo_date_from'];
	if (!empty($wo_date_from)) {
		$wo_date_from = date_create($wo_date_from);
		$wo_date_from = date_format($wo_date_from,"Y-m-d H:i:s");
	}
	$wo_date_to = $_POST['wo_date_to'];
	if (!empty($wo_date_to)) {
		$wo_date_to = date_create($wo_date_to);
		$wo_date_to = date_format($wo_date_to,"Y-m-d H:i:s");
	}
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);
	$machine_name = addslashes($_POST['machine_name']);
	$c = $_POST['c'];
	
	$sql = "SELECT `id`, `wo_id`, `process`, `machine_name`, `machine_no`, `equipment_no`, `file_name`, `file_url`, `date_updated` FROM `machine_pm_wo`";

	if (empty($id)) {
		if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || (!empty($wo_date_from) && !empty($wo_date_to))) {
			$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND (date_updated >= '$wo_date_from' AND date_updated <= '$wo_date_to')";
		}
	} else {
		$sql = $sql . " WHERE `id` < '$id'";
		if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || (!empty($wo_date_from) && !empty($wo_date_to))) {
			$sql = $sql . " AND (`machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND (date_updated >= '$wo_date_from' AND date_updated <= '$wo_date_to'))";
		}
	}
	$sql = $sql . " ORDER BY id DESC LIMIT 25";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="'.$row['id'].'" data-toggle="modal" data-target="#WorkOrderDetailsModal" data-id="'.$row['id'].'" data-wo_id="'.$row['wo_id'].'" data-process="'.$row['process'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($row['file_url']).'" data-date_updated="'.$row['date_updated'].'" onclick="get_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['wo_id'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="6" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Create / Insert
if ($method == 'upload_work_order') {
	// Declaration & Initialization
	$machine_no = custom_trim($_POST['machine_no']);
	$equipment_no = custom_trim($_POST['equipment_no']);
	$process = $_POST['process'];
	$machine_name = custom_trim($_POST['machine_name']);

	$is_valid = false;

	// Check All Inputs
	if (!empty($machine_no) || !empty($equipment_no)) {
		if (!empty($machine_name)) {
			$machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
			if ($machine_info['registered'] == true) {
				$is_valid = true;
			} else echo 'Machine No. or Equipment No. not found / registered!!!';
		} else echo 'Please press Enter Key after typing Machine No. or Equipment No.';
	} else echo "Please fill out Machine No. or Equipment No.";

	if ($is_valid == true) {

		// Upload File
		if (!empty($_FILES['file']['name'])) {
			$work_order_file = $_FILES['file']['tmp_name'];
			$work_order_filename = $_FILES['file']['name'];
			$work_order_filetype = $_FILES['file']['type'];
			$work_order_size = $_FILES['file']['size'];

			//$work_order_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/pm/uploads/wo/";
			//$target_dir = "../../uploads/wo/";
			$work_order_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/wo/";
			$target_dir = "../../../../uploads/ems/pm/wo/";
			$target_file = $target_dir . basename($work_order_filename);
			$work_order_url .= rawurlencode(basename($work_order_filename));

			$work_order_file_info = array(
				'machine_no' => $machine_no,
				'equipment_no' => $equipment_no,
				'process' => $process,
				'machine_name' => $machine_name,
				'work_order_file' => $work_order_file,
				'work_order_filename' => $work_order_filename,
				'work_order_filetype' => $work_order_filetype,
				'work_order_size' => $work_order_size,
				'target_file' => $target_file,
				'work_order_url' => $work_order_url
			);

			// Check Work Order File
			$chkMachineDocsFileMsg = check_work_order_file($work_order_file_info, $conn);

			if ($chkMachineDocsFileMsg == '') {

				// Upload File and Check if successfully uploaded
				// Note: Can overwrite existing file
				if (move_uploaded_file($work_order_file, $target_file)) {

					// Insert File Information
					save_work_order_info($work_order_file_info, $conn);

				} else {
					echo "Sorry, there was an error uploading your file. Try Again or Contact IT Personnel if it fails again";
				}

			} else {
				echo $chkMachineDocsFileMsg;
			}

		} else {
			echo 'Please upload work order file';
		}
	}
}

$conn = null;
?>