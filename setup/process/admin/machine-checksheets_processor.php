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

function generate_mstprc_no($mstprc_no)
{
    if ($mstprc_no == "") {
        $mstprc_no = date("ymdh");
        $rand = substr(md5(microtime()), rand(0, 26), 5);
        $mstprc_no = 'MSTPRC-' . $mstprc_no;
        $mstprc_no = $mstprc_no . '' . $rand;
    }
    return $mstprc_no;
}

function update_notif_count_machine_checksheets($interface, $mstprc_process_status, $conn)
{
    if ($mstprc_process_status != 'Added' && $mstprc_process_status != 'Saved') {
        $sql = "UPDATE notif_setup_approvers";
        if ($mstprc_process_status == 'Confirmed') {
            $sql = $sql . " SET pending_mstprc = pending_mstprc + 1";
        } else if ($mstprc_process_status == 'Approved 1') {
            $sql = $sql . " SET pending_mstprc = pending_mstprc + 1";
        } else if ($mstprc_process_status == 'Approved 2') {
            $sql = $sql . " SET approved_mstprc = approved_mstprc + 1";
        } else if ($mstprc_process_status == 'Disapproved') {
            $sql = $sql . " SET disapproved_mstprc = disapproved_mstprc + 1";
        }
        $sql = $sql . " WHERE interface = '$interface'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}

function machine_checksheets_mark_as_read($mstprc_no, $mstprc_process_status, $interface, $conn)
{
    $sql = "";
    if ($mstprc_process_status == 'Approved 2' || $mstprc_process_status == 'Disapproved') {
        $sql = $sql . "UPDATE setup_mstprc_history";
    } else {
        $sql = $sql . "UPDATE setup_mstprc";
    }
    if ($interface == 'ADMIN-SETUP') {
        $sql = $sql . " SET is_read_setup = 1";
    } else if ($interface == 'APPROVER-1-SAFETY') {
        $sql = $sql . " SET is_read_safety = 1";
    } else if ($interface == 'APPROVER-2-EQ-MGR') {
        $sql = $sql . " SET is_read_eq_mgr = 1";
    } else if ($interface == 'APPROVER-2-EQ-SP') {
        $sql = $sql . " SET is_read_eq_sp = 1";
    } else if ($interface == 'APPROVER-2-PROD-ENGR-MGR') {
        $sql = $sql . " SET is_read_prod_engr_mgr = 1";
    } else if ($interface == 'APPROVER-2-PROD-SV') {
        $sql = $sql . " SET is_read_prod_sv = 1";
    } else if ($interface == 'APPROVER-2-PROD-MGR') {
        $sql = $sql . " SET is_read_prod_mgr = 1";
    } else if ($interface == 'APPROVER-2-QA-SV') {
        $sql = $sql . " SET is_read_qa_sv = 1";
    } else if ($interface == 'APPROVER-2-QA-MGR') {
        $sql = $sql . " SET is_read_qa_mgr = 1";
    }
    $sql = $sql . " WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($mstprc_process_status != 'Added' && $mstprc_process_status != 'Saved' && $mstprc_process_status != 'Returned') {
        $sql = "UPDATE notif_setup_approvers";
        if ($mstprc_process_status == 'Confirmed') {
            $sql = $sql . " SET pending_mstprc = CASE WHEN pending_mstprc > 0 THEN pending_mstprc - 1 END";
        } else if ($mstprc_process_status == 'Approved 1') {
            $sql = $sql . " SET pending_mstprc = CASE WHEN pending_mstprc > 0 THEN pending_mstprc - 1 END";
        } else if ($mstprc_process_status == 'Approved 2') {
            $sql = $sql . " SET approved_mstprc = CASE WHEN approved_mstprc > 0 THEN approved_mstprc - 1 END";
        } else if ($mstprc_process_status == 'Disapproved') {
            $sql = $sql . " SET disapproved_mstprc = CASE WHEN disapproved_mstprc > 0 THEN disapproved_mstprc - 1 END";
        }
        $sql = $sql . " WHERE interface = '$interface'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}

// Check MSTPRC that is already on process of approval
function check_setup_mstprc_on_process($machine_no, $equipment_no, $conn)
{
    $sql = "SELECT id FROM setup_mstprc WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no' AND mstprc_process_status != 'Returned'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo true;
    } else {
        echo false;
    }
}

// Check MSTPRC No. that is already on table with returned status
function check_setup_mstprc_no_returned($mstprc_no, $conn)
{
    $mstprc_no_exist = false;
    $fat_no_exist = false;
    $sou_no_exist = false;
    $rsir_no_exist = false;
    $fat_no = '';
    $sou_no = '';
    $rsir_no = '';

    $sql = "SELECT mstprc_no, fat_no, sou_no, rsir_no FROM setup_mstprc WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $mstprc_no_exist = true;
        foreach ($stmt->fetchAll() as $row) {
            if (!empty($row['fat_no'])) {
                $fat_no = $row['fat_no'];
                $fat_no_exist = true;
            }
            if (!empty($row['sou_no'])) {
                $sou_no = $row['sou_no'];
                $sou_no_exist = true;
            }
            if (!empty($row['rsir_no'])) {
                $rsir_no = $row['rsir_no'];
                $rsir_no_exist = true;
            }
        }
    }

    $mstprc_no_returned_arr = array(
        'mstprc_no_exist' => $mstprc_no_exist,
        'fat_no_exist' => $fat_no_exist,
        'sou_no_exist' => $sou_no_exist,
        'rsir_no_exist' => $rsir_no_exist,
        'fat_no' => $fat_no,
        'sou_no' => $sou_no,
        'rsir_no' => $rsir_no
    );

    return $mstprc_no_returned_arr;
}

// Check MSTPRC File
function check_mstprc_file($mstprc_file_info, $action, $conn)
{
    $message = "";
    $hasError = 0;
    $file_valid_arr = array(0, 0, 0, 0);

    $mimes = array('application/vnd.ms-excel', 'application/excel', 'application/msexcel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-word', 'application/word', 'application/vnd.msword', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.oasis.opendocument.text');

    /*$mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');*/

    /*$mimes = array('application/pdf', 'application/x-pdf', 'application/x-bzpdf', 'application/x-gzpdf', 'applications/vnd.pdf', 'application/acrobat', 'application/x-google-chrome-pdf', 'text/pdf', 'text/x-pdf');*/

    // Check File Mimes
    if (!in_array($mstprc_file_info['mstprc_filetype'], $mimes)) {
        $hasError = 1;
        $file_valid_arr[0] = 1;
    }
    // Check File Size
    if ($mstprc_file_info['mstprc_size'] > 25000000) {
        $hasError = 1;
        $file_valid_arr[1] = 1;
    }

    // Check File Exists
    if (file_exists($mstprc_file_info['target_file'])) {
        if ($action == 'Insert') {
            $hasError = 1;
            $file_valid_arr[2] = 1;
        } else if ($mstprc_file_info['old_mstprc_filename'] != $mstprc_file_info['mstprc_filename']) {
            $hasError = 1;
            $file_valid_arr[2] = 1;
        }
    }
    // Check File Information Exists on Database
    $mstprc_filename = addslashes($mstprc_file_info['mstprc_filename']);
    $mstprc_filetype = addslashes($mstprc_file_info['mstprc_filetype']);
    $mstprc_url = addslashes($mstprc_file_info['mstprc_url']);
    $sql = "SELECT id FROM setup_mstprc WHERE file_name = '$mstprc_filename' AND file_type = '$mstprc_filetype' AND file_url = '$mstprc_url'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        if ($action == 'Insert') {
            $hasError = 1;
            $file_valid_arr[3] = 1;
        } else if ($mstprc_file_info['old_mstprc_filename'] != $mstprc_file_info['mstprc_filename']) {
            $hasError = 1;
            $file_valid_arr[3] = 1;
        }
    }
    // Check File Information Exists on Database (History)
    $sql = "SELECT id FROM setup_mstprc_history WHERE file_name = '$mstprc_filename' AND file_type = '$mstprc_filetype' AND file_url = '$mstprc_url'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        if ($action == 'Insert') {
            $hasError = 1;
            $file_valid_arr[3] = 1;
        } else if ($mstprc_file_info['old_mstprc_filename'] != $mstprc_file_info['mstprc_filename']) {
            $hasError = 1;
            $file_valid_arr[3] = 1;
        }
    }

    // Error Collection and Output
    if ($hasError == 1) {
        if ($file_valid_arr[0] == 1) {
            $message = $message . 'MSTPRC file format not accepted! ';
        }
        if ($file_valid_arr[1] == 1) {
            $message = $message . 'MSTPRC file is too large. ';
        }
        if ($file_valid_arr[2] == 1) {
            $message = $message . 'MSTPRC file exists. ';
        }
        if ($file_valid_arr[3] == 1) {
            $message = $message . 'MSTPRC file information exists on the system. ';
        }
    }

    return $message;
}

