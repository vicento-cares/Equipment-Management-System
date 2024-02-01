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
	$inspected_by = $_SESSION['setup_name'];
	$rsir_username = $_SESSION['setup_username'];
	$rsir_approver_role = $rsir_file_info['rsir_approver_role'];
	$rsir_filename = basename($rsir_file_info['rsir_filename']);
	$rsir_filetype = addslashes($rsir_file_info['rsir_filetype']);
	$rsir_url = addslashes($rsir_file_info['rsir_url']);
	$rsir_eq_group = 'setup';
	$date_updated = date('Y-m-d H:i:s');

	$mstprc_no = $rsir_file_info['mstprc_no'];

	$sql = "INSERT INTO `pm_rsir` (`rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `inspected_by`, `rsir_username`, `rsir_approver_role`, `rsir_process_status`, `file_name`, `file_type`, `file_url`, `rsir_eq_group`, `date_updated`) VALUES ('$rsir_no', '$rsir_type', '$machine_name', '$machine_no', '$equipment_no', '$rsir_date', '$repair_details', '$repaired_by', '$repair_date', '$next_pm_date', '$inspected_by', '$rsir_username', '$rsir_approver_role', 'Saved', '$rsir_filename', '$rsir_filetype', '$rsir_url', '$rsir_eq_group', '$date_updated')";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$sql = "UPDATE `setup_mstprc` SET `rsir_no`= '$rsir_no' WHERE `mstprc_no`= '$mstprc_no'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	$sql = "UPDATE `setup_mstprc_history` SET `rsir_no`= '$rsir_no' WHERE `mstprc_no`= '$mstprc_no'";
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
	$inspected_by = $_SESSION['setup_name'];
	$rsir_username = $_SESSION['setup_username'];
	$rsir_approver_role = $rsir_file_info['rsir_approver_role'];
	$rsir_filename = basename($rsir_file_info['rsir_filename']);
	$rsir_filetype = addslashes($rsir_file_info['rsir_filetype']);
	$rsir_url = addslashes($rsir_file_info['rsir_url']);
	$rsir_eq_group = 'setup';
	$date_updated = date('Y-m-d H:i:s');

	$mstprc_no = $rsir_file_info['mstprc_no'];

	$sql = "UPDATE `pm_rsir` SET `rsir_type`='$rsir_type',`machine_name`='$machine_name',`machine_no`='$machine_no',`equipment_no`='$equipment_no',`rsir_date`='$rsir_date',`repair_details`='$repair_details',`repaired_by`='$repaired_by',`repair_date`='$repair_date',`next_pm_date`='$next_pm_date',`inspected_by`='$inspected_by',`rsir_username`='$rsir_username',`rsir_approver_role`='$rsir_approver_role',`rsir_process_status`='Saved',`is_read_pm`=0,`file_name`='$rsir_filename',`file_type`='$rsir_filetype',`file_url`='$rsir_url',`rsir_eq_group`='$rsir_eq_group',`date_updated`='$date_updated' WHERE `rsir_no`='$rsir_no'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();

	$sql = "UPDATE `setup_mstprc` SET `rsir_no`= '$rsir_no' WHERE `mstprc_no`= '$mstprc_no'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	$sql = "UPDATE `setup_mstprc_history` SET `rsir_no`= '$rsir_no' WHERE `mstprc_no`= '$mstprc_no'";
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
	$rsir_username = $_SESSION['setup_username'];
	$message = '';

	$is_valid = false;

	if (!empty($machine_no) || !empty($equipment_no)) {
		if (!empty($machine_name)) {
			$machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
			if ($machine_info['registered'] == true) {
				if (!empty($rsir_type)) {
					if (!empty($rsir_date)) {
						if ($machine_info['machine_status'] == 'UNUSED' || $machine_info['machine_status'] == 'Setup' || $machine_info['machine_status'] == 'Transfer' || $machine_info['machine_status'] == 'Relayout' || $machine_info['machine_status'] == '') {
							$on_process = check_pm_rsir_on_process($machine_no, $equipment_no, 'setup', $conn);
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
	$rsir_username = $_SESSION['setup_username'];

	$mstprc_no = $_POST['mstprc_no'];

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
			//$target_dir = "../../../pm/uploads/rsir/".date("Y")."/".date("m")."/".date("d")."/";
			$rsir_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/rsir/".date("Y")."/".date("m")."/".date("d")."/";
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
				'rsir_url' => $rsir_url,
				'mstprc_no' => $mstprc_no
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
if ($method == 'count_need_rsir_machine_checksheets') {
	$history_option = $_POST['history_option'];

	$sql = "";

	if ($history_option == 1) {
		$sql = $sql . "SELECT count(id) AS total FROM `setup_mstprc` WHERE `rsir_no`= '' AND `mstprc_type`= 'Setup'";
	} else if ($history_option == 2) {
		$sql = $sql . "SELECT count(id) AS total FROM `setup_mstprc_history` WHERE `rsir_no`= '' AND `mstprc_type`= 'Setup' AND `mstprc_process_status`!= 'Disapproved'";
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
if ($method == 'get_need_rsir_machine_checksheets') {
	$history_option = $_POST['history_option'];

	$sql = "";

	if ($history_option == 1) {
		$sql = "SELECT `mstprc_no`, `mstprc_type`, `machine_name`, `machine_no`, `equipment_no`, `mstprc_date`, `car_model`, `location`, `grid`, `to_car_model`, `to_location`, `to_grid`, `pullout_location`, `transfer_reason`, `pullout_reason`, `mstprc_eq_member`, `mstprc_eq_g_leader`, `mstprc_safety_officer`, `mstprc_eq_manager`, `mstprc_eq_sp_personnel`, `mstprc_prod_engr_manager`, `mstprc_prod_supervisor`, `mstprc_prod_manager`, `mstprc_qa_supervisor`, `mstprc_qa_manager`, `mstprc_process_status`, `is_read_setup`, `file_name`, `file_url` FROM `setup_mstprc` WHERE `rsir_no`= '' AND `mstprc_type`= 'Setup' ORDER BY `id` DESC";
	} else if ($history_option == 2) {
		$sql = "SELECT `mstprc_no`, `mstprc_type`, `machine_name`, `machine_no`, `equipment_no`, `mstprc_date`, `car_model`, `location`, `grid`, `to_car_model`, `to_location`, `to_grid`, `pullout_location`, `transfer_reason`, `pullout_reason`, `mstprc_eq_member`, `mstprc_eq_g_leader`, `mstprc_safety_officer`, `mstprc_eq_manager`, `mstprc_eq_sp_personnel`, `mstprc_prod_engr_manager`, `mstprc_prod_supervisor`, `mstprc_prod_manager`, `mstprc_qa_supervisor`, `mstprc_qa_manager`, `mstprc_process_status`, `is_read_setup`, `file_name`, `file_url` FROM `setup_mstprc_history` WHERE `rsir_no`= '' AND `mstprc_type`= 'Setup' AND `mstprc_process_status`!= 'Disapproved' ORDER BY `id` DESC";
	}

	$c = 0;
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			echo '<tr style="cursor:pointer;" class="modal-trigger" id="NRMC_'.$row['mstprc_no'].'" data-toggle="modal" data-target="#NeedRsirMachineChecksheetInfoModal" data-mstprc_no="'.$row['mstprc_no'].'" data-mstprc_type="'.$row['mstprc_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'" data-car_model="'.htmlspecialchars($row['car_model']).'" data-location="'.htmlspecialchars($row['location']).'" data-grid="'.htmlspecialchars($row['grid']).'" data-to_car_model="'.htmlspecialchars($row['to_car_model']).'" data-to_location="'.htmlspecialchars($row['to_location']).'" data-to_grid="'.htmlspecialchars($row['to_grid']).'" data-pullout_location="'.htmlspecialchars($row['pullout_location']).'" data-transfer_reason="'.htmlspecialchars($row['transfer_reason']).'" data-pullout_reason="'.htmlspecialchars($row['pullout_reason']).'" data-mstprc_eq_member="'.htmlspecialchars($row['mstprc_eq_member']).'" data-mstprc_eq_g_leader="'.htmlspecialchars($row['mstprc_eq_g_leader']).'" data-mstprc_safety_officer="'.htmlspecialchars($row['mstprc_safety_officer']).'" data-mstprc_eq_manager="'.htmlspecialchars($row['mstprc_eq_manager']).'" data-mstprc_eq_sp_personnel="'.htmlspecialchars($row['mstprc_eq_sp_personnel']).'" data-mstprc_prod_engr_manager="'.htmlspecialchars($row['mstprc_prod_engr_manager']).'" data-mstprc_prod_supervisor="'.htmlspecialchars($row['mstprc_prod_supervisor']).'" data-mstprc_prod_manager="'.htmlspecialchars($row['mstprc_prod_manager']).'" data-mstprc_qa_supervisor="'.htmlspecialchars($row['mstprc_qa_supervisor']).'" data-mstprc_qa_manager="'.htmlspecialchars($row['mstprc_qa_manager']).'" data-mstprc_process_status="'.$row['mstprc_process_status'].'" data-mstprc_date="'.date("d-M-y", strtotime($row['mstprc_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($row['file_url']).'" onclick="get_details_need_rsir_machine_checksheets(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.$row['mstprc_no'].'</td>';
			echo '<td>'.htmlspecialchars($row['machine_name']).'</td>';
			echo '<td>'.htmlspecialchars($row['machine_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['equipment_no']).'</td>';
			echo '<td>'.htmlspecialchars($row['car_model']).'</td>';
			echo '<td>'.$row['mstprc_type'].'</td>';
			echo '<td>'.date("Y-m-d", strtotime($row['mstprc_date'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Count
if ($method == 'count_pending_machine_checksheets') {
	$sql = "SELECT count(id) AS total FROM `pm_rsir` WHERE (`rsir_process_status`= 'Saved' OR `rsir_process_status`= 'Confirmed') AND `rsir_eq_group`= 'setup'";
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
	$sql = "SELECT `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_approver_role`, `rsir_process_status`, `is_read_pm`, `file_name`, `file_url`, `date_updated` FROM `pm_rsir` WHERE (`rsir_process_status`= 'Saved' OR `rsir_process_status`= 'Confirmed') AND `rsir_eq_group`= 'setup' ORDER BY `id` DESC";
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
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="PMC_'.$row['rsir_no'].'" data-toggle="modal" data-target="#PendingMachineChecksheetInfoModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'"  data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'" data-rsir_approver_role="'.$row['rsir_approver_role'].'" data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($row['file_url']).'" onclick="get_details_pending_machine_checksheets(this)">';
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
	$sql = "SELECT count(id) AS total FROM `pm_rsir` WHERE `rsir_process_status`= 'Returned' AND `rsir_eq_group`= 'setup'";
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
	$sql = "SELECT `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_approver_role`, `rsir_process_status`, `returned_by`, `returned_date_time`, `is_read_pm`, `file_name`, `file_url`, `date_updated` FROM `pm_rsir` WHERE `rsir_process_status`= 'Returned' AND `rsir_eq_group`= 'setup' ORDER BY `id` DESC";
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
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="RMC_'.$row['rsir_no'].'" data-toggle="modal" data-target="#ReturnedMachineChecksheetInfoModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'"  data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'" data-rsir_approver_role="'.$row['rsir_approver_role'].'" data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($row['file_url']).'" onclick="get_details_returned_machine_checksheets(this)">';
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
	$confirmed_by = $_SESSION['setup_name'];

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
	$confirmed_by = $_SESSION['setup_name'];

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

if ($method == 'history_machine_checksheets_mark_as_read') {
	machine_checksheets_mark_as_read($_POST['rsir_no'], $_POST['rsir_process_status'], 'ADMIN-PM', $conn);
}

// Read / Load
if ($method == 'get_recent_pm_records') {
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-lime', 'modal-trigger bg-success', 'modal-trigger bg-danger');
	$row_class = $row_class_arr[0];
	$c = 0;

	$sql = "SELECT `id`, `rsir_no`, `rsir_type`, `machine_name`, `machine_no`, `equipment_no`, `rsir_date`, `judgement_of_eq`, `repair_details`, `repaired_by`, `repair_date`, `next_pm_date`, `judgement_of_prod`, `inspected_by`, `confirmed_by`, `judgement_by`, `rsir_process_status`, `disapproved_by`, `disapproved_by_role`, `disapproved_comment`, `is_read_pm`, `file_name`, `file_url`, `date_updated` FROM `pm_rsir_history` WHERE (`rsir_process_status`= 'Approved' OR `rsir_process_status`= 'Disapproved') AND `rsir_eq_group`= 'setup' ORDER BY `id` DESC LIMIT 25";

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
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="MCH_'.$row['id'].'" data-toggle="modal" data-target="#MachineChecksheetInfoHistoryModal" data-rsir_no="'.$row['rsir_no'].'" data-rsir_type="'.$row['rsir_type'].'" data-machine_name="'.htmlspecialchars($row['machine_name']).'" data-machine_no="'.htmlspecialchars($row['machine_no']).'" data-equipment_no="'.htmlspecialchars($row['equipment_no']).'"  data-judgement_of_eq="'.htmlspecialchars($row['judgement_of_eq']).'" data-repair_details="'.htmlspecialchars($row['repair_details']).'" data-repaired_by="'.htmlspecialchars($row['repaired_by']).'" data-repair_date="'.$row['repair_date'].'" data-next_pm_date="'.$row['next_pm_date'].'" data-judgement_of_prod="'.htmlspecialchars($row['judgement_of_prod']).'" data-inspected_by="'.htmlspecialchars($row['inspected_by']).'" data-confirmed_by="'.htmlspecialchars($row['confirmed_by']).'" data-judgement_by="'.htmlspecialchars($row['judgement_by']).'" data-rsir_process_status="'.$row['rsir_process_status'].'" data-rsir_date="'.date("d-M-y", strtotime($row['rsir_date'])).'" data-file_name="'.htmlspecialchars($row['file_name']).'" data-file_url="'.htmlspecialchars($row['file_url']).'" data-disapproved_by="'.htmlspecialchars($row['disapproved_by']).'" data-disapproved_by_role="'.htmlspecialchars($row['disapproved_by_role']).'" data-disapproved_comment="'.htmlspecialchars($row['disapproved_comment']).'" onclick="get_details_machine_checksheets_history(this)">';
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