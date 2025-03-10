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
    case !isset($_GET['machine_name']):
    case !isset($_GET['process']):
    case !isset($_GET['car_model']):
        echo 'Query Parameters Not Set';
        exit;
        break;
}

$machine_name = $_GET['machine_name'];
$process = $_GET['process'];
$car_model = $_GET['car_model'];

$sql = "SELECT id, number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, ns-iv_no, machine_status, is_new, date_updated FROM machine_masterlist";

if (!empty($car_model)) {
	$sql = $sql . " WHERE car_model = '$car_model'";
	if ($process != 'All' && $machine_name != 'All') {
		$sql = $sql . " AND process = '$process' AND machine_name = '$machine_name'";
	} else if ($process != 'All' && $machine_name == 'All') {
		$sql = $sql . " AND process = '$process'";
	} else if ($process == 'All' && $machine_name != 'All') {
		$sql = $sql . " AND machine_name = '$machine_name'";
	}
} else {
	if ($process != 'All' && $machine_name != 'All') {
		$sql = $sql . " WHERE process = '$process' AND machine_name = '$machine_name'";
	} else if ($process != 'All' && $machine_name == 'All') {
		$sql = $sql . " WHERE process = '$process'";
	} else if ($process == 'All' && $machine_name != 'All') {
		$sql = $sql . " WHERE machine_name = '$machine_name'";
	}
}

$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "EMS-PM_MachineMasterlist-".$datenow.".csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('Number', 'Process', 'Machine Name', 'Machine Specification', 'Car Model', 'Location', 'Grid', 'Machine No.', 'Equipment No.', 'Asset Tag No.', 'TRD No.', 'NS-IV No.'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $machine_no = "=\"".$row['machine_no']."\"";
        $equipment_no = "=\"".$row['equipment_no']."\"";
        $lineData = array($row['number'], $row['process'], $row['machine_name'], $row['machine_spec'], $row['car_model'], $row['location'], $row['grid'], $machine_no, $equipment_no, $row['asset_tag_no'], $row['trd_no'], $row['ns-iv_no']); 
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