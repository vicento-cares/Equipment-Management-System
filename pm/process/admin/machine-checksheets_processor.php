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
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';

function generate_rsir_no($rsir_no) {
	if ($rsir_no == "") {
		$rsir_no = date("ymdh");
		$rand = substr(md5(microtime()),rand(0,26),5);
		$rsir_no = 'RSIR-'.$rsir_no;
		$rsir_no = $rsir_no.''.$rand;
	}
	return $rsir_no;
}

function update_notif_count_machine_checksheets($interface, $rsir_process_status, $conn) {
	if ($rsir_process_status != 'Saved') {
		$sql = "UPDATE `notif_pm_approvers`";
		if ($rsir_process_status == 'Confirmed') {
			$sql = $sql . " SET `pending_rsir`= pending_rsir + 1";
		} else if ($rsir_process_status == 'Approved') {
			$sql = $sql . " SET `approved_rsir`= approved_rsir + 1";
		} else if ($rsir_process_status == 'Disapproved') {
			$sql = $sql . " SET `disapproved_rsir`= disapproved_rsir + 1";
		}
		$sql = $sql . " WHERE interface = '$interface'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
	}
}

function machine_checksheets_mark_as_read($rsir_no, $rsir_process_status, $interface, $conn) {
	$sql = "";
	if ($rsir_process_status == 'Approved' || $rsir_process_status == 'Disapproved') {
		$sql = $sql . "UPDATE `pm_rsir_history`";
	} else {
		$sql = $sql . "UPDATE `pm_rsir`";
	}
	if ($interface == 'ADMIN-PM') {
		$sql = $sql . " SET `is_read_pm`= 1";
	} else if ($interface == 'APPROVER-PROD-MGR') {
		$sql = $sql . " SET `is_read_prod`= 1";
	} else if ($interface == 'APPROVER-QA-MGR') {
		$sql = $sql . " SET `is_read_qa`= 1";
	}
	$sql = $sql . " WHERE `rsir_no`= '$rsir_no'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	if ($rsir_process_status != 'Saved' && $rsir_process_status != 'Returned') {
		$sql = "UPDATE `notif_pm_approvers`";
		if ($rsir_process_status == 'Confirmed') {
			$sql = $sql . " SET `pending_rsir` = CASE WHEN pending_rsir > 0 THEN pending_rsir - 1 END";
		} else if ($rsir_process_status == 'Approved') {
			$sql = $sql . " SET `approved_rsir` = CASE WHEN approved_rsir > 0 THEN approved_rsir - 1 END";
		} else if ($rsir_process_status == 'Disapproved') {
			$sql = $sql . " SET `disapproved_rsir` = CASE WHEN disapproved_rsir > 0 THEN disapproved_rsir - 1 END";
		}
		$sql = $sql . " WHERE interface = '$interface'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
	}
}

// Check RSIR File
function check_rsir_file($rsir_file_info, $action, $conn) {
	$message = "";
	$hasError = 0;
	$file_valid_arr = array(0,0,0,0);

	$mimes = array('application/vnd.ms-excel', 'application/excel', 'application/msexcel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-word', 'application/word', 'application/vnd.msword', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.oasis.opendocument.text');

	/*$mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');*/

	/*$mimes = array('application/pdf', 'application/x-pdf', 'application/x-bzpdf', 'application/x-gzpdf', 'applications/vnd.pdf', 'application/acrobat', 'application/x-google-chrome-pdf', 'text/pdf', 'text/x-pdf');*/

	// Check File Mimes
	if (!in_array($rsir_file_info['rsir_filetype'], $mimes)) {
		$hasError = 1;
		$file_valid_arr[0] = 1;
	}
	// Check File Size
	if ($rsir_file_info['rsir_size'] > 25000000) {
		$hasError = 1;
		$file_valid_arr[1] = 1;
	}

	// Check File Exists
	if (file_exists($rsir_file_info['target_file'])) {
		if ($action == 'Insert') {
			$hasError = 1;
			$file_valid_arr[2] = 1;
		} else if ($rsir_file_info['old_rsir_filename'] != $rsir_file_info['rsir_filename']) {
			$hasError = 1;
			$file_valid_arr[2] = 1;
		}
	}
	// Check File Information Exists on Database
	$rsir_filename = addslashes($rsir_file_info['rsir_filename']);
	$rsir_filetype = addslashes($rsir_file_info['rsir_filetype']);
	$rsir_url = addslashes($rsir_file_info['rsir_url']);
	$sql = "SELECT id FROM `pm_rsir` WHERE `file_name`= '$rsir_filename' AND `file_type`= '$rsir_filetype' AND `file_url`= '$rsir_url'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		if ($action == 'Insert') {
			$hasError = 1;
			$file_valid_arr[3] = 1;
		} else if ($rsir_file_info['old_rsir_filename'] != $rsir_file_info['rsir_filename']) {
			$hasError = 1;
			$file_valid_arr[3] = 1;
		}
	}
	// Check File Information Exists on Database (History)
	$sql = "SELECT id FROM `pm_rsir_history` WHERE `file_name`= '$rsir_filename' AND `file_type`= '$rsir_filetype' AND `file_url`= '$rsir_url'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		if ($action == 'Insert') {
			$hasError = 1;
			$file_valid_arr[3] = 1;
		} else if ($rsir_file_info['old_rsir_filename'] != $rsir_file_info['rsir_filename']) {
			$hasError = 1;
			$file_valid_arr[3] = 1;
		}
	}

	// Error Collection and Output
	if ($hasError == 1) {
		if ($file_valid_arr[0] == 1) {
		 	$message = $message . 'RSIR file format not accepted! ';
		}
		if ($file_valid_arr[1] == 1) {
		 	$message = $message . 'RSIR file is too large. ';
		}
		if ($file_valid_arr[2] == 1) {
		 	$message = $message . 'RSIR file exists. ';
		}
		if ($file_valid_arr[3] == 1) {
		 	$message = $message . 'RSIR file information exists on the system. ';
		}
	}

	return $message;
}

