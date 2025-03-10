<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['setup_username'])) {
  header('location:../../../login/');
  exit;
} else {
	if ($_SESSION['setup_approver_role'] == "1") {
		header('location:../approver1/home.php');
		exit;
	} else if ($_SESSION['setup_approver_role'] == "2") {
		header('location:../approver2/home.php');
		exit;
	} else if ($_SESSION['setup_approver_role'] == "3") {
		header('location:../approver3/home.php');
		exit;
	}
}

require('../db/conn.php');

switch (true) {
	case !isset($_GET['machine_no']):
	case !isset($_GET['equipment_no']):
    case !isset($_GET['machine_name']):
    case !isset($_GET['car_model']):
    case !isset($_GET['status']):
    case !isset($_GET['unused_machine_location']):
        echo 'Query Parameters Not Set';
        exit;
        break;
}

$machine_no = addslashes($_GET['machine_no']);
$equipment_no = addslashes($_GET['equipment_no']);
$machine_name = addslashes($_GET['machine_name']);
$car_model = addslashes($_GET['car_model']);
$status = addslashes($_GET['status']);
$unused_machine_location = addslashes($_GET['unused_machine_location']);
$c = 0;

$sql = "SELECT machine_name, machine_no, equipment_no, car_model, asset_tag_no, status, reserved_for, remarks, pic, unused_machine_location, target_date FROM unused_machines";

if (!empty($machine_no) || !empty($equipment_no) || !empty($machine_name) || !empty($status) || !empty($car_model) || !empty($unused_machine_location)) {
	$sql = $sql . " WHERE machine_no LIKE '$machine_no%' OR equipment_no LIKE '$equipment_no%' OR machine_name LIKE '$machine_name%' OR status LIKE '$status%' OR car_model LIKE '$car_model%' OR unused_machine_location LIKE '$unused_machine_location%'";
}

$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "EMS-Setup_UnusedMachines-".$datenow.".csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('No.', 'Machine Name', 'Machine No.', 'Equipment No.', 'Car Model', 'Asset Tag No.', 'Status', 'Reserved For', 'Remarks', 'PIC', 'Unused Machine Location', 'Target Date'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
    	$c++;
        $machine_no = "=\"".$row['machine_no']."\"";
        $equipment_no = "=\"".$row['equipment_no']."\"";
        $lineData = array($c, $row['machine_name'], $machine_no, $equipment_no, $row['car_model'], $row['asset_tag_no'], $row['status'], $row['reserved_for'], $row['remarks'], $row['pic'], $row['unused_machine_location'], $row['target_date']); 
        fputcsv($f, $lineData, $delimiter); 
    } 
     
    // Move back to beginning of file 
    fseek($f, 0); 
     
    // Set headers to download file rather than displayed 
    header('Content-Type: text/csv'); 
    header('Content-Disposition: attachment; filename="' . $filename . '";'); 
     
    //output all remaining data on a file pointer 
    fpassthru($f); 
}

$conn = null;

?>