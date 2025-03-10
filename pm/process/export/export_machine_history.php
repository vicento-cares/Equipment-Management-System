<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['pm_username'])) {
    header('location:../../../login/');
    exit;
} else {
    if ($_SESSION['pm_role'] == "Prod") {
        header('location:../prod/home.php');
        exit;
    } else if ($_SESSION['pm_role'] == "QA") {
        header('location:../qa/home.php');
        exit;
    }
}

require('../db/conn.php');

switch (true) {
	case !isset($_GET['history_date_from']):
	case !isset($_GET['history_date_to']):
	case !isset($_GET['car_model']):
    case !isset($_GET['machine_name']):
    case !isset($_GET['machine_no']):
    case !isset($_GET['equipment_no']):
        echo 'Query Parameters Not Set';
        exit;
        break;
}

$history_date_from = $_GET['history_date_from'];
$history_date_to = $_GET['history_date_to'];
$car_model = $_GET['car_model'];
$machine_name = $_GET['machine_name'];
$machine_no = $_GET['machine_no'];
$equipment_no = $_GET['equipment_no'];

$sql = "SELECT id, number, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, `ns-iv_no`, machine_status, new_car_model, new_location, new_grid, pic, status_date, history_date_time FROM machine_history";

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
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "EMS-Setup_MachineHistory-".$datenow.".csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('History Date & Time', 'No.', 'Machine Name', 'Machine Specification', 'Car Model', 'Location', 'Grid', 'Machine No.', 'Equipment No.', 'Asset Tag No.', 'TRD No.', 'NS-IV No.', 'Machine Status', 'New Car Model', 'New Location', 'New Grid', 'PIC', 'Status Date'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $machine_no = "=\"".$row['machine_no']."\"";
        $equipment_no = "=\"".$row['equipment_no']."\"";
        $lineData = array($row['history_date_time'], $row['number'], $row['machine_name'], $row['machine_spec'], $row['car_model'], $row['location'], $row['grid'], $machine_no, $equipment_no, $row['asset_tag_no'], $row['trd_no'], $row['ns-iv_no'], $row['machine_status'], $row['new_car_model'], $row['new_location'], $row['new_grid'], $row['pic'], $row['status_date']); 
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