// Insert File Information
function save_rsir_info($rsir_file_info, $conn) {
	$rsir_no = $rsir_file_info['rsir_no'];
	$rsir_type = $rsir_file_info['rsir_type'];
	$machine_name = addslashes($rsir_file_info['machine_name']);
	$machine_no = addslashes($rsir_file_info['machine_no']);
	$equipment_no = addslashes($rsir_file_info['equipment_no']);
	$rsir_date = date_create($rsir_file_info['rsir_date']);
	$rsir_date = date_format($rsir_date,"Y-m-d");
	$repair_details = addslashes($rsir_file_info['repair_details']);
	$repaired_by = addslashes($rsir_file_info['repaired_by']);
	$repair_date = date_create($rsir_file_info['repair_date']);
	$repair_date = date_format($repair_date,"Y-m-d");
	$next_pm_date = date_create($rsir_file_info['next_pm_date']);
	$next_pm_date = date_format($next_pm_date,"Y-m-d");
	$inspected_by = $_SESSION['pm_name'];
	$rsir_username = $_SESSION['pm_username'];
	$rsir_approver_role = $rsir_file_info['rsir_approver_role'];
	$rsir_filename = basename($rsir_file_info['rsir_filename']);
	$rsir_filetype = addslashes($rsir_file_info['rsir_filetype']);
	$rsir_url = addslashes($rsir_file_info['rsir_url']);
	$rsir_eq_group = 'pm';
	$date_updated = date('Y-m-d H:i:s');

	$sql = "INSERT INTO `pm_rsir` (`rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `inspected_by`, `rsir_username`, `rsir_approver_role`, `rsir_process_status`, `file_name`, `file_type`, `file_url`, `rsir_eq_group`, `date_updated`) VALUES ('$rsir_no', '$rsir_type', '$machine_name', '$machine_no', '$equipment_no', '$rsir_date', '$repair_details', '$repaired_by', '$repair_date', '$next_pm_date', '$inspected_by', '$rsir_username', '$rsir_approver_role', 'Saved', '$rsir_filename', '$rsir_filetype', '$rsir_url', '$rsir_eq_group', '$date_updated')";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

function update_rsir_info_returned($rsir_file_info, $conn) {
	$rsir_no = $rsir_file_info['rsir_no'];
	$rsir_type = $rsir_file_info['rsir_type'];
	$machine_name = addslashes($rsir_file_info['machine_name']);
	$machine_no = addslashes($rsir_file_info['machine_no']);
	$equipment_no = addslashes($rsir_file_info['equipment_no']);
	$rsir_date = date_create($rsir_file_info['rsir_date']);
	$rsir_date = date_format($rsir_date,"Y-m-d");
	$repair_details = addslashes($rsir_file_info['repair_details']);
	$repaired_by = addslashes($rsir_file_info['repaired_by']);
	$repair_date = date_create($rsir_file_info['repair_date']);
	$repair_date = date_format($repair_date,"Y-m-d");
	$next_pm_date = date_create($rsir_file_info['next_pm_date']);
	$next_pm_date = date_format($next_pm_date,"Y-m-d");
	$inspected_by = $_SESSION['pm_name'];
	$rsir_username = $_SESSION['pm_username'];
	$rsir_approver_role = $rsir_file_info['rsir_approver_role'];
	$rsir_filename = basename($rsir_file_info['rsir_filename']);
	$rsir_filetype = addslashes($rsir_file_info['rsir_filetype']);
	$rsir_url = addslashes($rsir_file_info['rsir_url']);
	$rsir_eq_group = 'pm';
	$date_updated = date('Y-m-d H:i:s');

	$sql = "UPDATE `pm_rsir` SET `rsir_type`='$rsir_type',`machine_name`='$machine_name',`machine_no`='$machine_no',`equipment_no`='$equipment_no',`rsir_date`='$rsir_date',`repair_details`='$repair_details',`repaired_by`='$repaired_by',`repair_date`='$repair_date',`next_pm_date`='$next_pm_date',`inspected_by`='$inspected_by',`rsir_username`='$rsir_username',`rsir_approver_role`='$rsir_approver_role',`rsir_process_status`='Saved',`is_read_pm`=0,`file_name`='$rsir_filename',`file_type`='$rsir_filetype',`file_url`='$rsir_url',`rsir_eq_group`='$rsir_eq_group',`date_updated`='$date_updated' WHERE `rsir_no`='$rsir_no'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

if ($method == 'goto_rsir_step2') {
	$machine_no = custom_trim($_POST['machine_no']);
	$equipment_no = custom_trim($_POST['equipment_no']);
	$machine_name = $_POST['machine_name'];
	$rsir_type = $_POST['rsir_type'];
	$rsir_date = $_POST['rsir_date'];
	$rsir_no = $_POST['rsir_no'];
	$rsir_username = $_SESSION['pm_username'];
	$message = '';

	$is_valid = false;

	if (!empty($machine_no) || !empty($equipment_no)) {
		if (!empty($machine_name)) {
			$machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
			if ($machine_info['registered'] == true) {
				if (!empty($rsir_type)) {
					if (!empty($rsir_date)) {
						if (($machine_info['machine_status'] == 'UNUSED' || $machine_info['machine_status'] == 'Setup' || $machine_info['machine_status'] == 'Transfer' || $machine_info['machine_status'] == 'Relayout') && $machine_info['is_new'] == 0) {
							$on_process = check_pm_rsir_on_process($machine_no, $equipment_no, 'pm', $conn);
							if ($on_process == false) {
								$is_valid = true;
							} else $message = 'Checksheet On Process';
						} else $message = 'Not For RSIR';
					} else $message = 'Date Not Set';
				} else $message = 'RSIR Type Not Set';
			} else $message = 'Unregistered Machine';
		} else $message = 'Forgotten Enter Key';
	} else $message = "Machine Indentification Empty";

	if ($is_valid == true) {
		if (!empty($rsir_no)) {
			$message = 'success';
		} else {
			$rsir_no = generate_rsir_no($rsir_no);
			$message = 'success';
		}
	}

	$response_arr = array(
		'rsir_no' => $rsir_no,
		'message' => $message
	);

	echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function check_rsir_no_returned($rsir_no, $conn) {
	$rsir_no_exist = false;

	$sql = "SELECT rsir_no FROM `pm_rsir` WHERE `rsir_no`= '$rsir_no'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		$rsir_no_exist = true;
	}

	return $rsir_no_exist;
}

// TO BE CONTINUED

if ($method == 'save_rsir') {
	// Declaration & Initialization
	$machine_no = custom_trim($_POST['machine_no']);
	$equipment_no = custom_trim($_POST['equipment_no']);
	$machine_name = $_POST['machine_name'];
	$rsir_type = $_POST['rsir_type'];
	$rsir_date = $_POST['rsir_date'];
	$rsir_no = $_POST['rsir_no'];

	$rsir_approver_role = $_POST['rsir_approver_role'];
	$repair_details = custom_trim($_POST['repair_details']);
	$next_pm_date = $_POST['next_pm_date'];
	$repair_date = $_POST['repair_date'];
	$repaired_by = custom_trim($_POST['repaired_by']);
	$rsir_username = $_SESSION['pm_username'];

	$is_valid = false;

	// Check All Inputs
	if (!empty($rsir_approver_role)) {
		if (!empty($repair_details)) {
			if (!empty($next_pm_date)) {
				if (!empty($repair_date)) {
					if (!empty($repaired_by)) {
						$is_valid = true;
					} else echo "Please fill out Repaired By";
				} else echo "Please set Repair Date";
			} else echo "Please set Next PM Date";
		} else echo "Please fill out Repair Details";
	} else echo "Please set Approver";

	if ($is_valid == true) {

		// Upload File
		if (!empty($_FILES['file']['name'])) {
			$rsir_file = $_FILES['file']['tmp_name'];
			$rsir_filename = $_FILES['file']['name'];
			$rsir_filetype = $_FILES['file']['type'];
			$rsir_size = $_FILES['file']['size'];

			//$rsir_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/pm/uploads/rsir/".date("Y")."/".date("m")."/".date("d")."/";
			//$target_dir = "../../uploads/rsir/".date("Y")."/".date("m")."/".date("d")."/";
			// $rsir_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/rsir/".date("Y")."/".date("m")."/".date("d")."/";
			$rsir_url = "/uploads/ems/pm/rsir/".date("Y")."/".date("m")."/".date("d")."/";
			$target_dir = "../../../../uploads/ems/pm/rsir/".date("Y")."/".date("m")."/".date("d")."/";

			// Add Folder If Not Exists
			if (!file_exists($target_dir)) {
			    mkdir($target_dir, 0777, true);
			}

			$rsir_filename = $rsir_no . "-" . $rsir_filename;

			$target_file = $target_dir . basename($rsir_filename);
			$rsir_url .= rawurlencode(basename($rsir_filename));

			$rsir_file_info = array(
				'machine_no' => $machine_no,
				'equipment_no' => $equipment_no,
				'machine_name' => $machine_name,
				'rsir_type' => $rsir_type,
				'rsir_date' => $rsir_date,
				'rsir_no' => $rsir_no,
				'rsir_approver_role' => $rsir_approver_role,
				'repair_details' => $repair_details,
				'next_pm_date' => $next_pm_date,
				'repair_date' => $repair_date,
				'repaired_by' => $repaired_by,
				'rsir_username' => $rsir_username,
				'rsir_file' => $rsir_file,
				'rsir_filename' => $rsir_filename,
				'rsir_filetype' => $rsir_filetype,
				'rsir_size' => $rsir_size,
				'target_file' => $target_file,
				'rsir_url' => $rsir_url
			);

			// Check RSIR File
			$chkRsirFileMsg = check_rsir_file($rsir_file_info, 'Insert', $conn);

			if ($chkRsirFileMsg == '') {

				// Upload File and Check if successfully uploaded
				// Note: Can overwrite existing file
				if (move_uploaded_file($rsir_file, $target_file)) {

					$rsir_no_exist = check_rsir_no_returned($rsir_no, $conn);

					if ($rsir_no_exist == true) {
						update_rsir_info_returned($rsir_file_info, $conn);
					} else {
						// Insert File Information
						save_rsir_info($rsir_file_info, $conn);
					}

				} else {
					echo "Sorry, there was an error uploading your file. Try Again or Contact IT Personnel if it fails again";
				}

			} else {
				echo $chkRsirFileMsg;
			}

		} else {
			echo 'Please upload RSIR file';
		}
	}
}

// Count
if ($method == 'count_pending_machine_checksheets') {
	$sql = "SELECT count(id) AS total FROM `pm_rsir` WHERE (`rsir_process_status`= 'Saved' OR `rsir_process_status`= 'Confirmed') AND `rsir_eq_group`= 'pm'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	} else {
		echo 0;
	}
}

// Read / Load
if ($method == 'get_pending_machine_checksheets') {
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-lime', 'modal-trigger bg-warning', 'modal-trigger bg-orange');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_approver_role`, `rsir_process_status`, `is_read_pm`, `file_name`, `file_url`, `date_updated` FROM `pm_rsir` WHERE (`rsir_process_status`= 'Saved' OR `rsir_process_status`= 'Confirmed') AND `rsir_eq_group`= 'pm' ORDER BY `id` DESC";
	$c = 0;
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($row['is_read_pm'] == 0) {
				$row_class = $row_class_arr[1];
			} else if ($row['rsir_process_status'] == 'Saved') {
				$row_class = $row_class_arr[2];
			} else if ($row['rsir_process_status'] == 'Confirmed') {
				$row_class = $row_class_arr[3];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="PMC_'.$row['rsir_no'].'" data-toggle="modal" data-target="#PendingMachineChecksheetInfoModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'"  data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'" data-rsir_approver_role="'.$row['rsir_approver_role'].'" data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url']).'" onclick="get_details_pending_machine_checksheets(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['rsir_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.$row['rsir_type'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['rsir_date'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="7" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

if ($method == 'pending_machine_checksheets_mark_as_read') {
	machine_checksheets_mark_as_read($_POST['rsir_no'], $_POST['rsir_process_status'], 'ADMIN-PM', $conn);
}

// Count
if ($method == 'count_returned_machine_checksheets') {
	$sql = "SELECT count(id) AS total FROM `pm_rsir` WHERE `rsir_process_status`= 'Returned' AND `rsir_eq_group`= 'pm'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	} else {
		echo 0;
	}
}

// Read / Load
if ($method == 'get_returned_machine_checksheets') {
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-lime', 'modal-trigger bg-warning');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_approver_role`, `rsir_process_status`, `returned_by`, `returned_date_time`, `is_read_pm`, `file_name`, `file_url`, `date_updated` FROM `pm_rsir` WHERE `rsir_process_status`= 'Returned' AND `rsir_eq_group`= 'pm' ORDER BY `id` DESC";
	$c = 0;
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($row['is_read_pm'] == 0) {
				$row_class = $row_class_arr[1];
			} else if ($row['rsir_process_status'] == 'Returned') {
				$row_class = $row_class_arr[2];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="RMC_'.$row['rsir_no'].'" data-toggle="modal" data-target="#ReturnedMachineChecksheetInfoModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'"  data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'" data-rsir_approver_role="'.$row['rsir_approver_role'].'" data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url']).'" onclick="get_details_returned_machine_checksheets(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['rsir_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.$row['rsir_type'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['rsir_date'])).'</td>';
			echo '<td>'.htmlspecialchars($row['returned_by']).'</td>';
			echo '<td>'.date("Y-m-d h:i A", strtotime($row['returned_date_time'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="9" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

if ($method == 'returned_machine_checksheets_mark_as_read') {
	machine_checksheets_mark_as_read($_POST['rsir_no'], $_POST['rsir_process_status'], 'ADMIN-PM', $conn);
}

if ($method == 'return_pending_rsir') {
	$rsir_no = $_POST['rsir_no'];
	$confirmed_by = $_SESSION['pm_name'];

	$sql = "UPDATE `pm_rsir` SET `returned_by`= '$confirmed_by', `returned_date_time`= '$date_updated', `rsir_process_status`= 'Returned', `is_read_pm`=0 WHERE `rsir_no`= '$rsir_no'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	//update_notif_count_machine_checksheets('ADMIN-PM', 'Returned', $conn);

	echo 'success';
}

if ($method == 'confirm_pending_rsir') {
	$rsir_no = $_POST['rsir_no'];
	$rsir_approver_role = $_POST['rsir_approver_role'];
	$judgement_of_eq = custom_trim($_POST['judgement_of_eq']);
	$confirmed_by = $_SESSION['pm_name'];

	$is_valid = false;

	// Check All Inputs
	if (!empty($judgement_of_eq)) {
		$is_valid = true;
	} else echo "Judgement Of Equipment Empty";

	if ($is_valid == true) {
		$sql = "UPDATE `pm_rsir` SET `judgement_of_eq`= '$judgement_of_eq', `confirmed_by`= '$confirmed_by', `rsir_process_status`= 'Confirmed' WHERE `rsir_no`= '$rsir_no'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		if ($rsir_approver_role == 'Prod') {
			update_notif_count_machine_checksheets('APPROVER-PROD-MGR', 'Confirmed', $conn);
		} else if ($rsir_approver_role == 'QA') {
			update_notif_count_machine_checksheets('APPROVER-QA-MGR', 'Confirmed', $conn);
		}

		echo 'success';
	}
}

// TO BE CONTINUED

if ($method == 'machine_checksheets_mark_as_read_prod') {
	machine_checksheets_mark_as_read($_POST['rsir_no'], $_POST['rsir_process_status'], 'APPROVER-PROD-MGR', $conn);
}

// Count
if ($method == 'count_machine_checksheets_prod') {
	$car_model = $_POST['car_model'];
	$location = $_POST['location'];
	$machine_name = $_POST['machine_name'];
	$grid = $_POST['grid'];
	$rsir_no = $_POST['rsir_no'];
	$machine_no = $_POST['machine_no'];
	$equipment_no = $_POST['equipment_no'];

	$sql = "SELECT count(p.id) AS total 
		FROM pm_rsir p
		LEFT JOIN machine_masterlist m
		ON p.machine_no = m.machine_no
		AND p.equipment_no = m.equipment_no
		WHERE p.rsir_process_status='Confirmed' AND p.rsir_approver_role='Prod'";
	
	if (!empty($car_model)) {
		$sql = $sql . " AND m.car_model LIKE '$car_model%'";
	}
	if (!empty($location)) {
		$sql = $sql . " AND m.location LIKE '$location%'";
	}
	if (!empty($machine_name)) {
		$sql = $sql . " AND p.machine_name LIKE '$machine_name%'";
	}
	if (!empty($grid)) {
		$sql = $sql . " AND m.grid LIKE '$grid%'";
	}
	if (!empty($rsir_no)) {
		$sql = $sql . " AND p.rsir_no LIKE '$rsir_no%'";
	}
	if (!empty($machine_no)) {
		$sql = $sql . " AND p.machine_no LIKE '$machine_no%'";
	}
	if (!empty($equipment_no)) {
		$sql = $sql . " AND p.equipment_no LIKE '$equipment_no%'";
	}

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	} else {
		echo 0;
	}
}

// Read / Load
if ($method == 'get_machine_checksheets_prod') {
	$car_model = $_POST['car_model'];
	$location = $_POST['location'];
	$machine_name = $_POST['machine_name'];
	$grid = $_POST['grid'];
	$rsir_no = $_POST['rsir_no'];
	$machine_no = $_POST['machine_no'];
	$equipment_no = $_POST['equipment_no'];

	$row_class_arr = array('modal-trigger', 'modal-trigger bg-warning');
	$row_class = $row_class_arr[0];
	$c = 0;

	$sql = "SELECT 
	p.rsir_no, p.rsir_type, p.machine_name, p.machine_no, p.equipment_no, p.rsir_date, p.judgement_of_eq, p.repair_details, p.repaired_by, p.repair_date, p.next_pm_date, p.judgement_of_prod, p.inspected_by, p.confirmed_by, p.judgement_by, p.rsir_process_status, p.is_read_prod, p.file_name, p.file_url, p.date_updated,
	m.car_model, m.location, m.grid
		FROM pm_rsir p
		LEFT JOIN machine_masterlist m
		ON p.machine_no = m.machine_no
		AND p.equipment_no = m.equipment_no
		WHERE p.rsir_process_status='Confirmed' AND p.rsir_approver_role='Prod'";

	if (!empty($car_model)) {
		$sql = $sql . " AND m.car_model LIKE '$car_model%'";
	}
	if (!empty($location)) {
		$sql = $sql . " AND m.location LIKE '$location%'";
	}
	if (!empty($machine_name)) {
		$sql = $sql . " AND p.machine_name LIKE '$machine_name%'";
	}
	if (!empty($grid)) {
		$sql = $sql . " AND m.grid LIKE '$grid%'";
	}
	if (!empty($rsir_no)) {
		$sql = $sql . " AND p.rsir_no LIKE '$rsir_no%'";
	}
	if (!empty($machine_no)) {
		$sql = $sql . " AND p.machine_no LIKE '$machine_no%'";
	}
	if (!empty($equipment_no)) {
		$sql = $sql . " AND p.equipment_no LIKE '$equipment_no%'";
	}

	$sql = $sql . " ORDER BY p.id DESC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($row['is_read_prod'] == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="MCP_'.$row['rsir_no'].'" data-toggle="modal" data-target="#PendingMachineChecksheetInfoModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'" data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'"  data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url']).'" onclick="get_details_machine_checksheets_prod(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['rsir_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.$row['rsir_type'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['rsir_date'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="7" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Count
if ($method == 'count_pm_records_prod') {
	$rsir_date_from = $_POST['rsir_date_from'];
	if (!empty($rsir_date_from)) {
		$rsir_date_from = date_create($rsir_date_from);
		$rsir_date_from = date_format($rsir_date_from,"Y-m-d");
	}
	$rsir_date_to = $_POST['rsir_date_to'];
	if (!empty($rsir_date_to)) {
		$rsir_date_to = date_create($rsir_date_to);
		$rsir_date_to = date_format($rsir_date_to,"Y-m-d");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);
	$rsir_no = $_POST['rsir_no'];

	$sql = "SELECT count(id) AS total FROM `pm_rsir_history`";

	if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || !empty($rsir_no) || (!empty($rsir_date_from) && !empty($rsir_date_to))) {
		$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND `rsir_no` LIKE '$rsir_no%' AND (rsir_date >= '$rsir_date_from' AND rsir_date <= '$rsir_date_to') AND (`rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved') AND `rsir_approver_role`= 'Prod'";
	} else {
		$sql = $sql . " WHERE (`rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved') AND `rsir_approver_role`= 'Prod'";
	}

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	} else {
		echo 0;
	}
}

// Read / Load
if ($method == 'get_pm_records_prod') {
	$id = $_POST['id'];
	$rsir_date_from = $_POST['rsir_date_from'];
	if (!empty($rsir_date_from)) {
		$rsir_date_from = date_create($rsir_date_from);
		$rsir_date_from = date_format($rsir_date_from,"Y-m-d");
	}
	$rsir_date_to = $_POST['rsir_date_to'];
	if (!empty($rsir_date_to)) {
		$rsir_date_to = date_create($rsir_date_to);
		$rsir_date_to = date_format($rsir_date_to,"Y-m-d");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);
	$rsir_no = $_POST['rsir_no'];
	$c = $_POST['c'];

	$sql = "SELECT `id`, `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_process_status`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `file_name`, `file_url`, `date_updated` FROM `pm_rsir_history`";

	if (empty($id)) {
		if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || !empty($rsir_no) || (!empty($rsir_date_from) && !empty($rsir_date_to))) {
			$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND `rsir_no` LIKE '$rsir_no%' AND (rsir_date >= '$rsir_date_from' AND rsir_date <= '$rsir_date_to')";
		}
	} else {
		$sql = $sql . " WHERE `id` < '$id'";
		if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || !empty($rsir_no) || (!empty($rsir_date_from) && !empty($rsir_date_to))) {
			$sql = $sql . " AND (`machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND `rsir_no` LIKE '$rsir_no%' AND (rsir_date >= '$rsir_date_from' AND rsir_date <= '$rsir_date_to'))";
		}
	}
	$sql = $sql . " AND (`rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved') AND `rsir_approver_role`= 'Prod' ORDER BY `id` DESC LIMIT 25";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="'.$row['id'].'" data-toggle="modal" data-target="#MachineChecksheetInfoHistoryModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'"  data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'" data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url']).'" data-disapproved_by="'.htmlspecialchars($row['disapproved_by']).'" data-disapproved_by_role="'.htmlspecialchars($row['disapproved_by_role']).'" data-disapproved_comment="'.htmlspecialchars($row['disapproved_comment']).'" onclick="get_details_machine_checksheets_history(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['rsir_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.$row['rsir_type'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['rsir_date'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="7" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

if ($method == 'machine_checksheets_mark_as_read_qa') {
	machine_checksheets_mark_as_read($_POST['rsir_no'], $_POST['rsir_process_status'], 'APPROVER-QA-MGR', $conn);
}

// Count
if ($method == 'count_machine_checksheets_qa') {
	$car_model = $_POST['car_model'];
	$location = $_POST['location'];
	$machine_name = $_POST['machine_name'];
	$grid = $_POST['grid'];
	$rsir_no = $_POST['rsir_no'];
	$machine_no = $_POST['machine_no'];
	$equipment_no = $_POST['equipment_no'];

	$sql = "SELECT count(p.id) AS total 
		FROM pm_rsir p
		LEFT JOIN machine_masterlist m
		ON p.machine_no = m.machine_no
		AND p.equipment_no = m.equipment_no
		WHERE p.rsir_process_status='Confirmed' AND p.rsir_approver_role='QA'";
	
	if (!empty($car_model)) {
		$sql = $sql . " AND m.car_model LIKE '$car_model%'";
	}
	if (!empty($location)) {
		$sql = $sql . " AND m.location LIKE '$location%'";
	}
	if (!empty($machine_name)) {
		$sql = $sql . " AND p.machine_name LIKE '$machine_name%'";
	}
	if (!empty($grid)) {
		$sql = $sql . " AND m.grid LIKE '$grid%'";
	}
	if (!empty($rsir_no)) {
		$sql = $sql . " AND p.rsir_no LIKE '$rsir_no%'";
	}
	if (!empty($machine_no)) {
		$sql = $sql . " AND p.machine_no LIKE '$machine_no%'";
	}
	if (!empty($equipment_no)) {
		$sql = $sql . " AND p.equipment_no LIKE '$equipment_no%'";
	}

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	} else {
		echo 0;
	}
}

// Read / Load
if ($method == 'get_machine_checksheets_qa') {
	$car_model = $_POST['car_model'];
	$location = $_POST['location'];
	$machine_name = $_POST['machine_name'];
	$grid = $_POST['grid'];
	$rsir_no = $_POST['rsir_no'];
	$machine_no = $_POST['machine_no'];
	$equipment_no = $_POST['equipment_no'];

	$row_class_arr = array('modal-trigger', 'modal-trigger bg-warning');
	$row_class = $row_class_arr[0];
	$c = 0;

	$sql = "SELECT 
	p.rsir_no, p.rsir_type, p.machine_name, p.machine_no, p.equipment_no, p.rsir_date, p.judgement_of_eq, p.repair_details, p.repaired_by, p.repair_date, p.next_pm_date, p.judgement_of_prod, p.inspected_by, p.confirmed_by, p.judgement_by, p.rsir_process_status, p.is_read_qa, p.file_name, p.file_url, p.date_updated,
	m.car_model, m.location, m.grid
		FROM pm_rsir p
		LEFT JOIN machine_masterlist m
		ON p.machine_no = m.machine_no
		AND p.equipment_no = m.equipment_no
		WHERE p.rsir_process_status='Confirmed' AND p.rsir_approver_role='QA'";

	if (!empty($car_model)) {
		$sql = $sql . " AND m.car_model LIKE '$car_model%'";
	}
	if (!empty($location)) {
		$sql = $sql . " AND m.location LIKE '$location%'";
	}
	if (!empty($machine_name)) {
		$sql = $sql . " AND p.machine_name LIKE '$machine_name%'";
	}
	if (!empty($grid)) {
		$sql = $sql . " AND m.grid LIKE '$grid%'";
	}
	if (!empty($rsir_no)) {
		$sql = $sql . " AND p.rsir_no LIKE '$rsir_no%'";
	}
	if (!empty($machine_no)) {
		$sql = $sql . " AND p.machine_no LIKE '$machine_no%'";
	}
	if (!empty($equipment_no)) {
		$sql = $sql . " AND p.equipment_no LIKE '$equipment_no%'";
	}

	$sql = $sql . " ORDER BY p.id DESC";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($row['is_read_qa'] == 0) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="MCQ_'.$row['rsir_no'].'" data-toggle="modal" data-target="#PendingMachineChecksheetInfoModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'" data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'"  data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url']).'" onclick="get_details_machine_checksheets_qa(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['rsir_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.$row['rsir_type'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['rsir_date'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="7" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Count
if ($method == 'count_pm_records_qa') {
	$rsir_date_from = $_POST['rsir_date_from'];
	if (!empty($rsir_date_from)) {
		$rsir_date_from = date_create($rsir_date_from);
		$rsir_date_from = date_format($rsir_date_from,"Y-m-d");
	}
	$rsir_date_to = $_POST['rsir_date_to'];
	if (!empty($rsir_date_to)) {
		$rsir_date_to = date_create($rsir_date_to);
		$rsir_date_to = date_format($rsir_date_to,"Y-m-d");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);
	$rsir_no = $_POST['rsir_no'];

	$sql = "SELECT count(id) AS total FROM `pm_rsir_history`";

	if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || !empty($rsir_no) || (!empty($rsir_date_from) && !empty($rsir_date_to))) {
		$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND `rsir_no` LIKE '$rsir_no%' AND (rsir_date >= '$rsir_date_from' AND rsir_date <= '$rsir_date_to') AND (`rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved') AND `rsir_approver_role`= 'QA'";
	} else {
		$sql = $sql . " WHERE (`rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved') AND `rsir_approver_role`= 'QA'";
	}

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	} else {
		echo 0;
	}
}

// Read / Load
if ($method == 'get_pm_records_qa') {
	$id = $_POST['id'];
	$rsir_date_from = $_POST['rsir_date_from'];
	if (!empty($rsir_date_from)) {
		$rsir_date_from = date_create($rsir_date_from);
		$rsir_date_from = date_format($rsir_date_from,"Y-m-d");
	}
	$rsir_date_to = $_POST['rsir_date_to'];
	if (!empty($rsir_date_to)) {
		$rsir_date_to = date_create($rsir_date_to);
		$rsir_date_to = date_format($rsir_date_to,"Y-m-d");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);
	$rsir_no = $_POST['rsir_no'];
	$c = $_POST['c'];

	$sql = "SELECT `id`, `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_process_status`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `file_name`, `file_url`, `date_updated` FROM `pm_rsir_history`";

	if (empty($id)) {
		if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || !empty($rsir_no) || (!empty($rsir_date_from) && !empty($rsir_date_to))) {
			$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND `rsir_no` LIKE '$rsir_no%' AND (rsir_date >= '$rsir_date_from' AND rsir_date <= '$rsir_date_to')";
		}
	} else {
		$sql = $sql . " WHERE `id` < '$id'";
		if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || !empty($rsir_no) || (!empty($rsir_date_from) && !empty($rsir_date_to))) {
			$sql = $sql . " AND (`machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND `rsir_no` LIKE '$rsir_no%' AND (rsir_date >= '$rsir_date_from' AND rsir_date <= '$rsir_date_to'))";
		}
	}
	$sql = $sql . " AND (`rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved') AND `rsir_approver_role`= 'QA' ORDER BY `id` DESC LIMIT 25";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="'.$row['id'].'" data-toggle="modal" data-target="#MachineChecksheetInfoHistoryModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'"  data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'" data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url']).'" data-disapproved_by="'.htmlspecialchars($row['disapproved_by']).'" data-disapproved_by_role="'.htmlspecialchars($row['disapproved_by_role']).'" data-disapproved_comment="'.htmlspecialchars($row['disapproved_comment']).'" onclick="get_details_machine_checksheets_history(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['rsir_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.$row['rsir_type'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['rsir_date'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="7" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

if ($method == 'approve_pending_rsir') {
	$rsir_no = $_POST['rsir_no'];
	$pm_name = $_SESSION['pm_name'];
	$judgement_of_prod = custom_trim($_POST['judgement_of_prod']);

	$is_valid = false;

	// Check All Inputs
	if (!empty($judgement_of_prod)) {
		$is_valid = true;
	} else echo "Judgement Of Product Empty";

	if ($is_valid == true) {
		$sql = "SELECT `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_username`, `rsir_approver_role`, `rsir_process_status`, `disapproved_by`, `disapproved_by_role`, `file_name`, `file_type`, `file_url`, `rsir_eq_group` FROM `pm_rsir` WHERE `rsir_no`= '$rsir_no'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		if ($stmt -> rowCount() > 0) {
			foreach($stmt -> fetchAll() as $row) {
				$rsir_no = $row['rsir_no'];
				$rsir_type = $row['rsir_type'];
				$machine_name = $row['machine_name'];
				$machine_no = $row['machine_no'];
				$equipment_no = $row['equipment_no'];
				$rsir_date = $row['rsir_date'];
				$judgement_of_eq = $row['judgement_of_eq'];
				$repair_details = $row['repair_details'];
				$repaired_by = $row['repaired_by'];
				$repair_date = $row['repair_date'];
				$next_pm_date = $row['next_pm_date'];
				$inspected_by = $row['inspected_by'];
				$confirmed_by = $row['confirmed_by'];
				$judgement_by = $row['judgement_by'];
				$rsir_username = $row['rsir_username'];
				$rsir_approver_role = $row['rsir_approver_role'];
				$file_name = $row['file_name'];
				$file_type = $row['file_type'];
				$file_url = $row['file_url'];
				$rsir_eq_group = $row['rsir_eq_group'];
			}
		}

		$sql = "INSERT INTO `pm_rsir_history`(`rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_username`, `rsir_approver_role`, `rsir_process_status`, `file_name`, `file_type`, `file_url`, `rsir_eq_group`) VALUES ('$rsir_no','$rsir_type','$machine_name','$machine_no','$equipment_no','$rsir_date','$judgement_of_eq','$repair_details','$repaired_by','$repair_date','$next_pm_date','$judgement_of_prod','$inspected_by','$confirmed_by','$pm_name','$rsir_username','$rsir_approver_role','Approved','$file_name','$file_type','$file_url','$rsir_eq_group')";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		$sql = "DELETE FROM `pm_rsir` WHERE `rsir_no`= '$rsir_no'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		update_notif_count_machine_checksheets('ADMIN-PM', 'Approved', $conn);

		echo 'success';
	}
}

if ($method == 'disapprove_pending_rsir') {
	$rsir_no = $_POST['rsir_no'];
	$disapproved_comment = $_POST['disapproved_comment'];
	$pm_name = $_SESSION['pm_name'];
	$pm_role = $_SESSION['pm_role'];
	$judgement_of_prod = custom_trim($_POST['judgement_of_prod']);

	$is_valid = false;

	// Check All Inputs
	if (!empty($judgement_of_prod)) {
		if (!empty($disapproved_comment)) {
			$is_valid = true;
		} else echo 'Comment Empty';
	} else echo "Judgement Of Product Empty";

	if ($is_valid == true) {

		$sql = "SELECT `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_username`, `rsir_approver_role`, `rsir_process_status`, `disapproved_by`, `disapproved_by_role`, `file_name`, `file_type`, `file_url`, `rsir_eq_group` FROM `pm_rsir` WHERE `rsir_no`= '$rsir_no'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		if ($stmt -> rowCount() > 0) {
			foreach($stmt -> fetchAll() as $row) {
				$rsir_no = $row['rsir_no'];
				$rsir_type = $row['rsir_type'];
				$machine_name = $row['machine_name'];
				$machine_no = $row['machine_no'];
				$equipment_no = $row['equipment_no'];
				$rsir_date = $row['rsir_date'];
				$judgement_of_eq = $row['judgement_of_eq'];
				$repair_details = $row['repair_details'];
				$repaired_by = $row['repaired_by'];
				$repair_date = $row['repair_date'];
				$next_pm_date = $row['next_pm_date'];
				$inspected_by = $row['inspected_by'];
				$confirmed_by = $row['confirmed_by'];
				$judgement_by = $row['judgement_by'];
				$rsir_username = $row['rsir_username'];
				$rsir_approver_role = $row['rsir_approver_role'];
				$file_name = $row['file_name'];
				$file_type = $row['file_type'];
				$file_url = $row['file_url'];
				$rsir_eq_group = $row['rsir_eq_group'];
			}
		}

		$sql = "INSERT INTO `pm_rsir_history`(`rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_username`, `rsir_approver_role`, `rsir_process_status`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `file_name`, `file_type`, `file_url`, `rsir_eq_group`) VALUES ('$rsir_no','$rsir_type','$machine_name','$machine_no','$equipment_no','$rsir_date','$judgement_of_eq','$repair_details','$repaired_by','$repair_date','$next_pm_date','$judgement_of_prod','$inspected_by','$confirmed_by','$judgement_by','$rsir_username','$rsir_approver_role','Disapproved','$pm_name','$pm_role','$disapproved_comment','$file_name','$file_type','$file_url','$rsir_eq_group')";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		$sql = "DELETE FROM `pm_rsir` WHERE `rsir_no`= '$rsir_no'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();

		update_notif_count_machine_checksheets('ADMIN-PM', 'Disapproved', $conn);

		echo 'success';
	}
}