// Insert File Information
function save_mstprc_setup_info($mstprc_file_info, $conn)
{
    $mstprc_no = $mstprc_file_info['mstprc_no'];
    $mstprc_type = $mstprc_file_info['mstprc_type'];
    $machine_name = addslashes($mstprc_file_info['machine_name']);
    $machine_no = addslashes($mstprc_file_info['machine_no']);
    $equipment_no = addslashes($mstprc_file_info['equipment_no']);
    $mstprc_date = date_create($mstprc_file_info['mstprc_date']);
    $mstprc_date = date_format($mstprc_date, "Y-m-d");
    $car_model = addslashes($mstprc_file_info['car_model']);
    $location = addslashes($mstprc_file_info['location']);
    $grid = addslashes($mstprc_file_info['grid']);
    $is_new = $mstprc_file_info['is_new'];
    $mstprc_eq_member = addslashes($_SESSION['setup_name']);
    $mstprc_username = addslashes($_SESSION['setup_username']);
    $fat_no = addslashes($mstprc_file_info['fat_no']);
    if (isset($mstprc_file_info['sou_no'])) {
        $sou_no = addslashes($mstprc_file_info['sou_no']);
    } else {
        $sou_no = '';
    }
    $mstprc_filename = basename($mstprc_file_info['mstprc_filename']);
    $mstprc_filetype = addslashes($mstprc_file_info['mstprc_filetype']);
    $mstprc_url = addslashes($mstprc_file_info['mstprc_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "INSERT INTO setup_mstprc (mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, mstprc_username, mstprc_eq_member, mstprc_process_status, fat_no, sou_no, file_name, file_type, file_url, date_updated) VALUES ('$mstprc_no','$mstprc_type','$machine_name','$machine_no','$equipment_no','$mstprc_date','$car_model','$location','$grid','$is_new','$mstprc_username','$mstprc_eq_member','Saved','$fat_no','$sou_no','$mstprc_filename','$mstprc_filetype','$mstprc_url','$date_updated')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function update_mstprc_setup_info_returned($mstprc_file_info, $conn)
{
    $mstprc_no = $mstprc_file_info['mstprc_no'];
    $mstprc_type = $mstprc_file_info['mstprc_type'];
    $machine_name = addslashes($mstprc_file_info['machine_name']);
    $machine_no = addslashes($mstprc_file_info['machine_no']);
    $equipment_no = addslashes($mstprc_file_info['equipment_no']);
    $mstprc_date = date_create($mstprc_file_info['mstprc_date']);
    $mstprc_date = date_format($mstprc_date, "Y-m-d");
    $car_model = addslashes($mstprc_file_info['car_model']);
    $location = addslashes($mstprc_file_info['location']);
    $grid = addslashes($mstprc_file_info['grid']);
    $is_new = $mstprc_file_info['is_new'];
    $mstprc_eq_member = addslashes($_SESSION['setup_name']);
    $mstprc_username = addslashes($_SESSION['setup_username']);
    $fat_no = addslashes($mstprc_file_info['fat_no']);
    if (isset($mstprc_file_info['sou_no'])) {
        $sou_no = addslashes($mstprc_file_info['sou_no']);
    } else {
        $sou_no = '';
    }
    if (isset($mstprc_file_info['rsir_no'])) {
        $rsir_no = addslashes($mstprc_file_info['rsir_no']);
    } else {
        $rsir_no = '';
    }
    $mstprc_filename = basename($mstprc_file_info['mstprc_filename']);
    $mstprc_filetype = addslashes($mstprc_file_info['mstprc_filetype']);
    $mstprc_url = addslashes($mstprc_file_info['mstprc_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "UPDATE setup_mstprc SET mstprc_type = '$mstprc_type',machine_name = '$machine_name',machine_no = '$machine_no',equipment_no = '$equipment_no',mstprc_date = '$mstprc_date',car_model = '$car_model',location = '$location',grid = '$grid',is_new = '$is_new',mstprc_username = '$mstprc_username',mstprc_eq_member = '$mstprc_eq_member',mstprc_process_status = 'Saved',fat_no = '$fat_no',sou_no = '$sou_no',rsir_no = '$rsir_no',is_read_setup = 0,file_name = '$mstprc_filename',file_type = '$mstprc_filetype',file_url = '$mstprc_url',date_updated = '$date_updated' WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

// Insert File Information
function save_mstprc_transfer_info($mstprc_file_info, $conn)
{
    $mstprc_no = $mstprc_file_info['mstprc_no'];
    $mstprc_type = $mstprc_file_info['mstprc_type'];
    $machine_name = addslashes($mstprc_file_info['machine_name']);
    $machine_no = addslashes($mstprc_file_info['machine_no']);
    $equipment_no = addslashes($mstprc_file_info['equipment_no']);
    $mstprc_date = date_create($mstprc_file_info['mstprc_date']);
    $mstprc_date = date_format($mstprc_date, "Y-m-d");
    $car_model = addslashes($mstprc_file_info['car_model']);
    $location = addslashes($mstprc_file_info['location']);
    $grid = addslashes($mstprc_file_info['grid']);
    $to_car_model = addslashes($mstprc_file_info['to_car_model']);
    $to_location = addslashes($mstprc_file_info['to_location']);
    $to_grid = addslashes($mstprc_file_info['to_grid']);
    $transfer_reason = addslashes($mstprc_file_info['transfer_reason']);
    $mstprc_eq_member = addslashes($_SESSION['setup_name']);
    $mstprc_username = addslashes($_SESSION['setup_username']);
    $fat_no = addslashes($mstprc_file_info['fat_no']);
    $mstprc_filename = basename($mstprc_file_info['mstprc_filename']);
    $mstprc_filetype = addslashes($mstprc_file_info['mstprc_filetype']);
    $mstprc_url = addslashes($mstprc_file_info['mstprc_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "INSERT INTO setup_mstprc (mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, transfer_reason, mstprc_username, mstprc_eq_member, mstprc_process_status, fat_no, file_name, file_type, file_url, date_updated) VALUES ('$mstprc_no','$mstprc_type','$machine_name','$machine_no','$equipment_no','$mstprc_date','$car_model','$location','$grid','$to_car_model','$to_location','$to_grid','$transfer_reason','$mstprc_username','$mstprc_eq_member','Saved','$fat_no','$mstprc_filename','$mstprc_filetype','$mstprc_url','$date_updated')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function update_mstprc_transfer_info_returned($mstprc_file_info, $conn)
{
    $mstprc_no = $mstprc_file_info['mstprc_no'];
    $mstprc_type = $mstprc_file_info['mstprc_type'];
    $machine_name = addslashes($mstprc_file_info['machine_name']);
    $machine_no = addslashes($mstprc_file_info['machine_no']);
    $equipment_no = addslashes($mstprc_file_info['equipment_no']);
    $mstprc_date = date_create($mstprc_file_info['mstprc_date']);
    $mstprc_date = date_format($mstprc_date, "Y-m-d");
    $car_model = addslashes($mstprc_file_info['car_model']);
    $location = addslashes($mstprc_file_info['location']);
    $grid = addslashes($mstprc_file_info['grid']);
    $to_car_model = addslashes($mstprc_file_info['to_car_model']);
    $to_location = addslashes($mstprc_file_info['to_location']);
    $to_grid = addslashes($mstprc_file_info['to_grid']);
    $transfer_reason = addslashes($mstprc_file_info['transfer_reason']);
    $mstprc_eq_member = addslashes($_SESSION['setup_name']);
    $mstprc_username = addslashes($_SESSION['setup_username']);
    $fat_no = addslashes($mstprc_file_info['fat_no']);
    $mstprc_filename = basename($mstprc_file_info['mstprc_filename']);
    $mstprc_filetype = addslashes($mstprc_file_info['mstprc_filetype']);
    $mstprc_url = addslashes($mstprc_file_info['mstprc_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "UPDATE setup_mstprc SET mstprc_type = '$mstprc_type',machine_name = '$machine_name',machine_no = '$machine_no',equipment_no = '$equipment_no',mstprc_date = '$mstprc_date',car_model = '$car_model',location = '$location',grid = '$grid',to_car_model = '$to_car_model',to_location = '$to_location',to_grid = '$to_grid',transfer_reason = '$transfer_reason',mstprc_username = '$mstprc_username',mstprc_eq_member = '$mstprc_eq_member',mstprc_process_status = 'Saved',fat_no = '$fat_no',is_read_setup = 0,file_name = '$mstprc_filename',file_type = '$mstprc_filetype',file_url = '$mstprc_url',date_updated = '$date_updated' WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

// Insert File Information
function save_mstprc_pullout_info($mstprc_file_info, $conn)
{
    $mstprc_no = $mstprc_file_info['mstprc_no'];
    $mstprc_type = $mstprc_file_info['mstprc_type'];
    $machine_name = addslashes($mstprc_file_info['machine_name']);
    $machine_no = addslashes($mstprc_file_info['machine_no']);
    $equipment_no = addslashes($mstprc_file_info['equipment_no']);
    $mstprc_date = date_create($mstprc_file_info['mstprc_date']);
    $mstprc_date = date_format($mstprc_date, "Y-m-d");
    $car_model = addslashes($mstprc_file_info['car_model']);
    $location = addslashes($mstprc_file_info['location']);
    $grid = addslashes($mstprc_file_info['grid']);
    $pullout_location = addslashes($mstprc_file_info['pullout_location']);
    $pullout_reason = addslashes($mstprc_file_info['pullout_reason']);
    $mstprc_eq_member = addslashes($_SESSION['setup_name']);
    $mstprc_username = addslashes($_SESSION['setup_username']);
    $fat_no = addslashes($mstprc_file_info['fat_no']);
    $mstprc_filename = basename($mstprc_file_info['mstprc_filename']);
    $mstprc_filetype = addslashes($mstprc_file_info['mstprc_filetype']);
    $mstprc_url = addslashes($mstprc_file_info['mstprc_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "INSERT INTO setup_mstprc (mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, pullout_location, pullout_reason, mstprc_username, mstprc_eq_member, mstprc_process_status, fat_no, file_name, file_type, file_url, date_updated) VALUES ('$mstprc_no','$mstprc_type','$machine_name','$machine_no','$equipment_no','$mstprc_date','$car_model','$location','$grid','$pullout_location','$pullout_reason','$mstprc_username','$mstprc_eq_member','Saved','$fat_no','$mstprc_filename','$mstprc_filetype','$mstprc_url','$date_updated')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function update_mstprc_pullout_info_returned($mstprc_file_info, $conn)
{
    $mstprc_no = $mstprc_file_info['mstprc_no'];
    $mstprc_type = $mstprc_file_info['mstprc_type'];
    $machine_name = addslashes($mstprc_file_info['machine_name']);
    $machine_no = addslashes($mstprc_file_info['machine_no']);
    $equipment_no = addslashes($mstprc_file_info['equipment_no']);
    $mstprc_date = date_create($mstprc_file_info['mstprc_date']);
    $mstprc_date = date_format($mstprc_date, "Y-m-d");
    $car_model = addslashes($mstprc_file_info['car_model']);
    $location = addslashes($mstprc_file_info['location']);
    $grid = addslashes($mstprc_file_info['grid']);
    $pullout_location = addslashes($mstprc_file_info['pullout_location']);
    $pullout_reason = addslashes($mstprc_file_info['pullout_reason']);
    $mstprc_eq_member = addslashes($_SESSION['setup_name']);
    $mstprc_username = addslashes($_SESSION['setup_username']);
    $fat_no = addslashes($mstprc_file_info['fat_no']);
    $mstprc_filename = basename($mstprc_file_info['mstprc_filename']);
    $mstprc_filetype = addslashes($mstprc_file_info['mstprc_filetype']);
    $mstprc_url = addslashes($mstprc_file_info['mstprc_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "UPDATE setup_mstprc SET mstprc_type = '$mstprc_type',machine_name = '$machine_name',machine_no = '$machine_no',equipment_no = '$equipment_no',mstprc_date = '$mstprc_date',car_model = '$car_model',location = '$location',grid = '$grid',pullout_location = '$pullout_location',pullout_reason = '$pullout_reason',mstprc_username = '$mstprc_username',mstprc_eq_member = '$mstprc_eq_member',mstprc_process_status = 'Saved',fat_no = '$fat_no',is_read_setup = 0,file_name = '$mstprc_filename',file_type = '$mstprc_filetype',file_url = '$mstprc_url',date_updated = '$date_updated' WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

// Insert File Information
function save_mstprc_relayout_info($mstprc_file_info, $conn)
{
    $mstprc_no = $mstprc_file_info['mstprc_no'];
    $mstprc_type = $mstprc_file_info['mstprc_type'];
    $machine_name = addslashes($mstprc_file_info['machine_name']);
    $machine_no = addslashes($mstprc_file_info['machine_no']);
    $equipment_no = addslashes($mstprc_file_info['equipment_no']);
    $mstprc_date = date_create($mstprc_file_info['mstprc_date']);
    $mstprc_date = date_format($mstprc_date, "Y-m-d");
    $car_model = addslashes($mstprc_file_info['car_model']);
    $location = addslashes($mstprc_file_info['location']);
    $grid = addslashes($mstprc_file_info['grid']);
    $mstprc_eq_member = addslashes($_SESSION['setup_name']);
    $mstprc_username = addslashes($_SESSION['setup_username']);
    $fat_no = addslashes($mstprc_file_info['fat_no']);
    $mstprc_filename = basename($mstprc_file_info['mstprc_filename']);
    $mstprc_filetype = addslashes($mstprc_file_info['mstprc_filetype']);
    $mstprc_url = addslashes($mstprc_file_info['mstprc_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "INSERT INTO setup_mstprc (mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, mstprc_username, mstprc_eq_member, mstprc_process_status, fat_no, file_name, file_type, file_url, date_updated) VALUES ('$mstprc_no','$mstprc_type','$machine_name','$machine_no','$equipment_no','$mstprc_date','$car_model','$location','$grid','$mstprc_username','$mstprc_eq_member','Saved','$fat_no','$mstprc_filename','$mstprc_filetype','$mstprc_url','$date_updated')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function update_mstprc_relayout_info_returned($mstprc_file_info, $conn)
{
    $mstprc_no = $mstprc_file_info['mstprc_no'];
    $mstprc_type = $mstprc_file_info['mstprc_type'];
    $machine_name = addslashes($mstprc_file_info['machine_name']);
    $machine_no = addslashes($mstprc_file_info['machine_no']);
    $equipment_no = addslashes($mstprc_file_info['equipment_no']);
    $mstprc_date = date_create($mstprc_file_info['mstprc_date']);
    $mstprc_date = date_format($mstprc_date, "Y-m-d");
    $car_model = addslashes($mstprc_file_info['car_model']);
    $location = addslashes($mstprc_file_info['location']);
    $grid = addslashes($mstprc_file_info['grid']);
    $mstprc_eq_member = addslashes($_SESSION['setup_name']);
    $mstprc_username = addslashes($_SESSION['setup_username']);
    $fat_no = addslashes($mstprc_file_info['fat_no']);
    $mstprc_filename = basename($mstprc_file_info['mstprc_filename']);
    $mstprc_filetype = addslashes($mstprc_file_info['mstprc_filetype']);
    $mstprc_url = addslashes($mstprc_file_info['mstprc_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "UPDATE setup_mstprc SET mstprc_type = '$mstprc_type',machine_name = '$machine_name',machine_no = '$machine_no',equipment_no = '$equipment_no',mstprc_date = '$mstprc_date',car_model = '$car_model',location = '$location',grid = '$grid',mstprc_username = '$mstprc_username',mstprc_eq_member = '$mstprc_eq_member',mstprc_process_status = 'Saved',fat_no = '$fat_no',is_read_setup = 0,file_name = '$mstprc_filename',file_type = '$mstprc_filetype',file_url = '$mstprc_url',date_updated = '$date_updated' WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function save_fat($fat_info, $conn)
{
    $item_description = addslashes($fat_info['item_description']);
    $item_name = addslashes($fat_info['item_name']);
    $machine_no = addslashes($fat_info['machine_no']);
    $equipment_no = addslashes($fat_info['equipment_no']);
    $asset_tag_no = addslashes($fat_info['asset_tag_no']);
    $prev_location_group = addslashes($fat_info['prev_group']);
    $prev_location_loc = addslashes($fat_info['prev_location']);
    $prev_location_grid = addslashes($fat_info['prev_grid']);
    $new_location_group = addslashes($fat_info['new_group']);
    $new_location_loc = addslashes($fat_info['new_location']);
    $new_location_grid = addslashes($fat_info['new_grid']);
    $reason = addslashes($fat_info['reason']);
    $date_transfer = date_create($fat_info['date_transfer']);
    $date_transfer = date_format($date_transfer, "Y-m-d H:i:s");
    $date_updated = date('Y-m-d H:i:s');

    $fat_no = date("ymdh");
    $rand = substr(md5(microtime()), rand(0, 26), 5);
    $fat_no = 'FAT:' . $fat_no;
    $fat_no = $fat_no . '' . $rand;

    $sql = "INSERT INTO fat_forms (fat_no, item_name, item_description, machine_no, equipment_no, asset_tag_no, prev_location_group, prev_location_loc, prev_location_grid, date_transfer, new_location_group, new_location_loc, new_location_grid, reason, fat_status) VALUES ('$fat_no', '$item_name', '$item_description', '$machine_no', '$equipment_no', '$asset_tag_no', '$prev_location_group', '$prev_location_loc', '$prev_location_grid', '$date_transfer', '$new_location_group', '$new_location_loc', '$new_location_grid', '$reason', 'Saved')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $fat_no;
}

function update_fat_returned($fat_info, $fat_no, $conn)
{
    $item_description = addslashes($fat_info['item_description']);
    $item_name = addslashes($fat_info['item_name']);
    $machine_no = addslashes($fat_info['machine_no']);
    $equipment_no = addslashes($fat_info['equipment_no']);
    $asset_tag_no = addslashes($fat_info['asset_tag_no']);
    $prev_location_group = addslashes($fat_info['prev_group']);
    $prev_location_loc = addslashes($fat_info['prev_location']);
    $prev_location_grid = addslashes($fat_info['prev_grid']);
    $new_location_group = addslashes($fat_info['new_group']);
    $new_location_loc = addslashes($fat_info['new_location']);
    $new_location_grid = addslashes($fat_info['new_grid']);
    $reason = addslashes($fat_info['reason']);
    $date_transfer = date_create($fat_info['date_transfer']);
    $date_transfer = date_format($date_transfer, "Y-m-d H:i:s");
    $date_updated = date('Y-m-d H:i:s');

    $sql = "UPDATE fat_forms SET item_name = '$item_name',item_description = '$item_description',machine_no = '$machine_no',equipment_no = '$equipment_no',asset_tag_no = '$asset_tag_no',prev_location_group = '$prev_location_group',prev_location_loc = '$prev_location_loc',prev_location_grid = '$prev_location_grid',date_transfer = '$date_transfer',new_location_group = '$new_location_group',new_location_loc = '$new_location_loc',new_location_grid = '$new_location_grid',reason = '$reason',fat_status = 'Saved',date_updated = '$date_updated' WHERE fat_no = '$fat_no'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

function save_sou($sou_info, $conn)
{
    $kigyo_no = addslashes($sou_info['kigyo_no']);
    $asset_name = addslashes($sou_info['asset_name']);
    $sup_asset_name = addslashes($sou_info['sup_asset_name']);
    $orig_asset_no = addslashes($sou_info['orig_asset_no']);
    $sou_date = date_create($sou_info['sou_date']);
    $sou_date = date_format($sou_date, "Y-m-d");
    $sou_quantity = $sou_info['sou_quantity'];
    $managing_dept_code = addslashes($sou_info['managing_dept_code']);
    $managing_dept_name = addslashes($sou_info['managing_dept_name']);
    $install_area_code = addslashes($sou_info['install_area_code']);
    $install_area_name = addslashes($sou_info['install_area_name']);
    $machine_no = addslashes($sou_info['machine_no']);
    $equipment_no = addslashes($sou_info['equipment_no']);
    $no_of_units = $sou_info['no_of_units'];
    $ntc_or_sa = $sou_info['ntc_or_sa'];
    $use_purpose = addslashes($sou_info['use_purpose']);

    $sou_no = date("ymdh");
    $rand = substr(md5(microtime()), rand(0, 26), 5);
    $sou_no = 'SOU:' . $sou_no;
    $sou_no = $sou_no . '' . $rand;

    $sql = "INSERT INTO sou_forms (sou_no, kigyo_no, asset_name, sup_asset_name, orig_asset_no, sou_date, quantity, managing_dept_code, managing_dept_name, install_area_code, install_area_name, machine_no, equipment_no, no_of_units, ntc_or_sa, use_purpose, sou_status) VALUES ('$sou_no', '$kigyo_no', '$asset_name', '$sup_asset_name', '$orig_asset_no', '$sou_date', '$sou_quantity', '$managing_dept_code', '$managing_dept_name', '$install_area_code', '$install_area_name', '$machine_no', '$equipment_no', '$no_of_units', '$ntc_or_sa', '$use_purpose', 'Saved')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $sou_no;
}

function update_sou_returned($sou_info, $sou_no, $conn)
{
    $kigyo_no = addslashes($sou_info['kigyo_no']);
    $asset_name = addslashes($sou_info['asset_name']);
    $sup_asset_name = addslashes($sou_info['sup_asset_name']);
    $orig_asset_no = addslashes($sou_info['orig_asset_no']);
    $sou_date = date_create($sou_info['sou_date']);
    $sou_date = date_format($sou_date, "Y-m-d");
    $sou_quantity = $sou_info['sou_quantity'];
    $managing_dept_code = addslashes($sou_info['managing_dept_code']);
    $managing_dept_name = addslashes($sou_info['managing_dept_name']);
    $install_area_code = addslashes($sou_info['install_area_code']);
    $install_area_name = addslashes($sou_info['install_area_name']);
    $machine_no = addslashes($sou_info['machine_no']);
    $equipment_no = addslashes($sou_info['equipment_no']);
    $no_of_units = $sou_info['no_of_units'];
    $ntc_or_sa = $sou_info['ntc_or_sa'];
    $use_purpose = addslashes($sou_info['use_purpose']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "UPDATE sou_forms SET kigyo_no = '$kigyo_no',asset_name = '$asset_name',sup_asset_name = '$sup_asset_name',orig_asset_no = '$orig_asset_no',sou_date = '$sou_date',quantity = '$sou_quantity',managing_dept_code = '$managing_dept_code',managing_dept_name = '$managing_dept_name',install_area_code = '$install_area_code',install_area_name = '$install_area_name',machine_no = '$machine_no',equipment_no = '$equipment_no',no_of_units = '$no_of_units',ntc_or_sa = '$ntc_or_sa',use_purpose = '$use_purpose',sou_status = 'Saved',date_updated = '$date_updated' WHERE sou_no = '$sou_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

if ($method == 'goto_mstprc_setup_step2') {
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $machine_name = $_POST['machine_name'];
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $grid = $_POST['grid'];
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $is_new = $_POST['is_new'];
    $mstprc_date = $_POST['mstprc_date'];
    $mstprc_no = $_POST['mstprc_no'];
    $mstprc_username = $_SESSION['setup_username'];
    $message = '';

    $is_valid = false;

    if (!empty($machine_no) || !empty($equipment_no)) {
        if (!empty($machine_name)) {
            $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
            if ($machine_info['registered'] == true) {
                if (!empty($mstprc_date)) {
                    if ($machine_info['machine_status'] == 'UNUSED' || ($machine_info['machine_status'] == '' && $machine_info['is_new'] == 1)) {
                        $on_process = check_setup_mstprc_on_process($machine_no, $equipment_no, $conn);
                        if ($on_process == false) {
                            $is_valid = true;
                        } else
                            $message = 'Checksheet On Process';
                    } else
                        $message = 'Not For Setup';
                } else
                    $message = 'Date Not Set';
            } else
                $message = 'Unregistered Machine';
        } else
            $message = 'Forgotten Enter Key';
    } else
        $message = "Machine Indentification Empty";

    if ($is_valid == true) {
        if (!empty($mstprc_no)) {
            $message = 'success';
        } else {
            $mstprc_no = generate_mstprc_no($mstprc_no);
            $message = 'success';
        }
    }

    $response_arr = array(
        'mstprc_no' => $mstprc_no,
        'message' => $message
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'goto_mstprc_transfer_step2') {
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $machine_name = $_POST['machine_name'];
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $grid = $_POST['grid'];
    $asset_tag_no = $_POST['asset_tag_no'];
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $mstprc_date = $_POST['mstprc_date'];
    $mstprc_no = $_POST['mstprc_no'];
    $to_car_model = custom_trim($_POST['to_car_model']);
    $to_location = custom_trim($_POST['to_location']);
    $to_grid = custom_trim($_POST['to_grid']);
    $transfer_reason = $_POST['transfer_reason'];
    $mstprc_username = $_SESSION['setup_username'];
    $message = '';

    $is_valid = false;

    if (!empty($machine_no) || !empty($equipment_no)) {
        if (!empty($machine_name)) {
            $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
            if ($machine_info['registered'] == true) {
                if (!empty($mstprc_date)) {
                    if (!empty($to_car_model)) {
                        if (!empty($to_location)) {
                            if (($machine_info['machine_status'] == 'Setup' || $machine_info['machine_status'] == 'Transfer' || $machine_info['machine_status'] == 'Relayout') && $machine_info['is_new'] == 0) {
                                $on_process = check_setup_mstprc_on_process($machine_no, $equipment_no, $conn);
                                if ($on_process == false) {
                                    $is_valid = true;
                                } else
                                    $message = 'Checksheet On Process';
                            } else
                                $message = 'Not For Transfer';
                        } else
                            $message = 'To Location Not Set';
                    } else
                        $message = 'To Car Model Empty';
                } else
                    $message = 'Date Not Set';
            } else
                $message = 'Unregistered Machine';
        } else
            $message = 'Forgotten Enter Key';
    } else
        $message = "Machine Indentification Empty";

    if ($is_valid == true) {
        if (!empty($mstprc_no)) {
            $message = 'success';
        } else {
            $mstprc_no = generate_mstprc_no($mstprc_no);
            $message = 'success';
        }
    }

    $response_arr = array(
        'mstprc_no' => $mstprc_no,
        'message' => $message
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'goto_mstprc_pullout_step2') {
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $machine_name = $_POST['machine_name'];
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $grid = $_POST['grid'];
    $asset_tag_no = $_POST['asset_tag_no'];
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $mstprc_date = $_POST['mstprc_date'];
    $mstprc_no = $_POST['mstprc_no'];
    $pullout_reason = $_POST['pullout_reason'];
    $pullout_location = $_POST['pullout_location'];
    $mstprc_username = $_SESSION['setup_username'];
    $message = '';

    $is_valid = false;

    if (!empty($machine_no) || !empty($equipment_no)) {
        if (!empty($machine_name)) {
            $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
            if ($machine_info['registered'] == true) {
                if (!empty($mstprc_date)) {
                    if (!empty($pullout_location)) {
                        if (!empty($pullout_reason)) {
                            if (($machine_info['machine_status'] == 'Setup' || $machine_info['machine_status'] == 'Transfer' || $machine_info['machine_status'] == 'Relayout') && $machine_info['is_new'] == 0) {
                                $on_process = check_setup_mstprc_on_process($machine_no, $equipment_no, $conn);
                                if ($on_process == false) {
                                    $is_valid = true;
                                } else
                                    $message = 'Checksheet On Process';
                            } else
                                $message = 'Not For Pullout';
                        } else
                            $message = 'Pullout Reason Empty';
                    } else
                        $message = 'Pullout Location Empty';
                } else
                    $message = 'Date Not Set';
            } else
                $message = 'Unregistered Machine';
        } else
            $message = 'Forgotten Enter Key';
    } else
        $message = "Machine Indentification Empty";

    if ($is_valid == true) {
        if (!empty($mstprc_no)) {
            $message = 'success';
        } else {
            $mstprc_no = generate_mstprc_no($mstprc_no);
            $message = 'success';
        }
    }

    $response_arr = array(
        'mstprc_no' => $mstprc_no,
        'message' => $message
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'goto_mstprc_relayout_step2') {
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $machine_name = $_POST['machine_name'];
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $grid = $_POST['grid'];
    $asset_tag_no = $_POST['asset_tag_no'];
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $mstprc_date = $_POST['mstprc_date'];
    $mstprc_no = $_POST['mstprc_no'];
    $mstprc_username = $_SESSION['setup_username'];
    $message = '';

    $is_valid = false;

    if (!empty($machine_no) || !empty($equipment_no)) {
        if (!empty($machine_name)) {
            $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
            if ($machine_info['registered'] == true) {
                if (!empty($mstprc_date)) {
                    if (($machine_info['machine_status'] == 'Setup' || $machine_info['machine_status'] == 'Transfer' || $machine_info['machine_status'] == 'Relayout') && $machine_info['is_new'] == 0) {
                        $on_process = check_setup_mstprc_on_process($machine_no, $equipment_no, $conn);
                        if ($on_process == false) {
                            $is_valid = true;
                        } else
                            $message = 'Checksheet On Process';
                    } else
                        $message = 'Not For Pullout';
                } else
                    $message = 'Date Not Set';
            } else
                $message = 'Unregistered Machine';
        } else
            $message = 'Forgotten Enter Key';
    } else
        $message = "Machine Indentification Empty";

    if ($is_valid == true) {
        if (!empty($mstprc_no)) {
            $message = 'success';
        } else {
            $mstprc_no = generate_mstprc_no($mstprc_no);
            $message = 'success';
        }
    }

    $response_arr = array(
        'mstprc_no' => $mstprc_no,
        'message' => $message
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'check_setup_fat') {
    $item_description = custom_trim($_POST['item_description']);
    $item_name = custom_trim($_POST['item_name']);
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $asset_tag_no = $_POST['asset_tag_no'];
    $prev_group = custom_trim($_POST['prev_group']);
    $prev_location = custom_trim($_POST['prev_location']);
    $prev_grid = custom_trim($_POST['prev_grid']);
    $new_group = custom_trim($_POST['new_group']);
    $new_location = custom_trim($_POST['new_location']);
    $new_grid = custom_trim($_POST['new_grid']);
    $date_transfer = $_POST['date_transfer'];
    $reason = custom_trim($_POST['reason']);

    $is_valid = false;

    if (!empty($prev_group) && !empty($prev_location)) {
        if (!empty($new_group) && !empty($new_location)) {
            if (!empty($date_transfer)) {
                if (!empty($reason)) {
                    $is_valid = true;
                } else
                    echo 'FAT Reason Empty';
            } else
                echo 'FAT Date Transfer Not Set';
        } else
            echo 'FAT New Group-Location Not Set';
    } else
        echo 'FAT Prev Group-Location Not Set';

    if ($is_valid == true) {
        echo 'success';
    }
}

if ($method == 'check_mstprc_file') {
    $mstprc_no = $_POST['mstprc_no'];

    // Upload File
    if (!empty($_FILES['file']['name'])) {
        $mstprc_file = $_FILES['file']['tmp_name'];
        $mstprc_filename = $_FILES['file']['name'];
        $mstprc_filetype = $_FILES['file']['type'];
        $mstprc_size = $_FILES['file']['size'];

        //$mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/setup/uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        //$target_dir = "../../uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        $mstprc_url = "http://" . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . "/uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";
        $target_dir = "../../../../uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";

        $mstprc_filename = $mstprc_no . "-" . $mstprc_filename;

        $target_file = $target_dir . basename($mstprc_filename);
        $mstprc_url .= rawurlencode(basename($mstprc_filename));

        $mstprc_file_info = array(
            'mstprc_file' => $mstprc_file,
            'mstprc_filename' => $mstprc_filename,
            'mstprc_filetype' => $mstprc_filetype,
            'mstprc_size' => $mstprc_size,
            'target_file' => $target_file,
            'mstprc_url' => $mstprc_url
        );

        // Check MSTPRC File
        $chkMstprcFileMsg = check_mstprc_file($mstprc_file_info, 'Insert', $conn);

        if ($chkMstprcFileMsg != '') {
            echo $chkMstprcFileMsg;
        }

    } else {
        echo 'Please upload MSTPRC file';
    }
}

// TO BE CONTINUED

if ($method == 'save_mstprc_setup_1') {
    $mstprc_no = $_POST['mstprc_no'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $machine_name = $_POST['machine_name'];
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $grid = $_POST['grid'];
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $is_new = $_POST['is_new'];
    $mstprc_type = 'Setup';
    $mstprc_date = $_POST['mstprc_date'];

    $item_description = custom_trim($_POST['item_description']);
    $item_name = custom_trim($_POST['item_name']);
    $fat_machine_no = custom_trim($_POST['fat_machine_no']);
    $fat_equipment_no = custom_trim($_POST['fat_equipment_no']);
    $asset_tag_no = $_POST['asset_tag_no'];
    $prev_group = custom_trim($_POST['prev_group']);
    $prev_location = custom_trim($_POST['prev_location']);
    $prev_grid = custom_trim($_POST['prev_grid']);
    $new_group = custom_trim($_POST['new_group']);
    $new_location = custom_trim($_POST['new_location']);
    $new_grid = custom_trim($_POST['new_grid']);
    $date_transfer = $_POST['date_transfer'];
    $reason = custom_trim($_POST['reason']);

    $is_valid = false;

    if (!empty($prev_group) && !empty($prev_location)) {
        if (!empty($new_group) && !empty($new_location)) {
            if (!empty($date_transfer)) {
                if (!empty($reason)) {
                    $is_valid = true;
                } else
                    echo 'FAT Reason Empty';
            } else
                echo 'FAT Date Transfer Not Set';
        } else
            echo 'FAT New Group-Location Not Set';
    } else
        echo 'FAT Prev Group-Location Not Set';

    if ($is_valid == true) {
        $mstprc_file = $_FILES['file']['tmp_name'];
        $mstprc_filename = $_FILES['file']['name'];
        $mstprc_filetype = $_FILES['file']['type'];
        $mstprc_size = $_FILES['file']['size'];

        //$mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/setup/uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        //$target_dir = "../../uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        // $mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/setup/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        $mstprc_url = "/uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";
        $target_dir = "../../../../uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";

        // Add Folder If Not Exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $mstprc_filename = $mstprc_no . "-" . $mstprc_filename;

        $target_file = $target_dir . basename($mstprc_filename);
        $mstprc_url .= rawurlencode(basename($mstprc_filename));

        // Upload File and Check if successfully uploaded
        // Note: Can overwrite existing file
        if (move_uploaded_file($mstprc_file, $target_file)) {

            $fat_info = array(
                'item_description' => $item_description,
                'item_name' => $item_name,
                'machine_no' => $fat_machine_no,
                'equipment_no' => $fat_equipment_no,
                'asset_tag_no' => $asset_tag_no,
                'prev_group' => $prev_group,
                'prev_location' => $prev_location,
                'prev_grid' => $prev_grid,
                'new_group' => $new_group,
                'new_location' => $new_location,
                'new_grid' => $new_grid,
                'date_transfer' => $date_transfer,
                'reason' => $reason
            );

            $mstprc_no_returned_arr = check_setup_mstprc_no_returned($mstprc_no, $conn);

            if (
                $mstprc_no_returned_arr['mstprc_no_exist'] == true
                && $mstprc_no_returned_arr['fat_no_exist'] == true
            ) {
                update_fat_returned($fat_info, $mstprc_no_returned_arr['fat_no'], $conn);

                $mstprc_file_info = array(
                    'mstprc_no' => $mstprc_no,
                    'machine_no' => $machine_no,
                    'equipment_no' => $equipment_no,
                    'machine_name' => $machine_name,
                    'car_model' => $new_group,
                    'location' => $new_location,
                    'grid' => $new_grid,
                    'trd_no' => $trd_no,
                    'ns_iv_no' => $ns_iv_no,
                    'is_new' => $is_new,
                    'mstprc_type' => $mstprc_type,
                    'mstprc_date' => $mstprc_date,
                    'fat_no' => $mstprc_no_returned_arr['fat_no'],
                    'rsir_no' => $mstprc_no_returned_arr['rsir_no'],
                    'mstprc_file' => $mstprc_file,
                    'mstprc_filename' => $mstprc_filename,
                    'mstprc_filetype' => $mstprc_filetype,
                    'mstprc_size' => $mstprc_size,
                    'target_file' => $target_file,
                    'mstprc_url' => $mstprc_url
                );

                update_mstprc_setup_info_returned($mstprc_file_info, $conn);
            } else {
                $fat_no = save_fat($fat_info, $conn);

                $mstprc_file_info = array(
                    'mstprc_no' => $mstprc_no,
                    'machine_no' => $machine_no,
                    'equipment_no' => $equipment_no,
                    'machine_name' => $machine_name,
                    'car_model' => $new_group,
                    'location' => $new_location,
                    'grid' => $new_grid,
                    'trd_no' => $trd_no,
                    'ns_iv_no' => $ns_iv_no,
                    'is_new' => $is_new,
                    'mstprc_type' => $mstprc_type,
                    'mstprc_date' => $mstprc_date,
                    'fat_no' => $fat_no,
                    'mstprc_file' => $mstprc_file,
                    'mstprc_filename' => $mstprc_filename,
                    'mstprc_filetype' => $mstprc_filetype,
                    'mstprc_size' => $mstprc_size,
                    'target_file' => $target_file,
                    'mstprc_url' => $mstprc_url
                );

                // Insert File Information
                save_mstprc_setup_info($mstprc_file_info, $conn);
            }

            echo 'success';

        } else {
            echo "Sorry, there was an error uploading your file. Try Again or Contact IT Personnel if it fails again";
        }
    }
}

if ($method == 'save_mstprc_setup_2') {
    $mstprc_no = $_POST['mstprc_no'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $machine_name = $_POST['machine_name'];
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $grid = $_POST['grid'];
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $is_new = $_POST['is_new'];
    $mstprc_type = 'Setup';
    $mstprc_date = $_POST['mstprc_date'];

    $item_description = custom_trim($_POST['item_description']);
    $item_name = custom_trim($_POST['item_name']);
    $fat_machine_no = custom_trim($_POST['fat_machine_no']);
    $fat_equipment_no = custom_trim($_POST['fat_equipment_no']);
    $asset_tag_no = $_POST['asset_tag_no'];
    $prev_group = custom_trim($_POST['prev_group']);
    $prev_location = custom_trim($_POST['prev_location']);
    $prev_grid = custom_trim($_POST['prev_grid']);
    $new_group = custom_trim($_POST['new_group']);
    $new_location = custom_trim($_POST['new_location']);
    $new_grid = custom_trim($_POST['new_grid']);
    $date_transfer = $_POST['date_transfer'];
    $reason = custom_trim($_POST['reason']);

    $kigyo_no = custom_trim($_POST['kigyo_no']);
    $asset_name = custom_trim($_POST['asset_name']);
    $sup_asset_name = custom_trim($_POST['sup_asset_name']);
    $orig_asset_no = custom_trim($_POST['orig_asset_no']);
    $sou_date = $_POST['sou_date'];
    $sou_quantity = intval($_POST['sou_quantity']);
    $managing_dept_code = custom_trim($_POST['managing_dept_code']);
    $managing_dept_name = custom_trim($_POST['managing_dept_name']);
    $install_area_code = custom_trim($_POST['install_area_code']);
    $install_area_name = custom_trim($_POST['install_area_name']);
    $sou_machine_no = custom_trim($_POST['sou_machine_no']);
    $sou_equipment_no = custom_trim($_POST['sou_equipment_no']);
    $no_of_units = intval($_POST['no_of_units']);
    $ntc_or_sa = $_POST['ntc_or_sa'];
    $use_purpose = custom_trim($_POST['use_purpose']);

    $is_valid = false;

    if (!empty($kigyo_no)) {
        if (!empty($sou_date)) {
            if (!empty($sou_quantity) && $sou_quantity > 0) {
                if (!empty($managing_dept_code) && !empty($managing_dept_name)) {
                    if (!empty($install_area_code) && !empty($install_area_name)) {
                        if (!empty($no_of_units) && $no_of_units > 0) {
                            if (!empty($ntc_or_sa)) {
                                if (!empty($use_purpose)) {
                                    $is_valid = true;
                                } else
                                    echo 'SOU Use Purpose Empty';
                            } else
                                echo 'SOU NTC or SA Not Set';
                        } else
                            echo 'SOU No. of Units Below 1';
                    } else
                        echo 'SOU Install Area Code-Name Empty';
                } else
                    echo 'SOU Managing Dept Code-Name Empty';
            } else
                echo 'SOU Quantity Below 1';
        } else
            echo 'SOU Date Not Set';
    } else
        echo 'SOU Kigyo No. Empty';

    if ($is_valid == true) {
        $mstprc_file = $_FILES['file']['tmp_name'];
        $mstprc_filename = $_FILES['file']['name'];
        $mstprc_filetype = $_FILES['file']['type'];
        $mstprc_size = $_FILES['file']['size'];

        //$mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/setup/uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        //$target_dir = "../../uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        // $mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/setup/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        $mstprc_url = "/uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";
        $target_dir = "../../../../uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";

        // Add Folder If Not Exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $mstprc_filename = $mstprc_no . "-" . $mstprc_filename;

        $target_file = $target_dir . basename($mstprc_filename);
        $mstprc_url .= rawurlencode(basename($mstprc_filename));

        // Upload File and Check if successfully uploaded
        // Note: Can overwrite existing file
        if (move_uploaded_file($mstprc_file, $target_file)) {

            $fat_info = array(
                'item_description' => $item_description,
                'item_name' => $item_name,
                'machine_no' => $fat_machine_no,
                'equipment_no' => $fat_equipment_no,
                'asset_tag_no' => $asset_tag_no,
                'prev_group' => $prev_group,
                'prev_location' => $prev_location,
                'prev_grid' => $prev_grid,
                'new_group' => $new_group,
                'new_location' => $new_location,
                'new_grid' => $new_grid,
                'date_transfer' => $date_transfer,
                'reason' => $reason
            );

            $sou_info = array(
                'kigyo_no' => $kigyo_no,
                'asset_name' => $asset_name,
                'sup_asset_name' => $sup_asset_name,
                'orig_asset_no' => $orig_asset_no,
                'sou_date' => $sou_date,
                'sou_quantity' => $sou_quantity,
                'managing_dept_code' => $managing_dept_code,
                'managing_dept_name' => $managing_dept_name,
                'install_area_code' => $install_area_code,
                'install_area_name' => $install_area_name,
                'machine_no' => $sou_machine_no,
                'equipment_no' => $sou_equipment_no,
                'no_of_units' => $no_of_units,
                'ntc_or_sa' => $ntc_or_sa,
                'use_purpose' => $use_purpose
            );

            $mstprc_no_returned_arr = check_setup_mstprc_no_returned($mstprc_no, $conn);

            if (
                $mstprc_no_returned_arr['mstprc_no_exist'] == true
                && $mstprc_no_returned_arr['fat_no_exist'] == true
                && $mstprc_no_returned_arr['sou_no_exist'] == true
            ) {

                update_fat_returned($fat_info, $mstprc_no_returned_arr['fat_no'], $conn);
                update_sou_returned($sou_info, $mstprc_no_returned_arr['sou_no'], $conn);

                $mstprc_file_info = array(
                    'mstprc_no' => $mstprc_no,
                    'machine_no' => $machine_no,
                    'equipment_no' => $equipment_no,
                    'machine_name' => $machine_name,
                    'car_model' => $new_group,
                    'location' => $new_location,
                    'grid' => $new_grid,
                    'trd_no' => $trd_no,
                    'ns_iv_no' => $ns_iv_no,
                    'is_new' => $is_new,
                    'mstprc_type' => $mstprc_type,
                    'mstprc_date' => $mstprc_date,
                    'fat_no' => $mstprc_no_returned_arr['fat_no'],
                    'sou_no' => $mstprc_no_returned_arr['sou_no'],
                    'rsir_no' => $mstprc_no_returned_arr['rsir_no'],
                    'mstprc_file' => $mstprc_file,
                    'mstprc_filename' => $mstprc_filename,
                    'mstprc_filetype' => $mstprc_filetype,
                    'mstprc_size' => $mstprc_size,
                    'target_file' => $target_file,
                    'mstprc_url' => $mstprc_url
                );

                update_mstprc_setup_info_returned($mstprc_file_info, $conn);
            } else {

                $fat_no = save_fat($fat_info, $conn);
                $sou_no = save_sou($sou_info, $conn);

                $mstprc_file_info = array(
                    'mstprc_no' => $mstprc_no,
                    'machine_no' => $machine_no,
                    'equipment_no' => $equipment_no,
                    'machine_name' => $machine_name,
                    'car_model' => $new_group,
                    'location' => $new_location,
                    'grid' => $new_grid,
                    'trd_no' => $trd_no,
                    'ns_iv_no' => $ns_iv_no,
                    'is_new' => $is_new,
                    'mstprc_type' => $mstprc_type,
                    'mstprc_date' => $mstprc_date,
                    'fat_no' => $fat_no,
                    'sou_no' => $sou_no,
                    'mstprc_file' => $mstprc_file,
                    'mstprc_filename' => $mstprc_filename,
                    'mstprc_filetype' => $mstprc_filetype,
                    'mstprc_size' => $mstprc_size,
                    'target_file' => $target_file,
                    'mstprc_url' => $mstprc_url
                );

                // Insert File Information
                save_mstprc_setup_info($mstprc_file_info, $conn);
            }

            echo 'success';

        } else {
            echo "Sorry, there was an error uploading your file. Try Again or Contact IT Personnel if it fails again";
        }
    }
}

if ($method == 'save_mstprc_transfer') {
    $mstprc_no = $_POST['mstprc_no'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $machine_name = $_POST['machine_name'];
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $grid = $_POST['grid'];
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $mstprc_type = 'Transfer';
    $mstprc_date = $_POST['mstprc_date'];
    $to_car_model = custom_trim($_POST['to_car_model']);
    $to_location = custom_trim($_POST['to_location']);
    $to_grid = custom_trim($_POST['to_grid']);
    $transfer_reason = $_POST['transfer_reason'];

    $item_description = custom_trim($_POST['item_description']);
    $item_name = custom_trim($_POST['item_name']);
    $fat_machine_no = custom_trim($_POST['fat_machine_no']);
    $fat_equipment_no = custom_trim($_POST['fat_equipment_no']);
    $asset_tag_no = $_POST['asset_tag_no'];
    $prev_group = custom_trim($_POST['prev_group']);
    $prev_location = custom_trim($_POST['prev_location']);
    $prev_grid = custom_trim($_POST['prev_grid']);
    $new_group = custom_trim($_POST['new_group']);
    $new_location = custom_trim($_POST['new_location']);
    $new_grid = custom_trim($_POST['new_grid']);
    $date_transfer = $_POST['date_transfer'];
    $reason = custom_trim($_POST['reason']);

    $is_valid = false;

    if (!empty($prev_group) && !empty($prev_location)) {
        if (!empty($new_group) && !empty($new_location)) {
            if (!empty($date_transfer)) {
                if (!empty($reason)) {
                    $is_valid = true;
                } else
                    echo 'FAT Reason Empty';
            } else
                echo 'FAT Date Transfer Not Set';
        } else
            echo 'FAT New Group-Location Not Set';
    } else
        echo 'FAT Prev Group-Location Not Set';

    if ($is_valid == true) {
        $mstprc_file = $_FILES['file']['tmp_name'];
        $mstprc_filename = $_FILES['file']['name'];
        $mstprc_filetype = $_FILES['file']['type'];
        $mstprc_size = $_FILES['file']['size'];

        //$mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/setup/uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        //$target_dir = "../../uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        // $mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/setup/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        $mstprc_url = "/uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";
        $target_dir = "../../../../uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";

        // Add Folder If Not Exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $mstprc_filename = $mstprc_no . "-" . $mstprc_filename;

        $target_file = $target_dir . basename($mstprc_filename);
        $mstprc_url .= rawurlencode(basename($mstprc_filename));

        // Upload File and Check if successfully uploaded
        // Note: Can overwrite existing file
        if (move_uploaded_file($mstprc_file, $target_file)) {

            $fat_info = array(
                'item_description' => $item_description,
                'item_name' => $item_name,
                'machine_no' => $fat_machine_no,
                'equipment_no' => $fat_equipment_no,
                'asset_tag_no' => $asset_tag_no,
                'prev_group' => $prev_group,
                'prev_location' => $prev_location,
                'prev_grid' => $prev_grid,
                'new_group' => $new_group,
                'new_location' => $new_location,
                'new_grid' => $new_grid,
                'date_transfer' => $date_transfer,
                'reason' => $reason
            );

            $mstprc_no_returned_arr = check_setup_mstprc_no_returned($mstprc_no, $conn);

            if (
                $mstprc_no_returned_arr['mstprc_no_exist'] == true
                && $mstprc_no_returned_arr['fat_no_exist'] == true
            ) {
                update_fat_returned($fat_info, $mstprc_no_returned_arr['fat_no'], $conn);

                $mstprc_file_info = array(
                    'mstprc_no' => $mstprc_no,
                    'machine_no' => $machine_no,
                    'equipment_no' => $equipment_no,
                    'machine_name' => $machine_name,
                    'car_model' => $car_model,
                    'location' => $location,
                    'grid' => $grid,
                    'trd_no' => $trd_no,
                    'ns_iv_no' => $ns_iv_no,
                    'mstprc_type' => $mstprc_type,
                    'mstprc_date' => $mstprc_date,
                    'to_car_model' => $to_car_model,
                    'to_location' => $to_location,
                    'to_grid' => $to_grid,
                    'transfer_reason' => $transfer_reason,
                    'fat_no' => $mstprc_no_returned_arr['fat_no'],
                    'mstprc_file' => $mstprc_file,
                    'mstprc_filename' => $mstprc_filename,
                    'mstprc_filetype' => $mstprc_filetype,
                    'mstprc_size' => $mstprc_size,
                    'target_file' => $target_file,
                    'mstprc_url' => $mstprc_url
                );

                update_mstprc_transfer_info_returned($mstprc_file_info, $conn);
            } else {
                $fat_no = save_fat($fat_info, $conn);

                $mstprc_file_info = array(
                    'mstprc_no' => $mstprc_no,
                    'machine_no' => $machine_no,
                    'equipment_no' => $equipment_no,
                    'machine_name' => $machine_name,
                    'car_model' => $car_model,
                    'location' => $location,
                    'grid' => $grid,
                    'trd_no' => $trd_no,
                    'ns_iv_no' => $ns_iv_no,
                    'mstprc_type' => $mstprc_type,
                    'mstprc_date' => $mstprc_date,
                    'to_car_model' => $to_car_model,
                    'to_location' => $to_location,
                    'to_grid' => $to_grid,
                    'transfer_reason' => $transfer_reason,
                    'fat_no' => $fat_no,
                    'mstprc_file' => $mstprc_file,
                    'mstprc_filename' => $mstprc_filename,
                    'mstprc_filetype' => $mstprc_filetype,
                    'mstprc_size' => $mstprc_size,
                    'target_file' => $target_file,
                    'mstprc_url' => $mstprc_url
                );

                // Insert File Information
                save_mstprc_transfer_info($mstprc_file_info, $conn);
            }

            echo 'success';

        } else {
            echo "Sorry, there was an error uploading your file. Try Again or Contact IT Personnel if it fails again";
        }
    }
}

if ($method == 'save_mstprc_pullout') {
    $mstprc_no = $_POST['mstprc_no'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $machine_name = $_POST['machine_name'];
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $grid = $_POST['grid'];
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $mstprc_type = 'Pullout';
    $mstprc_date = $_POST['mstprc_date'];
    $pullout_reason = $_POST['pullout_reason'];
    $pullout_location = $_POST['pullout_location'];

    $item_description = custom_trim($_POST['item_description']);
    $item_name = custom_trim($_POST['item_name']);
    $fat_machine_no = custom_trim($_POST['fat_machine_no']);
    $fat_equipment_no = custom_trim($_POST['fat_equipment_no']);
    $asset_tag_no = $_POST['asset_tag_no'];
    $prev_group = custom_trim($_POST['prev_group']);
    $prev_location = custom_trim($_POST['prev_location']);
    $prev_grid = custom_trim($_POST['prev_grid']);
    $new_group = custom_trim($_POST['new_group']);
    $new_location = custom_trim($_POST['new_location']);
    $new_grid = custom_trim($_POST['new_grid']);
    $date_transfer = $_POST['date_transfer'];
    $reason = custom_trim($_POST['reason']);

    $is_valid = false;

    if (!empty($prev_group) && !empty($prev_location)) {
        if (!empty($new_group) && !empty($new_location)) {
            if (!empty($date_transfer)) {
                if (!empty($reason)) {
                    $is_valid = true;
                } else
                    echo 'FAT Reason Empty';
            } else
                echo 'FAT Date Transfer Not Set';
        } else
            echo 'FAT New Group-Location Not Set';
    } else
        echo 'FAT Prev Group-Location Not Set';

    if ($is_valid == true) {
        $mstprc_file = $_FILES['file']['tmp_name'];
        $mstprc_filename = $_FILES['file']['name'];
        $mstprc_filetype = $_FILES['file']['type'];
        $mstprc_size = $_FILES['file']['size'];

        //$mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/setup/uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        //$target_dir = "../../uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        // $mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/setup/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
        $mstprc_url = "/uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";
        $target_dir = "../../../../uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";

        // Add Folder If Not Exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $mstprc_filename = $mstprc_no . "-" . $mstprc_filename;

        $target_file = $target_dir . basename($mstprc_filename);
        $mstprc_url .= rawurlencode(basename($mstprc_filename));

        // Upload File and Check if successfully uploaded
        // Note: Can overwrite existing file
        if (move_uploaded_file($mstprc_file, $target_file)) {

            $fat_info = array(
                'item_description' => $item_description,
                'item_name' => $item_name,
                'machine_no' => $fat_machine_no,
                'equipment_no' => $fat_equipment_no,
                'asset_tag_no' => $asset_tag_no,
                'prev_group' => $prev_group,
                'prev_location' => $prev_location,
                'prev_grid' => $prev_grid,
                'new_group' => $new_group,
                'new_location' => $new_location,
                'new_grid' => $new_grid,
                'date_transfer' => $date_transfer,
                'reason' => $reason
            );

            $mstprc_no_returned_arr = check_setup_mstprc_no_returned($mstprc_no, $conn);

            if (
                $mstprc_no_returned_arr['mstprc_no_exist'] == true
                && $mstprc_no_returned_arr['fat_no_exist'] == true
            ) {
                update_fat_returned($fat_info, $mstprc_no_returned_arr['fat_no'], $conn);

                $mstprc_file_info = array(
                    'mstprc_no' => $mstprc_no,
                    'machine_no' => $machine_no,
                    'equipment_no' => $equipment_no,
                    'machine_name' => $machine_name,
                    'car_model' => $car_model,
                    'location' => $location,
                    'grid' => $grid,
                    'trd_no' => $trd_no,
                    'ns_iv_no' => $ns_iv_no,
                    'mstprc_type' => $mstprc_type,
                    'mstprc_date' => $mstprc_date,
                    'pullout_reason' => $pullout_reason,
                    'pullout_location' => $pullout_location,
                    'fat_no' => $mstprc_no_returned_arr['fat_no'],
                    'mstprc_file' => $mstprc_file,
                    'mstprc_filename' => $mstprc_filename,
                    'mstprc_filetype' => $mstprc_filetype,
                    'mstprc_size' => $mstprc_size,
                    'target_file' => $target_file,
                    'mstprc_url' => $mstprc_url
                );

                update_mstprc_pullout_info_returned($mstprc_file_info, $conn);
            } else {
                $fat_no = save_fat($fat_info, $conn);

                $mstprc_file_info = array(
                    'mstprc_no' => $mstprc_no,
                    'machine_no' => $machine_no,
                    'equipment_no' => $equipment_no,
                    'machine_name' => $machine_name,
                    'car_model' => $car_model,
                    'location' => $location,
                    'grid' => $grid,
                    'trd_no' => $trd_no,
                    'ns_iv_no' => $ns_iv_no,
                    'mstprc_type' => $mstprc_type,
                    'mstprc_date' => $mstprc_date,
                    'pullout_reason' => $pullout_reason,
                    'pullout_location' => $pullout_location,
                    'fat_no' => $fat_no,
                    'mstprc_file' => $mstprc_file,
                    'mstprc_filename' => $mstprc_filename,
                    'mstprc_filetype' => $mstprc_filetype,
                    'mstprc_size' => $mstprc_size,
                    'target_file' => $target_file,
                    'mstprc_url' => $mstprc_url
                );

                // Insert File Information
                save_mstprc_pullout_info($mstprc_file_info, $conn);
            }

            echo 'success';

        } else {
            echo "Sorry, there was an error uploading your file. Try Again or Contact IT Personnel if it fails again";
        }
    }
}

if ($method == 'save_mstprc_relayout') {
    $mstprc_no = $_POST['mstprc_no'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $machine_name = $_POST['machine_name'];
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $grid = $_POST['grid'];
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $mstprc_type = 'Relayout';
    $mstprc_date = $_POST['mstprc_date'];

    $mstprc_file = $_FILES['file']['tmp_name'];
    $mstprc_filename = $_FILES['file']['name'];
    $mstprc_filetype = $_FILES['file']['type'];
    $mstprc_size = $_FILES['file']['size'];

    //$mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/setup/uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
    //$target_dir = "../../uploads/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
    // $mstprc_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/setup/mstprc/".date("Y")."/".date("m")."/".date("d")."/";
    $mstprc_url = "/uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";
    $target_dir = "../../../../uploads/ems/setup/mstprc/" . date("Y") . "/" . date("m") . "/" . date("d") . "/";

    // Add Folder If Not Exists
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $mstprc_filename = $mstprc_no . "-" . $mstprc_filename;

    $target_file = $target_dir . basename($mstprc_filename);
    $mstprc_url .= rawurlencode(basename($mstprc_filename));

    // Upload File and Check if successfully uploaded
    // Note: Can overwrite existing file
    if (move_uploaded_file($mstprc_file, $target_file)) {

        $mstprc_no_returned_arr = check_setup_mstprc_no_returned($mstprc_no, $conn);

        if ($mstprc_no_returned_arr['mstprc_no_exist'] == true) {

            $mstprc_file_info = array(
                'mstprc_no' => $mstprc_no,
                'machine_no' => $machine_no,
                'equipment_no' => $equipment_no,
                'machine_name' => $machine_name,
                'car_model' => $car_model,
                'location' => $location,
                'grid' => $grid,
                'trd_no' => $trd_no,
                'ns_iv_no' => $ns_iv_no,
                'mstprc_type' => $mstprc_type,
                'mstprc_date' => $mstprc_date,
                'mstprc_file' => $mstprc_file,
                'mstprc_filename' => $mstprc_filename,
                'mstprc_filetype' => $mstprc_filetype,
                'mstprc_size' => $mstprc_size,
                'target_file' => $target_file,
                'mstprc_url' => $mstprc_url
            );

            update_mstprc_relayout_info_returned($mstprc_file_info, $conn);
        } else {
            $mstprc_file_info = array(
                'mstprc_no' => $mstprc_no,
                'machine_no' => $machine_no,
                'equipment_no' => $equipment_no,
                'machine_name' => $machine_name,
                'car_model' => $car_model,
                'location' => $location,
                'grid' => $grid,
                'trd_no' => $trd_no,
                'ns_iv_no' => $ns_iv_no,
                'mstprc_type' => $mstprc_type,
                'mstprc_date' => $mstprc_date,
                'mstprc_file' => $mstprc_file,
                'mstprc_filename' => $mstprc_filename,
                'mstprc_filetype' => $mstprc_filetype,
                'mstprc_size' => $mstprc_size,
                'target_file' => $target_file,
                'mstprc_url' => $mstprc_url
            );

            // Insert File Information
            save_mstprc_relayout_info($mstprc_file_info, $conn);
        }

        echo 'success';

    } else {
        echo "Sorry, there was an error uploading your file. Try Again or Contact IT Personnel if it fails again";
    }
}

// Count
if ($method == 'count_pending_machine_checksheets') {
    $sql = "SELECT count(id) AS total FROM setup_mstprc WHERE mstprc_process_status = 'Saved' OR mstprc_process_status = 'Confirmed' OR mstprc_process_status = 'Approved 1'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    } else {
        echo 0;
    }
}

// Read / Load
if ($method == 'get_pending_machine_checksheets') {
    $row_class_arr = array('modal-trigger', 'modal-trigger bg-lime', 'modal-trigger bg-warning', 'modal-trigger bg-danger', 'modal-trigger bg-success');
    $row_class = $row_class_arr[0];
    $sql = "SELECT 
		setup_mstprc.mstprc_no, setup_mstprc.mstprc_type, setup_mstprc.machine_name, setup_mstprc.machine_no, setup_mstprc.equipment_no, setup_mstprc.mstprc_date, setup_mstprc.car_model, setup_mstprc.location, setup_mstprc.grid, setup_mstprc.to_car_model, setup_mstprc.to_location, setup_mstprc.to_grid, setup_mstprc.pullout_location, setup_mstprc.transfer_reason, setup_mstprc.pullout_reason, setup_mstprc.mstprc_eq_member, setup_mstprc.mstprc_eq_g_leader, setup_mstprc.mstprc_safety_officer, setup_mstprc.mstprc_eq_manager, setup_mstprc.mstprc_eq_sp_personnel, setup_mstprc.mstprc_prod_engr_manager, setup_mstprc.mstprc_prod_supervisor, setup_mstprc.mstprc_prod_manager, setup_mstprc.mstprc_qa_supervisor, setup_mstprc.mstprc_qa_manager, setup_mstprc.mstprc_process_status, setup_mstprc.fat_no, setup_mstprc.sou_no, setup_mstprc.is_read_setup, setup_mstprc.file_name, setup_mstprc.file_url, 
		machines.process FROM setup_mstprc
		JOIN machines 
		ON setup_mstprc.machine_name = machines.machine_name
		WHERE setup_mstprc.mstprc_process_status = 'Saved' OR setup_mstprc.mstprc_process_status = 'Confirmed' OR setup_mstprc.mstprc_process_status = 'Approved 1' ORDER BY setup_mstprc.id DESC";
    $c = 0;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['is_read_setup'] == 0) {
                $row_class = $row_class_arr[1];
            } else if ($row['mstprc_process_status'] == 'Confirmed') {
                $row_class = $row_class_arr[2];
            } else if ($row['mstprc_process_status'] == 'Disapproved') {
                $row_class = $row_class_arr[3];
            } else if ($row['mstprc_process_status'] == 'Approved 1') {
                $row_class = $row_class_arr[4];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="PMC_' . $row['mstprc_no'] . '" data-toggle="modal" data-target="#PendingMachineChecksheetInfoModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" data-setup_process="' . $row['process'] . '" data-fat_no="' . $row['fat_no'] . '" data-sou_no="' . $row['sou_no'] . '" onclick="get_details_pending_machine_checksheets(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

if ($method == 'pending_machine_checksheets_mark_as_read') {
    machine_checksheets_mark_as_read($_POST['mstprc_no'], $_POST['mstprc_process_status'], 'ADMIN-SETUP', $conn);
}

// Count
if ($method == 'count_returned_machine_checksheets') {
    $sql = "SELECT count(id) AS total FROM setup_mstprc WHERE mstprc_process_status = 'Returned'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    $sql = "SELECT 
		setup_mstprc.mstprc_no, setup_mstprc.mstprc_type, setup_mstprc.machine_name, setup_mstprc.machine_no, setup_mstprc.equipment_no, setup_mstprc.mstprc_date, setup_mstprc.car_model, setup_mstprc.location, setup_mstprc.grid, setup_mstprc.to_car_model, setup_mstprc.to_location, setup_mstprc.to_grid, setup_mstprc.pullout_location, setup_mstprc.transfer_reason, setup_mstprc.pullout_reason, setup_mstprc.mstprc_eq_member, setup_mstprc.mstprc_eq_g_leader, setup_mstprc.mstprc_safety_officer, setup_mstprc.mstprc_eq_manager, setup_mstprc.mstprc_eq_sp_personnel, setup_mstprc.mstprc_prod_engr_manager, setup_mstprc.mstprc_prod_supervisor, setup_mstprc.mstprc_prod_manager, setup_mstprc.mstprc_qa_supervisor, setup_mstprc.mstprc_qa_manager, setup_mstprc.mstprc_process_status, setup_mstprc.returned_by, setup_mstprc.returned_date_time, setup_mstprc.fat_no, setup_mstprc.sou_no, setup_mstprc.is_read_setup, setup_mstprc.file_name, setup_mstprc.file_url, 
		machines.process FROM setup_mstprc
		JOIN machines 
		ON setup_mstprc.machine_name = machines.machine_name
		WHERE setup_mstprc.mstprc_process_status = 'Returned' ORDER BY setup_mstprc.id DESC";
    $c = 0;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['is_read_setup'] == 0) {
                $row_class = $row_class_arr[1];
            } else if ($row['mstprc_process_status'] == 'Returned') {
                $row_class = $row_class_arr[2];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="RMC_' . $row['mstprc_no'] . '" data-toggle="modal" data-target="#ReturnedMachineChecksheetInfoModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" data-setup_process="' . $row['process'] . '" data-fat_no="' . $row['fat_no'] . '" data-sou_no="' . $row['sou_no'] . '" onclick="get_details_returned_machine_checksheets(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '<td>' . htmlspecialchars($row['returned_by']) . '</td>';
            echo '<td>' . date("Y-m-d h:i A", strtotime($row['returned_date_time'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="10" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

if ($method == 'returned_machine_checksheets_mark_as_read') {
    machine_checksheets_mark_as_read($_POST['mstprc_no'], $_POST['mstprc_process_status'], 'ADMIN-SETUP', $conn);
}

if ($method == 'view_pending_fat') {
    $fat_no = $_POST['fat_no'];
    $message = '';

    if (!empty($fat_no)) {
        $sql = "SELECT id, fat_no, item_name, item_description, machine_no, equipment_no, asset_tag_no, prev_location_group, prev_location_loc, prev_location_grid, date_transfer, new_location_group, new_location_loc, new_location_grid, reason FROM fat_forms WHERE fat_no = '$fat_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $id = $row['id'];
                $fat_no = $row['fat_no'];
                $item_name = $row['item_name'];
                $item_description = $row['item_description'];
                $machine_no = $row['machine_no'];
                $equipment_no = $row['equipment_no'];
                $asset_tag_no = $row['asset_tag_no'];
                $prev_location_group = $row['prev_location_group'];
                $prev_location_loc = $row['prev_location_loc'];
                $prev_location_grid = $row['prev_location_grid'];
                $date_transfer = $row['date_transfer'];
                $new_location_group = $row['new_location_group'];
                $new_location_loc = $row['new_location_loc'];
                $new_location_grid = $row['new_location_grid'];
                $reason = $row['reason'];
                $message = 'success';
            }
        } else {
            $message = 'FAT Not Found';
        }

        $response_arr = array(
            'id' => $id,
            'fat_no' => $fat_no,
            'item_name' => $item_name,
            'item_description' => $item_description,
            'machine_no' => $machine_no,
            'equipment_no' => $equipment_no,
            'asset_tag_no' => $asset_tag_no,
            'prev_location_group' => $prev_location_group,
            'prev_location_loc' => $prev_location_loc,
            'prev_location_grid' => $prev_location_grid,
            'date_transfer' => $date_transfer,
            'new_location_group' => $new_location_group,
            'new_location_loc' => $new_location_loc,
            'new_location_grid' => $new_location_grid,
            'reason' => $reason,
            'message' => $message
        );
    } else {
        $message = 'FAT Not Found';
        $response_arr = array(
            'fat_no' => $fat_no,
            'message' => $message
        );
    }

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'view_pending_sou') {
    $sou_no = $_POST['sou_no'];
    $message = '';

    if (!empty($sou_no)) {
        $sql = "SELECT id, sou_no, kigyo_no, asset_name, sup_asset_name, orig_asset_no, sou_date, quantity, managing_dept_code, managing_dept_name, install_area_code, install_area_name, machine_no, equipment_no, no_of_units, ntc_or_sa, use_purpose FROM sou_forms WHERE sou_no = '$sou_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $id = $row['id'];
                $sou_no = $row['sou_no'];
                $kigyo_no = $row['kigyo_no'];
                $asset_name = $row['asset_name'];
                $sup_asset_name = $row['sup_asset_name'];
                $orig_asset_no = $row['orig_asset_no'];
                $sou_date = $row['sou_date'];
                $quantity = $row['quantity'];
                $managing_dept_code = $row['managing_dept_code'];
                $managing_dept_name = $row['managing_dept_name'];
                $install_area_code = $row['install_area_code'];
                $install_area_name = $row['install_area_name'];
                $machine_no = $row['machine_no'];
                $equipment_no = $row['equipment_no'];
                $no_of_units = $row['no_of_units'];
                $ntc_or_sa = $row['ntc_or_sa'];
                $use_purpose = $row['use_purpose'];
            }
            $message = 'success';
        } else {
            $message = 'SOU Not Found';
        }

        $response_arr = array(
            'id' => $id,
            'sou_no' => $sou_no,
            'kigyo_no' => $kigyo_no,
            'asset_name' => $asset_name,
            'sup_asset_name' => $sup_asset_name,
            'orig_asset_no' => $orig_asset_no,
            'sou_date' => $sou_date,
            'quantity' => $quantity,
            'managing_dept_code' => $managing_dept_code,
            'managing_dept_name' => $managing_dept_name,
            'install_area_code' => $install_area_code,
            'install_area_name' => $install_area_name,
            'machine_no' => $machine_no,
            'equipment_no' => $equipment_no,
            'no_of_units' => $no_of_units,
            'ntc_or_sa' => $ntc_or_sa,
            'use_purpose' => $use_purpose,
            'message' => $message
        );
    } else {
        $message = 'SOU Not Found';
        $response_arr = array(
            'sou_no' => $sou_no,
            'message' => $message
        );
    }

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'return_pending_mstprc') {
    $mstprc_no = $_POST['mstprc_no'];
    $mstprc_eq_g_leader = $_SESSION['setup_name'];
    $fat_no = $_POST['fat_no'];
    $sou_no = $_POST['sou_no'];

    $sql = "UPDATE setup_mstprc SET returned_by = '$mstprc_eq_g_leader', returned_date_time = '$date_updated', mstprc_process_status = 'Returned', is_read_setup = 0 WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if (!empty($fat_no)) {
        $sql = "UPDATE fat_forms SET fat_status = 'Returned' WHERE fat_no = '$fat_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    if (!empty($sou_no)) {
        $sql = "UPDATE sou_forms SET sou_status = 'Returned' WHERE sou_no = '$sou_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }

    //update_notif_count_machine_checksheets('ADMIN-SETUP', 'Returned', $conn);

    echo 'success';
}

if ($method == 'confirm_pending_mstprc') {
    $mstprc_no = $_POST['mstprc_no'];
    $process = $_POST['setup_process'];
    $approver = $_POST['approver'];
    $fat_no = $_POST['fat_no'];
    $sou_no = $_POST['sou_no'];
    $mstprc_eq_g_leader = $_SESSION['setup_name'];

    $is_valid = false;
    if ($process == 'Initial') {
        $approver = 'Prod';
        $is_valid = true;
    } else if ($process == 'Final' && !empty($approver)) {
        $is_valid = true;
    } else
        echo 'Approver Not Set';

    if ($is_valid == true) {
        $sql = "UPDATE setup_mstprc SET mstprc_approver_role = '$approver', mstprc_eq_g_leader = '$mstprc_eq_g_leader', mstprc_process_status = 'Confirmed' WHERE mstprc_no = '$mstprc_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        if (!empty($fat_no)) {
            $sql = "UPDATE fat_forms SET fat_status = 'Confirmed' WHERE fat_no = '$fat_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        if (!empty($sou_no)) {
            $sql = "UPDATE sou_forms SET sou_status = 'Confirmed' WHERE sou_no = '$sou_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        update_notif_count_machine_checksheets('APPROVER-1-SAFETY', 'Confirmed', $conn);

        echo 'success';
    }
}

// Count
if ($method == 'count_a1_machine_checksheets') {
    $sql = "SELECT count(id) AS total FROM setup_mstprc WHERE mstprc_process_status = 'Confirmed'";

    if (isset($_POST['car_model']) && !empty($_POST['car_model'])) {
        $sql = $sql . " AND car_model LIKE '" . $_POST['car_model'] . "%'";
    }
    if (isset($_POST['location']) && !empty($_POST['location'])) {
        $sql = $sql . " AND location LIKE '" . $_POST['location'] . "%'";
    }
    if (isset($_POST['machine_name']) && !empty($_POST['machine_name'])) {
        $sql = $sql . " AND machine_name LIKE '" . $_POST['machine_name'] . "%'";
    }
    if (isset($_POST['grid']) && !empty($_POST['grid'])) {
        $sql = $sql . " AND grid LIKE '" . $_POST['grid'] . "%'";
    }
    if (isset($_POST['mstprc_no']) && !empty($_POST['mstprc_no'])) {
        $sql = $sql . " AND mstprc_no LIKE '" . $_POST['mstprc_no'] . "%'";
    }
    if (isset($_POST['machine_no']) && !empty($_POST['machine_no'])) {
        $sql = $sql . " AND machine_no LIKE '" . $_POST['machine_no'] . "%'";
    }
    if (isset($_POST['equipment_no']) && !empty($_POST['equipment_no'])) {
        $sql = $sql . " AND equipment_no LIKE '" . $_POST['equipment_no'] . "%'";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    } else {
        echo 0;
    }
}

// Read / Load
if ($method == 'get_a1_machine_checksheets') {
    $sql = "SELECT mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status,file_name, file_url FROM setup_mstprc WHERE mstprc_process_status = 'Confirmed' ORDER BY id DESC";
    $c = 0;
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="A1MC_' . $row['mstprc_no'] . '" data-toggle="modal" data-target="#A1MachineChecksheetInfoModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" onclick="get_details_a1_machine_checksheets(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}


if ($method == 'a1_machine_checksheets_mark_as_read_safety') {
    machine_checksheets_mark_as_read($_POST['mstprc_no'], $_POST['mstprc_process_status'], 'APPROVER-1-SAFETY', $conn);
}

// Read / Load
if ($method == 'get_a1_machine_checksheets_safety') {
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $machine_name = $_POST['machine_name'];
    $grid = $_POST['grid'];
    $mstprc_no = $_POST['mstprc_no'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $setup_role = $_SESSION['setup_role'];

    $row_class_arr = array('modal-trigger', 'modal-trigger bg-warning');
    $row_class = $row_class_arr[0];
    $c = 0;

    $sql = "SELECT mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, is_read_safety, file_name, file_url FROM setup_mstprc WHERE mstprc_process_status = 'Confirmed'";

    if (!empty($car_model)) {
        $sql = $sql . " AND car_model LIKE '$car_model%'";
    }
    if (!empty($location)) {
        $sql = $sql . " AND location LIKE '$location%'";
    }
    if (!empty($machine_name)) {
        $sql = $sql . " AND machine_name LIKE '$machine_name%'";
    }
    if (!empty($grid)) {
        $sql = $sql . " AND grid LIKE '$grid%'";
    }
    if (!empty($mstprc_no)) {
        $sql = $sql . " AND mstprc_no LIKE '$mstprc_no%'";
    }
    if (!empty($machine_no)) {
        $sql = $sql . " AND machine_no LIKE '$machine_no%'";
    }
    if (!empty($equipment_no)) {
        $sql = $sql . " AND equipment_no LIKE '$equipment_no%'";
    }

    $sql = $sql . " ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['is_read_safety'] == 0) {
                $row_class = $row_class_arr[1];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="A1MC_' . $row['mstprc_no'] . '" data-toggle="modal" data-target="#A1MachineChecksheetInfoModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" data-mstprc_approver_role="' . $row['mstprc_approver_role'] . '" onclick="get_details_a1_machine_checksheets(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

if ($method == 'approve_a1_mstprc') {
    $mstprc_no = $_POST['mstprc_no'];
    $approver = $_POST['approver'];
    $mstprc_safety_officer = $_SESSION['setup_name'];

    $sql = "UPDATE setup_mstprc SET mstprc_safety_officer = '$mstprc_safety_officer', mstprc_process_status = 'Approved 1' WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    update_notif_count_machine_checksheets('APPROVER-2-EQ-MGR', 'Approved 1', $conn);
    update_notif_count_machine_checksheets('APPROVER-2-EQ-SP', 'Approved 1', $conn);
    update_notif_count_machine_checksheets('APPROVER-2-PROD-ENGR-MGR', 'Approved 1', $conn);
    if ($approver == 'Prod') {
        update_notif_count_machine_checksheets('APPROVER-2-PROD-SV', 'Approved 1', $conn);
        update_notif_count_machine_checksheets('APPROVER-2-PROD-MGR', 'Approved 1', $conn);
    } else if ($approver == 'QA') {
        update_notif_count_machine_checksheets('APPROVER-2-QA-SV', 'Approved 1', $conn);
        update_notif_count_machine_checksheets('APPROVER-2-QA-MGR', 'Approved 1', $conn);
    }

    echo 'success';
}

if ($method == 'disapprove_a1_mstprc') {
    $mstprc_no = $_POST['mstprc_no'];
    $disapproved_comment = $_POST['disapproved_comment'];
    $setup_name = $_SESSION['setup_name'];
    $setup_role = $_SESSION['setup_role'];

    if (!empty($disapproved_comment)) {
        $sql = "SELECT mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, fat_no, sou_no, rsir_no, file_name, file_type, file_url FROM setup_mstprc WHERE mstprc_no = '$mstprc_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $mstprc_no = $row['mstprc_no'];
                $mstprc_type = $row['mstprc_type'];
                $machine_name = $row['machine_name'];
                $machine_no = $row['machine_no'];
                $equipment_no = $row['equipment_no'];
                $mstprc_date = $row['mstprc_date'];
                $car_model = $row['car_model'];
                $location = $row['location'];
                $grid = $row['grid'];
                $is_new = $row['is_new'];
                $to_car_model = $row['to_car_model'];
                $to_location = $row['to_location'];
                $to_grid = $row['to_grid'];
                $pullout_location = $row['pullout_location'];
                $transfer_reason = $row['transfer_reason'];
                $pullout_reason = $row['pullout_reason'];
                $mstprc_username = $row['mstprc_username'];
                $mstprc_approver_role = $row['mstprc_approver_role'];
                $mstprc_eq_member = $row['mstprc_eq_member'];
                $mstprc_eq_g_leader = $row['mstprc_eq_g_leader'];
                $fat_no = $row['fat_no'];
                $sou_no = $row['sou_no'];
                $rsir_no = $row['rsir_no'];
                $file_name = $row['file_name'];
                $file_type = $row['file_type'];
                $file_url = $row['file_url'];
            }
        }

        $sql = "INSERT INTO setup_mstprc_history(mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_process_status, disapproved_by, disapproved_by_role, disapproved_comment, fat_no, sou_no, rsir_no, file_name, file_type, file_url) VALUES ('$mstprc_no','$mstprc_type','$machine_name','$machine_no','$equipment_no','$mstprc_date','$car_model','$location','$grid','$is_new','$to_car_model','$to_location','$to_grid','$pullout_location','$transfer_reason','$pullout_reason','$mstprc_username','$mstprc_approver_role','$mstprc_eq_member','$mstprc_eq_g_leader','Disapproved','$setup_name','$setup_role','$disapproved_comment','$fat_no','$sou_no','$rsir_no','$file_name','$file_type','$file_url')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $sql = "DELETE FROM setup_mstprc WHERE mstprc_no = '$mstprc_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        update_notif_count_machine_checksheets('ADMIN-SETUP', 'Disapproved', $conn);

        echo 'success';
    } else
        echo 'Comment Empty';
}

// Count
if ($method == 'count_a1_machine_checksheets_history') {
    $mstprc_date_from = $_POST['mstprc_date_from'];
    if (!empty($mstprc_date_from)) {
        $mstprc_date_from = date_create($mstprc_date_from);
        $mstprc_date_from = date_format($mstprc_date_from, "Y-m-d");
    }
    $mstprc_date_to = $_POST['mstprc_date_to'];
    if (!empty($mstprc_date_to)) {
        $mstprc_date_to = date_create($mstprc_date_to);
        $mstprc_date_to = date_format($mstprc_date_to, "Y-m-d");
    }
    $machine_name = addslashes($_POST['machine_name']);
    $car_model = addslashes($_POST['car_model']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $mstprc_no = $_POST['mstprc_no'];

    $history_option = $_POST['history_option'];

    $sql = "";

    if ($history_option == 1) {
        $sql = $sql . "SELECT count(id) AS total FROM setup_mstprc";

        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to') AND mstprc_process_status = 'Approved 1'";
        } else {
            $sql = $sql . " WHERE mstprc_process_status = 'Approved 1'";
        }
    } else if ($history_option == 2) {
        $sql = $sql . "SELECT count(id) AS total FROM setup_mstprc_history";

        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to') AND (mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved')";
        } else {
            $sql = $sql . " WHERE mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved'";
        }
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    } else {
        echo 0;
    }
}

// Read / Load
if ($method == 'get_a1_machine_checksheets_history') {
    $id = $_POST['id'];
    $mstprc_date_from = $_POST['mstprc_date_from'];
    if (!empty($mstprc_date_from)) {
        $mstprc_date_from = date_create($mstprc_date_from);
        $mstprc_date_from = date_format($mstprc_date_from, "Y-m-d");
    }
    $mstprc_date_to = $_POST['mstprc_date_to'];
    if (!empty($mstprc_date_to)) {
        $mstprc_date_to = date_create($mstprc_date_to);
        $mstprc_date_to = date_format($mstprc_date_to, "Y-m-d");
    }
    $machine_name = addslashes($_POST['machine_name']);
    $car_model = addslashes($_POST['car_model']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $mstprc_no = $_POST['mstprc_no'];
    $c = $_POST['c'];

    $history_option = $_POST['history_option'];

    $row_class_arr = array('modal-trigger', 'modal-trigger bg-warning', 'modal-trigger bg-success', 'modal-trigger bg-danger');
    $row_class = $row_class_arr[0];

    $sql = "SELECT id, mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, disapproved_by, disapproved_by_role, disapproved_comment, is_read_setup, file_name, file_url";

    if ($history_option == 1) {
        $sql = $sql . " FROM setup_mstprc";
    } else if ($history_option == 2) {
        $sql = $sql . " FROM setup_mstprc_history";
    }

    if (empty($id)) {
        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to')";
        }
    } else {
        $sql = $sql . " WHERE id < '$id'";
        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " AND (machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to'))";
        }
    }

    if ($history_option == 1) {
        $sql = $sql . " AND mstprc_process_status = 'Approved 1' ORDER BY id DESC LIMIT 25";
    } else if ($history_option == 2) {
        $sql = $sql . " AND (mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved') ORDER BY id DESC LIMIT 25";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['mstprc_process_status'] == 'Approved 1') {
                $row_class = $row_class_arr[1];
            } else if ($row['mstprc_process_status'] == 'Approved 2') {
                $row_class = $row_class_arr[2];
            } else if ($row['mstprc_process_status'] == 'Disapproved') {
                $row_class = $row_class_arr[3];
            } else {
                $row_class = $row_class_arr[0];
            }

            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="' . $row['id'] . '" data-toggle="modal" data-target="#A1MachineChecksheetInfoHistoryModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" data-disapproved_by="' . htmlspecialchars($row['disapproved_by']) . '" data-disapproved_by_role="' . htmlspecialchars($row['disapproved_by_role']) . '" data-disapproved_comment="' . htmlspecialchars($row['disapproved_comment']) . '" onclick="get_details_a1_machine_checksheets_history(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Count
if ($method == 'count_a2_machine_checksheets') {
    $setup_role = $_SESSION['setup_role'];

    $sql = "SELECT count(id) AS total FROM setup_mstprc WHERE mstprc_process_status = 'Approved 1'";

    if (isset($_POST['car_model']) && !empty($_POST['car_model'])) {
        $sql = $sql . " AND car_model LIKE '" . $_POST['car_model'] . "%'";
    }
    if (isset($_POST['location']) && !empty($_POST['location'])) {
        $sql = $sql . " AND location LIKE '" . $_POST['location'] . "%'";
    }
    if (isset($_POST['machine_name']) && !empty($_POST['machine_name'])) {
        $sql = $sql . " AND machine_name LIKE '" . $_POST['machine_name'] . "%'";
    }
    if (isset($_POST['grid']) && !empty($_POST['grid'])) {
        $sql = $sql . " AND grid LIKE '" . $_POST['grid'] . "%'";
    }
    if (isset($_POST['mstprc_no']) && !empty($_POST['mstprc_no'])) {
        $sql = $sql . " AND mstprc_no LIKE '" . $_POST['mstprc_no'] . "%'";
    }
    if (isset($_POST['machine_no']) && !empty($_POST['machine_no'])) {
        $sql = $sql . " AND machine_no LIKE '" . $_POST['machine_no'] . "%'";
    }
    if (isset($_POST['equipment_no']) && !empty($_POST['equipment_no'])) {
        $sql = $sql . " AND equipment_no LIKE '" . $_POST['equipment_no'] . "%'";
    }

    switch ($setup_role) {
        case 'Production Supervisor':
        case 'Production Manager':
            $sql = $sql . " AND mstprc_approver_role = 'Prod'";
            break;
        case 'QA Supervisor':
        case 'QA Manager':
            $sql = $sql . " AND mstprc_approver_role = 'QA'";
            break;
        default:
            break;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    } else {
        echo 0;
    }
}

// Read / Load
if ($method == 'get_a2_machine_checksheets') {
    $row_class_arr = array('modal-trigger', 'modal-trigger bg-warning');
    $row_class = $row_class_arr[0];
    $c = 0;

    $sql = "SELECT mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, file_name, file_url FROM setup_mstprc WHERE mstprc_process_status = 'Approved 1'  ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if (!empty($row['mstprc_eq_manager']) || !empty($row['mstprc_eq_sp_personnel']) || !empty($row['mstprc_prod_engr_manager']) || (!empty($row['mstprc_prod_supervisor']) && !empty($row['mstprc_prod_manager'])) || (!empty($row['mstprc_qa_supervisor']) && !empty($row['mstprc_qa_manager']))) {
                $row_class = $row_class_arr[1];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="A2MC_' . $row['mstprc_no'] . '" data-toggle="modal" data-target="#A2MachineChecksheetInfoModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" onclick="get_details_a2_machine_checksheets(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

if ($method == 'a2_machine_checksheets_mark_as_read_all_approvers') {
    $setup_role = $_SESSION['setup_role'];
    $interface = '';
    switch ($setup_role) {
        case 'EQ Manager':
            $interface = 'APPROVER-2-EQ-MGR';
            break;
        case 'Production Engineering Manager':
            $interface = 'APPROVER-2-PROD-ENGR-MGR';
            break;
        case 'Production Supervisor':
            $interface = 'APPROVER-2-PROD-SV';
            break;
        case 'Production Manager':
            $interface = 'APPROVER-2-PROD-MGR';
            break;
        case 'QA Supervisor':
            $interface = 'APPROVER-2-QA-SV';
            break;
        case 'QA Manager':
            $interface = 'APPROVER-2-QA-MGR';
            break;
        default:
            break;
    }
    if (!empty($interface)) {
        machine_checksheets_mark_as_read($_POST['mstprc_no'], $_POST['mstprc_process_status'], $interface, $conn);
    }
}

// Read / Load
if ($method == 'get_a2_machine_checksheets_all_approvers') {
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $machine_name = $_POST['machine_name'];
    $grid = $_POST['grid'];
    $mstprc_no = $_POST['mstprc_no'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $setup_role = $_SESSION['setup_role'];

    $row_class_arr = array('modal-trigger', 'modal-trigger bg-warning', 'modal-trigger bg-success');
    $row_class = $row_class_arr[0];
    $c = 0;

    $sql = "SELECT mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, is_read_eq_mgr, is_read_prod_engr_mgr, is_read_prod_sv, is_read_prod_mgr, is_read_qa_sv, is_read_qa_mgr, file_name, file_url FROM setup_mstprc WHERE mstprc_process_status = 'Approved 1'";

    if (!empty($car_model)) {
        $sql = $sql . " AND car_model LIKE '$car_model%'";
    }
    if (!empty($location)) {
        $sql = $sql . " AND location LIKE '$location%'";
    }
    if (!empty($machine_name)) {
        $sql = $sql . " AND machine_name LIKE '$machine_name%'";
    }
    if (!empty($grid)) {
        $sql = $sql . " AND grid LIKE '$grid%'";
    }
    if (!empty($mstprc_no)) {
        $sql = $sql . " AND mstprc_no LIKE '$mstprc_no%'";
    }
    if (!empty($machine_no)) {
        $sql = $sql . " AND machine_no LIKE '$machine_no%'";
    }
    if (!empty($equipment_no)) {
        $sql = $sql . " AND equipment_no LIKE '$equipment_no%'";
    }

    switch ($setup_role) {
        case 'Production Supervisor':
        case 'Production Manager':
            $sql = $sql . " AND mstprc_approver_role = 'Prod'";
            break;
        case 'QA Supervisor':
        case 'QA Manager':
            $sql = $sql . " AND mstprc_approver_role = 'QA'";
            break;
        default:
            break;
    }
    $sql = $sql . " ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            switch ($setup_role) {
                case 'EQ Manager':
                    if (!empty($row['mstprc_eq_manager'])) {
                        $row_class = $row_class_arr[2];
                    } else if ($row['is_read_eq_mgr'] == 0) {
                        $row_class = $row_class_arr[1];
                    } else {
                        $row_class = $row_class_arr[0];
                    }
                    break;
                case 'Production Engineering Manager':
                    if (!empty($row['mstprc_prod_engr_manager'])) {
                        $row_class = $row_class_arr[2];
                    } else if ($row['is_read_prod_engr_mgr'] == 0) {
                        $row_class = $row_class_arr[1];
                    } else {
                        $row_class = $row_class_arr[0];
                    }
                    break;
                case 'Production Supervisor':
                    if (!empty($row['mstprc_prod_supervisor'])) {
                        $row_class = $row_class_arr[2];
                    } else if ($row['is_read_prod_sv'] == 0) {
                        $row_class = $row_class_arr[1];
                    } else {
                        $row_class = $row_class_arr[0];
                    }
                    break;
                case 'Production Manager':
                    if (!empty($row['mstprc_prod_manager'])) {
                        $row_class = $row_class_arr[2];
                    } else if ($row['is_read_prod_mgr'] == 0) {
                        $row_class = $row_class_arr[1];
                    } else {
                        $row_class = $row_class_arr[0];
                    }
                    break;
                case 'QA Supervisor':
                    if (!empty($row['mstprc_qa_supervisor'])) {
                        $row_class = $row_class_arr[2];
                    } else if ($row['is_read_qa_sv'] == 0) {
                        $row_class = $row_class_arr[1];
                    } else {
                        $row_class = $row_class_arr[0];
                    }
                    break;
                case 'QA Manager':
                    if (!empty($row['mstprc_qa_manager'])) {
                        $row_class = $row_class_arr[2];
                    } else if ($row['is_read_qa_mgr'] == 0) {
                        $row_class = $row_class_arr[1];
                    } else {
                        $row_class = $row_class_arr[0];
                    }
                    break;
                default:
                    $row_class = $row_class_arr[0];
                    break;
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="A2MC_' . $row['mstprc_no'] . '" data-toggle="modal" data-target="#A2MachineChecksheetInfoModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" onclick="get_details_a2_machine_checksheets(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

if ($method == 'approve_a2_mstprc') {
    $mstprc_no = $_POST['mstprc_no'];
    $setup_name = $_SESSION['setup_name'];
    $setup_role = $_SESSION['setup_role'];

    $sql = "UPDATE setup_mstprc";

    switch ($setup_role) {
        case 'EQ Manager':
            $sql = $sql . " SET mstprc_eq_manager = '$setup_name'";
            break;
        case 'Production Engineering Manager':
            $sql = $sql . " SET mstprc_prod_engr_manager = '$setup_name'";
            break;
        case 'Production Supervisor':
            $sql = $sql . " SET mstprc_prod_supervisor = '$setup_name'";
            break;
        case 'Production Manager':
            $sql = $sql . " SET mstprc_prod_manager = '$setup_name'";
            break;
        case 'QA Supervisor':
            $sql = $sql . " SET mstprc_qa_supervisor = '$setup_name'";
            break;
        case 'QA Manager':
            $sql = $sql . " SET mstprc_qa_manager = '$setup_name'";
            break;
        default:
            break;
    }

    $sql = $sql . " WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $machine_name = '';
    $machine_no = '';
    $equipment_no = '';
    $car_model = '';
    $location = '';
    $grid = '';
    $is_new = 0;
    $machine_status = '';
    $new_car_model = '';
    $new_location = '';
    $new_grid = '';
    $pullout_location = '';
    $transfer_reason = '';
    $pullout_reason = '';
    $mstprc_username = '';
    $mstprc_approver_role = '';
    $pic = '';
    $status_date = '';
    $mstprc_eq_g_leader = '';
    $mstprc_safety_officer = '';
    $mstprc_eq_manager = '';
    $mstprc_eq_sp_personnel = '';
    $mstprc_prod_engr_manager = '';
    $mstprc_prod_supervisor = '';
    $mstprc_prod_manager = '';
    $mstprc_qa_supervisor = '';
    $mstprc_qa_manager = '';
    $fat_no = '';
    $sou_no = '';
    $rsir_no = '';
    $file_name = '';
    $file_type = '';
    $file_url = '';

    $fully_approved = false;

    $sql = "SELECT mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, fat_no, sou_no, rsir_no, file_name, file_type, file_url FROM setup_mstprc WHERE mstprc_no = '$mstprc_no' LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            if (!empty($row['mstprc_eq_manager']) && !empty($row['mstprc_eq_sp_personnel']) && !empty($row['mstprc_prod_engr_manager']) && ((!empty($row['mstprc_prod_supervisor']) && !empty($row['mstprc_prod_manager'])) || (!empty($row['mstprc_qa_supervisor']) && !empty($row['mstprc_qa_manager'])))) {

                $machine_name = $row['machine_name'];
                $machine_no = $row['machine_no'];
                $equipment_no = $row['equipment_no'];
                $status_date = $row['mstprc_date'];
                $car_model = $row['car_model'];
                $location = $row['location'];
                $grid = $row['grid'];
                $is_new = $row['is_new'];
                $machine_status = $row['mstprc_type'];
                $new_car_model = $row['to_car_model'];
                $new_location = $row['to_location'];
                $new_grid = $row['to_grid'];
                $pullout_location = $row['pullout_location'];
                $transfer_reason = $row['transfer_reason'];
                $pullout_reason = $row['pullout_reason'];
                $mstprc_username = $row['mstprc_username'];
                $mstprc_approver_role = $row['mstprc_approver_role'];
                $pic = $row['mstprc_eq_member'];
                $mstprc_eq_g_leader = $row['mstprc_eq_g_leader'];
                $mstprc_safety_officer = $row['mstprc_safety_officer'];
                $mstprc_eq_manager = $row['mstprc_eq_manager'];
                $mstprc_eq_sp_personnel = $row['mstprc_eq_sp_personnel'];
                $mstprc_prod_engr_manager = $row['mstprc_prod_engr_manager'];
                $mstprc_prod_supervisor = $row['mstprc_prod_supervisor'];
                $mstprc_prod_manager = $row['mstprc_prod_manager'];
                $mstprc_qa_supervisor = $row['mstprc_qa_supervisor'];
                $mstprc_qa_manager = $row['mstprc_qa_manager'];
                $fat_no = $row['fat_no'];
                $sou_no = $row['sou_no'];
                $rsir_no = $row['rsir_no'];
                $file_name = $row['file_name'];
                $file_type = $row['file_type'];
                $file_url = $row['file_url'];

                $fully_approved = true;
            }
        }
    }

    if ($fully_approved == true) {
        $sql = "INSERT INTO setup_mstprc_history(mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, fat_no, sou_no, rsir_no, file_name, file_type, file_url) VALUES ('$mstprc_no','$machine_status','$machine_name','$machine_no','$equipment_no','$status_date','$car_model','$location','$grid','$is_new','$new_car_model','$new_location','$new_grid','$pullout_location','$transfer_reason','$pullout_reason','$mstprc_username','$mstprc_approver_role','$pic','$mstprc_eq_g_leader','$mstprc_safety_officer','$mstprc_eq_manager','$mstprc_eq_sp_personnel','$mstprc_prod_engr_manager','$mstprc_prod_supervisor','$mstprc_prod_manager','$mstprc_qa_supervisor','$mstprc_qa_manager','Approved 2','$fat_no','$sou_no','$rsir_no','$file_name','$file_type','$file_url')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $sql = "DELETE FROM setup_mstprc WHERE mstprc_no = '$mstprc_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $current_number = 0;
        $process = '';
        $machine_spec = '';
        $asset_tag_no = '';
        $trd_no = '';
        $ns_iv_no = '';

        $sql = "SELECT number, process, machine_spec, asset_tag_no, trd_no, `ns-iv_no` FROM machine_masterlist WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $current_number = intval($row['number']);
                $process = $row['process'];
                $machine_spec = $row['machine_spec'];
                $asset_tag_no = $row['asset_tag_no'];
                $trd_no = $row['trd_no'];
                $ns_iv_no = $row['ns-iv_no'];
            }
        }

        if ($machine_status == 'Setup') {
            $sql = "DELETE FROM unused_machines WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE machine_masterlist SET car_model = '$car_model', location = '$location', grid = '$grid', machine_status = '$machine_status', is_new = 0 WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } else if ($machine_status == 'Pullout') {
            $machine_status = 'UNUSED';

            $sql = "INSERT INTO unused_machines (machine_name, car_model, machine_no, equipment_no, asset_tag_no, unused_machine_location, status, reserved_for, pic, remarks, target_date) VALUES ('$machine_name', '$car_model', '$machine_no', '$equipment_no', '$asset_tag_no', '', '', '', '', '', '')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE machine_masterlist SET machine_status = '$machine_status',";
            if ($process == 'Initial') {
                $sql = $sql . " car_model = 'EQ-Initial', location = 'FAS4', grid = ''";
            } else if ($process == 'Final') {
                $sql = $sql . " car_model = 'EQ-Final', location = 'FAS4', grid = ''";
            }
            $sql = $sql . " WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "INSERT INTO machine_history (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, `ns-iv_no`, machine_status, pic, status_date, history_date_time) VALUES ('$current_number', '$process', '$machine_name', '$machine_spec', '$car_model', '$location', '$grid', '$machine_no', '$equipment_no', '$asset_tag_no', '$trd_no', '$ns_iv_no', 'Pullout', '$pic', '$status_date', '$date_updated')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            if ($process == 'Initial') {
                $car_model = 'EQ-Initial';
            } else if ($process == 'Final') {
                $car_model = 'EQ-Final';
            }
            $location = 'FAS4';
            $grid = '';
        } else if ($machine_status == 'Transfer') {
            $sql = "UPDATE machine_masterlist SET car_model = '$new_car_model', location = '$new_location', grid = '$new_grid', machine_status = '$machine_status' WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $car_model = $new_car_model;
            $location = $new_location;
            $grid = $new_grid;
        } else {
            $sql = "UPDATE machine_masterlist SET machine_status = '$machine_status' WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        $sql = "INSERT INTO machine_history (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, `ns-iv_no`, machine_status, pic, status_date, history_date_time) VALUES ('$current_number', '$process', '$machine_name', '$machine_spec', '$car_model', '$location', '$grid', '$machine_no', '$equipment_no', '$asset_tag_no', '$trd_no', '$ns_iv_no', '$machine_status', '$pic', '$status_date', '$date_updated')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        update_notif_count_machine_checksheets('ADMIN-SETUP', 'Approved 2', $conn);
    }

    echo 'success';
}

if ($method == 'disapprove_a2_mstprc') {
    $mstprc_no = $_POST['mstprc_no'];
    $disapproved_comment = $_POST['disapproved_comment'];
    $setup_name = $_SESSION['setup_name'];
    $setup_role = $_SESSION['setup_role'];

    if (!empty($disapproved_comment)) {
        $sql = "SELECT mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, fat_no, sou_no, rsir_no, file_name, file_type, file_url FROM setup_mstprc WHERE mstprc_no = '$mstprc_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $mstprc_no = $row['mstprc_no'];
                $mstprc_type = $row['mstprc_type'];
                $machine_name = $row['machine_name'];
                $machine_no = $row['machine_no'];
                $equipment_no = $row['equipment_no'];
                $mstprc_date = $row['mstprc_date'];
                $car_model = $row['car_model'];
                $location = $row['location'];
                $grid = $row['grid'];
                $is_new = $row['is_new'];
                $to_car_model = $row['to_car_model'];
                $to_location = $row['to_location'];
                $to_grid = $row['to_grid'];
                $pullout_location = $row['pullout_location'];
                $transfer_reason = $row['transfer_reason'];
                $pullout_reason = $row['pullout_reason'];
                $mstprc_username = $row['mstprc_username'];
                $mstprc_approver_role = $row['mstprc_approver_role'];
                $mstprc_eq_member = $row['mstprc_eq_member'];
                $mstprc_eq_g_leader = $row['mstprc_eq_g_leader'];
                $mstprc_eq_manager = $row['mstprc_eq_manager'];
                $mstprc_eq_sp_personnel = $row['mstprc_eq_sp_personnel'];
                $mstprc_prod_engr_manager = $row['mstprc_prod_engr_manager'];
                $mstprc_prod_supervisor = $row['mstprc_prod_supervisor'];
                $mstprc_prod_manager = $row['mstprc_prod_manager'];
                $mstprc_qa_supervisor = $row['mstprc_qa_supervisor'];
                $mstprc_qa_manager = $row['mstprc_qa_manager'];
                $fat_no = $row['fat_no'];
                $sou_no = $row['sou_no'];
                $rsir_no = $row['rsir_no'];
                $file_name = $row['file_name'];
                $file_type = $row['file_type'];
                $file_url = $row['file_url'];
            }
        }

        $sql = "INSERT INTO setup_mstprc_history(mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, disapproved_by, disapproved_by_role, disapproved_comment, fat_no, sou_no, rsir_no, file_name, file_type, file_url) VALUES ('$mstprc_no','$mstprc_type','$machine_name','$machine_no','$equipment_no','$mstprc_date','$car_model','$location','$grid','$is_new','$to_car_model','$to_location','$to_grid','$pullout_location','$transfer_reason','$pullout_reason','$mstprc_username','$mstprc_approver_role','$mstprc_eq_member','$mstprc_eq_g_leader','$mstprc_eq_manager','$mstprc_eq_sp_personnel','$mstprc_prod_engr_manager','$mstprc_prod_supervisor','$mstprc_prod_manager','$mstprc_qa_supervisor','$mstprc_qa_manager','Disapproved','$setup_name','$setup_role','$disapproved_comment','$fat_no','$sou_no','$rsir_no','$file_name','$file_type','$file_url')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $sql = "DELETE FROM setup_mstprc WHERE mstprc_no = '$mstprc_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        update_notif_count_machine_checksheets('ADMIN-SETUP', 'Disapproved', $conn);

        echo 'success';
    } else
        echo 'Comment Empty';
}

// Count
if ($method == 'count_a2_machine_checksheets_history') {
    $setup_role = $_SESSION['setup_role'];
    $mstprc_date_from = $_POST['mstprc_date_from'];
    if (!empty($mstprc_date_from)) {
        $mstprc_date_from = date_create($mstprc_date_from);
        $mstprc_date_from = date_format($mstprc_date_from, "Y-m-d");
    }
    $mstprc_date_to = $_POST['mstprc_date_to'];
    if (!empty($mstprc_date_to)) {
        $mstprc_date_to = date_create($mstprc_date_to);
        $mstprc_date_to = date_format($mstprc_date_to, "Y-m-d");
    }
    $machine_name = addslashes($_POST['machine_name']);
    $car_model = addslashes($_POST['car_model']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $mstprc_no = $_POST['mstprc_no'];

    $history_option = $_POST['history_option'];

    $sql = "SELECT count(id) AS total";

    if ($history_option == 1) {
        $sql = $sql . " FROM setup_mstprc";

        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to') AND mstprc_process_status = 'Approved 1'";
        } else {
            $sql = $sql . " WHERE mstprc_process_status = 'Approved 1'";
        }
    } else if ($history_option == 2) {
        $sql = $sql . " FROM setup_mstprc_history";

        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to') AND (mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved')";
        } else {
            $sql = $sql . " WHERE (mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved')";
        }
    }

    switch ($setup_role) {
        case 'Production Supervisor':
        case 'Production Manager':
            $sql = $sql . " AND mstprc_approver_role = 'Prod'";
            break;
        case 'QA Supervisor':
        case 'QA Manager':
            $sql = $sql . " AND mstprc_approver_role = 'QA'";
            break;
        default:
            break;
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    } else {
        echo 0;
    }
}

// Read / Load
if ($method == 'get_a2_machine_checksheets_history') {
    $setup_role = $_SESSION['setup_role'];
    $id = $_POST['id'];
    $mstprc_date_from = $_POST['mstprc_date_from'];
    if (!empty($mstprc_date_from)) {
        $mstprc_date_from = date_create($mstprc_date_from);
        $mstprc_date_from = date_format($mstprc_date_from, "Y-m-d");
    }
    $mstprc_date_to = $_POST['mstprc_date_to'];
    if (!empty($mstprc_date_to)) {
        $mstprc_date_to = date_create($mstprc_date_to);
        $mstprc_date_to = date_format($mstprc_date_to, "Y-m-d");
    }
    $machine_name = addslashes($_POST['machine_name']);
    $car_model = addslashes($_POST['car_model']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $mstprc_no = $_POST['mstprc_no'];
    $c = $_POST['c'];

    $history_option = $_POST['history_option'];

    $row_class_arr = array('modal-trigger', 'modal-trigger bg-warning', 'modal-trigger bg-success', 'modal-trigger bg-danger');
    $row_class = $row_class_arr[0];

    $sql = "SELECT id, mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, disapproved_by, disapproved_by_role, disapproved_comment, is_read_setup, file_name, file_url";

    if ($history_option == 1) {
        $sql = $sql . " FROM setup_mstprc";
        if (empty($id)) {
            if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
                $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to')";
            }
        } else {
            $sql = $sql . " WHERE id < '$id'";
            if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
                $sql = $sql . " AND (machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to'))";
            }
        }
        $sql = $sql . " AND mstprc_process_status = 'Approved 1'";
    } else if ($history_option == 2) {
        $sql = $sql . " FROM setup_mstprc_history";
        if (empty($id)) {
            if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
                $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to')";
            }
        } else {
            $sql = $sql . " WHERE id < '$id'";
            if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
                $sql = $sql . " AND (machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to'))";
            }
        }
        $sql = $sql . " AND (mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved')";
    }

    switch ($setup_role) {
        case 'Production Supervisor':
        case 'Production Manager':
            $sql = $sql . " AND mstprc_approver_role = 'Prod'";
            break;
        case 'QA Supervisor':
        case 'QA Manager':
            $sql = $sql . " AND mstprc_approver_role = 'QA'";
            break;
        default:
            break;
    }

    $sql = $sql . " ORDER BY id DESC LIMIT 25";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['mstprc_process_status'] == 'Approved 1') {
                $row_class = $row_class_arr[1];
            } else if ($row['mstprc_process_status'] == 'Approved 2') {
                $row_class = $row_class_arr[2];
            } else if ($row['mstprc_process_status'] == 'Disapproved') {
                $row_class = $row_class_arr[3];
            } else {
                $row_class = $row_class_arr[0];
            }

            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="' . $row['id'] . '" data-toggle="modal" data-target="#A2MachineChecksheetInfoHistoryModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" data-disapproved_by="' . htmlspecialchars($row['disapproved_by']) . '" data-disapproved_by_role="' . htmlspecialchars($row['disapproved_by_role']) . '" data-disapproved_comment="' . htmlspecialchars($row['disapproved_comment']) . '" onclick="get_details_a2_machine_checksheets_history(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

if ($method == 'machine_checksheets_history_mark_as_read') {
    machine_checksheets_mark_as_read($_POST['mstprc_no'], $_POST['mstprc_process_status'], 'ADMIN-SETUP', $conn);
}

// Read / Load
if ($method == 'get_recent_machine_checksheets_history') {
    $row_class_arr = array('modal-trigger', 'modal-trigger bg-lime', 'modal-trigger bg-success', 'modal-trigger bg-danger');
    $row_class = $row_class_arr[0];
    $c = 0;

    $sql = "SELECT id, mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, disapproved_by, disapproved_by_role, disapproved_comment, is_read_setup, file_name, file_url FROM setup_mstprc_history WHERE mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved' ORDER BY id DESC LIMIT 25";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['is_read_setup'] == 0) {
                $row_class = $row_class_arr[1];
            } else if ($row['mstprc_process_status'] == 'Approved 2') {
                $row_class = $row_class_arr[2];
            } else if ($row['mstprc_process_status'] == 'Disapproved') {
                $row_class = $row_class_arr[3];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="' . $row['id'] . '" data-toggle="modal" data-target="#MachineChecksheetInfoHistoryModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" data-disapproved_by="' . htmlspecialchars($row['disapproved_by']) . '" data-disapproved_by_role="' . htmlspecialchars($row['disapproved_by_role']) . '" data-disapproved_comment="' . htmlspecialchars($row['disapproved_comment']) . '" onclick="get_details_machine_checksheets_history(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Read / Load
if ($method == 'get_recent_machine_checksheets') {
    $search = $_POST['search'];
    $row_class_arr = array('modal-trigger', 'modal-trigger bg-warning', 'modal-trigger bg-success');
    $row_class = $row_class_arr[0];
    $c = 0;

    $sql = "SELECT id, mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, is_read_setup, file_name, file_url FROM setup_mstprc WHERE (mstprc_process_status = 'Saved' OR mstprc_process_status = 'Confirmed' OR mstprc_process_status = 'Approved 1') AND (mstprc_no LIKE '$search%' OR machine_no LIKE '$search%' OR equipment_no LIKE '$search%' OR mstprc_type LIKE '$search%') ORDER BY id DESC LIMIT 50";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['mstprc_process_status'] == 'Confirmed') {
                $row_class = $row_class_arr[1];
            } else if ($row['mstprc_process_status'] == 'Approved 1') {
                $row_class = $row_class_arr[2];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="' . $row['id'] . '" data-toggle="modal" data-target="#MachineChecksheetInfoModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" onclick="get_details_machine_checksheets(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="6" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

if ($method == 'sou_mark_as_read') {
    $id = $_POST['id'];
    $sql = "UPDATE sou_forms SET is_read_a3 = 1 WHERE id = '$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

// Count
if ($method == 'count_sou_history') {
    $date_updated_from = $_POST['date_updated_from'];
    if (!empty($date_updated_from)) {
        $date_updated_from = date_create($date_updated_from);
        $date_updated_from = date_format($date_updated_from, "Y-m-d h:i:s");
    }
    $date_updated_to = $_POST['date_updated_to'];
    if (!empty($date_updated_to)) {
        $date_updated_to = date_create($date_updated_to);
        $date_updated_to = date_format($date_updated_to, "Y-m-d h:i:s");
    }
    $asset_name = addslashes($_POST['asset_name']);
    $kigyo_no = addslashes($_POST['kigyo_no']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $sou_no = $_POST['sou_no'];
    $sou_status = '';
    if (isset($_POST['sou_status'])) {
        $sou_status = $_POST['sou_status'];
    }

    $sql = "SELECT count(id) AS total FROM sou_forms";

    if (!empty($asset_name) || !empty($kigyo_no) || !empty($machine_no) || !empty($equipment_no) || !empty($sou_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
        $sql = $sql . " WHERE asset_name LIKE '$asset_name%' AND kigyo_no LIKE '$kigyo_no%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND sou_no LIKE '$sou_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to')";
    }

    if ($_SESSION['setup_approver_role'] == 3) {
        $sql = $sql . " AND sou_status = 'Confirmed'";
    } else if (!empty($sou_status) && $sou_status != 'All') {
        $sql = $sql . " AND sou_status = '$sou_status'";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    }
}

// Read / Load
if ($method == 'get_sou_history') {
    $id = $_POST['id'];
    $date_updated_from = $_POST['date_updated_from'];
    if (!empty($date_updated_from)) {
        $date_updated_from = date_create($date_updated_from);
        $date_updated_from = date_format($date_updated_from, "Y-m-d h:i:s");
    }
    $date_updated_to = $_POST['date_updated_to'];
    if (!empty($date_updated_to)) {
        $date_updated_to = date_create($date_updated_to);
        $date_updated_to = date_format($date_updated_to, "Y-m-d h:i:s");
    }
    $asset_name = addslashes($_POST['asset_name']);
    $kigyo_no = addslashes($_POST['kigyo_no']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $sou_no = $_POST['sou_no'];
    $sou_status = '';
    if (isset($_POST['sou_status'])) {
        $sou_status = $_POST['sou_status'];
    }
    $c = $_POST['c'];

    $sql = "SELECT id, sou_no, kigyo_no, asset_name, sup_asset_name, orig_asset_no, sou_date, quantity, managing_dept_code, managing_dept_name, install_area_code, install_area_name, machine_no, equipment_no, no_of_units, ntc_or_sa, use_purpose, date_updated FROM sou_forms";

    if (empty($id)) {
        if (!empty($asset_name) || !empty($kigyo_no) || !empty($machine_no) || !empty($equipment_no) || !empty($sou_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
            $sql = $sql . " WHERE asset_name LIKE '$asset_name%' AND kigyo_no LIKE '$kigyo_no%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND sou_no LIKE '$sou_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to')";
        }
    } else {
        $sql = $sql . " WHERE id < '$id'";
        if (!empty($asset_name) || !empty($kigyo_no) || !empty($machine_no) || !empty($equipment_no) || !empty($sou_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
            $sql = $sql . " AND (asset_name LIKE '$asset_name%' AND kigyo_no LIKE '$kigyo_no%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND sou_no LIKE '$sou_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to'))";
        }
    }
    if ($_SESSION['setup_approver_role'] == 3) {
        $sql = $sql . " AND sou_status = 'Confirmed'";
    } else if (!empty($sou_status) && $sou_status != 'All') {
        $sql = $sql . " AND sou_status = '$sou_status'";
    }
    $sql = $sql . " ORDER BY id DESC LIMIT 25";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="' . $row['id'] . '" data-toggle="modal" data-target="#SouInfoHistoryModal" data-id="' . $row['id'] . '" data-sou_no="' . $row['sou_no'] . '" data-kigyo_no="' . htmlspecialchars($row['kigyo_no']) . '" data-asset_name="' . htmlspecialchars($row['asset_name']) . '" data-sup_asset_name="' . htmlspecialchars($row['sup_asset_name']) . '" data-orig_asset_no="' . htmlspecialchars($row['orig_asset_no']) . '" data-sou_date="' . date("d-M-y", strtotime($row['sou_date'])) . '" data-quantity="' . $row['quantity'] . '" data-managing_dept_code="' . $row['managing_dept_code'] . '" data-managing_dept_name="' . htmlspecialchars($row['managing_dept_name']) . '" data-install_area_code="' . $row['install_area_code'] . '" data-install_area_name="' . htmlspecialchars($row['install_area_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-no_of_units="' . $row['no_of_units'] . '" data-ntc_or_sa="' . $row['ntc_or_sa'] . '" data-use_purpose="' . htmlspecialchars($row['use_purpose']) . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details_sou_history(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['sou_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['kigyo_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['asset_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['sup_asset_name']) . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['sou_date'])) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="9" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Read / Load
if ($method == 'get_sou_history_a3') {
    $id = $_POST['id'];
    $date_updated_from = $_POST['date_updated_from'];
    if (!empty($date_updated_from)) {
        $date_updated_from = date_create($date_updated_from);
        $date_updated_from = date_format($date_updated_from, "Y-m-d h:i:s");
    }
    $date_updated_to = $_POST['date_updated_to'];
    if (!empty($date_updated_to)) {
        $date_updated_to = date_create($date_updated_to);
        $date_updated_to = date_format($date_updated_to, "Y-m-d h:i:s");
    }
    $asset_name = addslashes($_POST['asset_name']);
    $kigyo_no = addslashes($_POST['kigyo_no']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $sou_no = $_POST['sou_no'];
    $c = $_POST['c'];

    $row_class_arr = array('modal-trigger', 'modal-trigger bg-lime');
    $row_class = $row_class_arr[0];

    $sql = "SELECT id, sou_no, kigyo_no, asset_name, sup_asset_name, orig_asset_no, sou_date, quantity, managing_dept_code, managing_dept_name, install_area_code, install_area_name, machine_no, equipment_no, no_of_units, ntc_or_sa, use_purpose, is_read_a3, date_updated FROM sou_forms";

    if (empty($id)) {
        if (!empty($asset_name) || !empty($kigyo_no) || !empty($machine_no) || !empty($equipment_no) || !empty($sou_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
            $sql = $sql . " WHERE asset_name LIKE '$asset_name%' AND kigyo_no LIKE '$kigyo_no%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND sou_no LIKE '$sou_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to')";
        }
    } else {
        $sql = $sql . " WHERE id < '$id'";
        if (!empty($asset_name) || !empty($kigyo_no) || !empty($machine_no) || !empty($equipment_no) || !empty($sou_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
            $sql = $sql . " AND (asset_name LIKE '$asset_name%' AND kigyo_no LIKE '$kigyo_no%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND sou_no LIKE '$sou_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to'))";
        }
    }
    if ($_SESSION['setup_approver_role'] == 3) {
        $sql = $sql . " AND sou_status = 'Confirmed'";
    }
    $sql = $sql . " ORDER BY id DESC LIMIT 25";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['is_read_a3'] == 0) {
                $row_class = $row_class_arr[1];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="' . $row['id'] . '" data-toggle="modal" data-target="#SouInfoHistoryModal" data-id="' . $row['id'] . '" data-sou_no="' . $row['sou_no'] . '" data-kigyo_no="' . htmlspecialchars($row['kigyo_no']) . '" data-asset_name="' . htmlspecialchars($row['asset_name']) . '" data-sup_asset_name="' . htmlspecialchars($row['sup_asset_name']) . '" data-orig_asset_no="' . htmlspecialchars($row['orig_asset_no']) . '" data-sou_date="' . date("d-M-y", strtotime($row['sou_date'])) . '" data-quantity="' . $row['quantity'] . '" data-managing_dept_code="' . $row['managing_dept_code'] . '" data-managing_dept_name="' . htmlspecialchars($row['managing_dept_name']) . '" data-install_area_code="' . $row['install_area_code'] . '" data-install_area_name="' . htmlspecialchars($row['install_area_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-no_of_units="' . $row['no_of_units'] . '" data-ntc_or_sa="' . $row['ntc_or_sa'] . '" data-use_purpose="' . htmlspecialchars($row['use_purpose']) . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details_sou_history(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['sou_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['kigyo_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['asset_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['sup_asset_name']) . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['sou_date'])) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="9" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

if ($method == 'fat_mark_as_read') {
    $id = $_POST['id'];
    $sql = "UPDATE fat_forms SET is_read_a3 = 1 WHERE id = '$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

// Count
if ($method == 'count_fat_history') {
    $date_updated_from = $_POST['date_updated_from'];
    if (!empty($date_updated_from)) {
        $date_updated_from = date_create($date_updated_from);
        $date_updated_from = date_format($date_updated_from, "Y-m-d h:i:s");
    }
    $date_updated_to = $_POST['date_updated_to'];
    if (!empty($date_updated_to)) {
        $date_updated_to = date_create($date_updated_to);
        $date_updated_to = date_format($date_updated_to, "Y-m-d h:i:s");
    }
    $item_description = addslashes($_POST['item_description']);
    $item_name = addslashes($_POST['item_name']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $fat_no = $_POST['fat_no'];
    $fat_status = '';
    if (isset($_POST['fat_status'])) {
        $fat_status = $_POST['fat_status'];
    }

    $sql = "SELECT count(id) AS total FROM fat_forms";

    if (!empty($item_description) || !empty($item_name) || !empty($machine_no) || !empty($equipment_no) || !empty($fat_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
        $sql = $sql . " WHERE item_description LIKE '$item_description%' AND item_name LIKE '$item_name%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND fat_no LIKE '$fat_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to')";
    }

    if ($_SESSION['setup_approver_role'] == 3) {
        $sql = $sql . " AND fat_status = 'Confirmed'";
    } else if (!empty($fat_status) && $fat_status != 'All') {
        $sql = $sql . " AND fat_status = '$fat_status'";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    }
}

// Read / Load
if ($method == 'get_fat_history') {
    $id = $_POST['id'];
    $date_updated_from = $_POST['date_updated_from'];
    if (!empty($date_updated_from)) {
        $date_updated_from = date_create($date_updated_from);
        $date_updated_from = date_format($date_updated_from, "Y-m-d h:i:s");
    }
    $date_updated_to = $_POST['date_updated_to'];
    if (!empty($date_updated_to)) {
        $date_updated_to = date_create($date_updated_to);
        $date_updated_to = date_format($date_updated_to, "Y-m-d h:i:s");
    }
    $item_description = addslashes($_POST['item_description']);
    $item_name = addslashes($_POST['item_name']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $fat_no = $_POST['fat_no'];
    $fat_status = '';
    if (isset($_POST['fat_status'])) {
        $fat_status = $_POST['fat_status'];
    }

    $c = $_POST['c'];

    $sql = "SELECT id, fat_no, item_name, item_description, machine_no, equipment_no, asset_tag_no, prev_location_group, prev_location_loc, prev_location_grid, date_transfer, new_location_group, new_location_loc, new_location_grid, reason, date_updated FROM fat_forms";

    if (empty($id)) {
        if (!empty($item_description) || !empty($item_name) || !empty($machine_no) || !empty($equipment_no) || !empty($fat_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
            $sql = $sql . " WHERE item_description LIKE '$item_description%' AND item_name LIKE '$item_name%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND fat_no LIKE '$fat_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to')";
        }
    } else {
        $sql = $sql . " WHERE id < '$id'";
        if (!empty($item_description) || !empty($item_name) || !empty($machine_no) || !empty($equipment_no) || !empty($fat_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
            $sql = $sql . " AND (item_description LIKE '$item_description%' AND item_name LIKE '$item_name%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND fat_no LIKE '$fat_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to'))";
        }
    }
    if ($_SESSION['setup_approver_role'] == 3) {
        $sql = $sql . " AND fat_status = 'Confirmed'";
    } else if (!empty($fat_status) && $fat_status != 'All') {
        $sql = $sql . " AND fat_status = '$fat_status'";
    }
    $sql = $sql . " ORDER BY id DESC LIMIT 25";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="' . $row['id'] . '" data-toggle="modal" data-target="#FatInfoHistoryModal" data-id="' . $row['id'] . '" data-fat_no="' . $row['fat_no'] . '" data-item_name="' . htmlspecialchars($row['item_name']) . '" data-item_description="' . htmlspecialchars($row['item_description']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-asset_tag_no="' . htmlspecialchars($row['asset_tag_no']) . '" data-prev_location_group="' . htmlspecialchars($row['prev_location_group']) . '" data-prev_location_loc="' . htmlspecialchars($row['prev_location_loc']) . '" data-prev_location_grid="' . htmlspecialchars($row['prev_location_grid']) . '" data-date_transfer="' . date("d-M-y", strtotime($row['date_transfer'])) . '" data-new_location_group="' . htmlspecialchars($row['new_location_group']) . '" data-new_location_loc="' . htmlspecialchars($row['new_location_loc']) . '" data-new_location_grid="' . htmlspecialchars($row['new_location_grid']) . '" data-reason="' . htmlspecialchars($row['reason']) . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details_fat_history(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['fat_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['item_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['item_description']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['asset_tag_no']) . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['date_transfer'])) . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="9" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Read / Load
if ($method == 'get_fat_history_a3') {
    $id = $_POST['id'];
    $date_updated_from = $_POST['date_updated_from'];
    if (!empty($date_updated_from)) {
        $date_updated_from = date_create($date_updated_from);
        $date_updated_from = date_format($date_updated_from, "Y-m-d h:i:s");
    }
    $date_updated_to = $_POST['date_updated_to'];
    if (!empty($date_updated_to)) {
        $date_updated_to = date_create($date_updated_to);
        $date_updated_to = date_format($date_updated_to, "Y-m-d h:i:s");
    }
    $item_description = addslashes($_POST['item_description']);
    $item_name = addslashes($_POST['item_name']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $fat_no = $_POST['fat_no'];
    $c = $_POST['c'];

    $row_class_arr = array('modal-trigger', 'modal-trigger bg-lime');
    $row_class = $row_class_arr[0];

    $sql = "SELECT id, fat_no, item_name, item_description, machine_no, equipment_no, asset_tag_no, prev_location_group, prev_location_loc, prev_location_grid, date_transfer, new_location_group, new_location_loc, new_location_grid, reason, is_read_a3, date_updated FROM fat_forms";

    if (empty($id)) {
        if (!empty($item_description) || !empty($item_name) || !empty($machine_no) || !empty($equipment_no) || !empty($fat_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
            $sql = $sql . " WHERE item_description LIKE '$item_description%' AND item_name LIKE '$item_name%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND fat_no LIKE '$fat_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to')";
        }
    } else {
        $sql = $sql . " WHERE id < '$id'";
        if (!empty($item_description) || !empty($item_name) || !empty($machine_no) || !empty($equipment_no) || !empty($fat_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
            $sql = $sql . " AND (item_description LIKE '$item_description%' AND item_name LIKE '$item_name%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND fat_no LIKE '$fat_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to'))";
        }
    }
    if ($_SESSION['setup_approver_role'] == 3) {
        $sql = $sql . " AND fat_status = 'Confirmed'";
    }
    $sql = $sql . " ORDER BY id DESC LIMIT 25";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['is_read_a3'] == 0) {
                $row_class = $row_class_arr[1];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="' . $row['id'] . '" data-toggle="modal" data-target="#FatInfoHistoryModal" data-id="' . $row['id'] . '" data-fat_no="' . $row['fat_no'] . '" data-item_name="' . htmlspecialchars($row['item_name']) . '" data-item_description="' . htmlspecialchars($row['item_description']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-asset_tag_no="' . htmlspecialchars($row['asset_tag_no']) . '" data-prev_location_group="' . htmlspecialchars($row['prev_location_group']) . '" data-prev_location_loc="' . htmlspecialchars($row['prev_location_loc']) . '" data-prev_location_grid="' . htmlspecialchars($row['prev_location_grid']) . '" data-date_transfer="' . date("d-M-y", strtotime($row['date_transfer'])) . '" data-new_location_group="' . htmlspecialchars($row['new_location_group']) . '" data-new_location_loc="' . htmlspecialchars($row['new_location_loc']) . '" data-new_location_grid="' . htmlspecialchars($row['new_location_grid']) . '" data-reason="' . htmlspecialchars($row['reason']) . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details_fat_history(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['fat_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['item_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['item_description']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['asset_tag_no']) . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['date_transfer'])) . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="9" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

$conn = null;