// TO BE CONTINUED

// Count
if ($method == 'count_pm_records') {
	$rsir_date_from = $_POST['rsir_date_from'];
	if (!empty($rsir_date_from)) {
		$rsir_date_from = date_create($rsir_date_from);
		$rsir_date_from = date_format($rsir_date_from,"Y-m-d");
	}
	$rsir_date_to = $_POST['rsir_date_to'];
	if (!empty($rsir_date_to)) {
		$rsir_date_to = date_create($rsir_date_to);
		$rsir_date_to = date_format($rsir_date_to,"Y-m-d");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);
	$rsir_no = $_POST['rsir_no'];

	$sql = "SELECT count(id) AS total FROM `pm_rsir_history`";

	if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || !empty($rsir_no) || (!empty($rsir_date_from) && !empty($rsir_date_to))) {
		$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND `rsir_no` LIKE '$rsir_no%' AND (rsir_date >= '$rsir_date_from' AND rsir_date <= '$rsir_date_to') AND (`rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved')";
	} else {
		$sql = $sql . " WHERE `rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved'";
	}

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	} else {
		echo 0;
	}
}

// Read / Load
if ($method == 'get_pm_records') {
	$id = $_POST['id'];
	$rsir_date_from = $_POST['rsir_date_from'];
	if (!empty($rsir_date_from)) {
		$rsir_date_from = date_create($rsir_date_from);
		$rsir_date_from = date_format($rsir_date_from,"Y-m-d");
	}
	$rsir_date_to = $_POST['rsir_date_to'];
	if (!empty($rsir_date_to)) {
		$rsir_date_to = date_create($rsir_date_to);
		$rsir_date_to = date_format($rsir_date_to,"Y-m-d");
	}
	$machine_name = addslashes($_POST['machine_name']);
	$machine_no = addslashes($_POST['machine_no']);
	$equipment_no = addslashes($_POST['equipment_no']);
	$rsir_no = $_POST['rsir_no'];
	$c = $_POST['c'];

	$row_class_arr = array('modal-trigger', 'modal-trigger bg-success', 'modal-trigger bg-danger');
	$row_class = $row_class_arr[0];

	$sql = "SELECT `id`, `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_process_status`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `file_name`, `file_url`, `date_updated` FROM `pm_rsir_history`";

	if (empty($id)) {
		if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || !empty($rsir_no) || (!empty($rsir_date_from) && !empty($rsir_date_to))) {
			$sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND `rsir_no` LIKE '$rsir_no%' AND (rsir_date >= '$rsir_date_from' AND rsir_date <= '$rsir_date_to')";
		}
	} else {
		$sql = $sql . " WHERE `id` < '$id'";
		if (!empty($machine_name) || !empty($machine_no) || !empty($equipment_no) || !empty($rsir_no) || (!empty($rsir_date_from) && !empty($rsir_date_to))) {
			$sql = $sql . " AND (`machine_name` LIKE '$machine_name%' AND `machine_no` LIKE '$machine_no%' AND `equipment_no` LIKE '$equipment_no%' AND `rsir_no` LIKE '$rsir_no%' AND (rsir_date >= '$rsir_date_from' AND rsir_date <= '$rsir_date_to'))";
		}
	}
	$sql = $sql . " AND (`rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved') ORDER BY `id` DESC LIMIT 25";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($row['rsir_process_status'] == 'Approved') {
				$row_class = $row_class_arr[1];
			} else if ($row['rsir_process_status'] == 'Disapproved') {
				$row_class = $row_class_arr[2];
			} else {
				$row_class = $row_class_arr[0];
			}

			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="'.$row['id'].'" data-toggle="modal" data-target="#MachineChecksheetInfoHistoryModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'"  data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'" data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url']).'" data-disapproved_by="'.htmlspecialchars($row['disapproved_by']).'" data-disapproved_by_role="'.htmlspecialchars($row['disapproved_by_role']).'" data-disapproved_comment="'.htmlspecialchars($row['disapproved_comment']).'" onclick="get_details_machine_checksheets_history(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['rsir_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.$row['rsir_type'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['rsir_date'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="7" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// TO BE CONTINUED

if ($method == 'history_machine_checksheets_mark_as_read') {
	machine_checksheets_mark_as_read($_POST['rsir_no'], $_POST['rsir_process_status'], 'ADMIN-PM', $conn);
}

// Read / Load
if ($method == 'get_recent_pm_records') {
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-lime', 'modal-trigger bg-success', 'modal-trigger bg-danger');
	$row_class = $row_class_arr[0];
	$c = 0;

	$sql = "SELECT `id`, `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_process_status`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `is_read_pm`, `file_name`, `file_url`, `date_updated` FROM `pm_rsir_history` WHERE `rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved' ORDER BY `id` DESC LIMIT 25";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($row['is_read_pm'] == 0) {
				$row_class = $row_class_arr[1];
			} else if ($row['rsir_process_status'] == 'Approved') {
				$row_class = $row_class_arr[2];
			} else if ($row['rsir_process_status'] == 'Disapproved') {
				$row_class = $row_class_arr[3];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="MCH_'.$row['id'].'" data-toggle="modal" data-target="#MachineChecksheetInfoHistoryModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'"  data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'" data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($protocol.$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT'].$row['file_url']).'" data-disapproved_by="'.htmlspecialchars($row['disapproved_by']).'" data-disapproved_by_role="'.htmlspecialchars($row['disapproved_by_role']).'" data-disapproved_comment="'.htmlspecialchars($row['disapproved_comment']).'" onclick="get_details_machine_checksheets_history(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['rsir_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.$row['rsir_type'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['rsir_date'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="7" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

$conn = null;
?>