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
	}
}

require('../db/conn.php');

switch (true) {
	case !isset($_GET['date_updated_from']):
	case !isset($_GET['date_updated_to']):
	case !isset($_GET['asset_name']):
    case !isset($_GET['sou_no']):
    case !isset($_GET['kigyo_no']):
    case !isset($_GET['machine_no']):
    case !isset($_GET['equipment_no']):
        echo 'Query Parameters Not Set';
        exit;
        break;
}

$date_updated_from = $_GET['date_updated_from'];
$date_updated_to = $_GET['date_updated_to'];
$asset_name = $_GET['asset_name'];
$sou_no = $_GET['sou_no'];
$kigyo_no = $_GET['kigyo_no'];
$machine_no = $_GET['machine_no'];
$equipment_no = $_GET['equipment_no'];

$sql = "SELECT id, sou_no, kigyo_no, asset_name, sup_asset_name, orig_asset_no, sou_date, quantity, managing_dept_code, managing_dept_name, install_area_code, install_area_name, machine_no, equipment_no, no_of_units, ntc_or_sa, use_purpose, date_updated FROM sou_forms";

if (!empty($asset_name) || !empty($kigyo_no) || !empty($machine_no) || !empty($equipment_no) || !empty($sou_no) || (!empty($date_updated_from) && !empty($date_updated_to))) {
    $sql = $sql . " WHERE asset_name LIKE '$asset_name%' AND kigyo_no LIKE '$kigyo_no%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND sou_no LIKE '$sou_no%' AND (date_updated >= '$date_updated_from' AND date_updated <= '$date_updated_to')";
}

$sql = $sql . " ORDER BY id DESC";

$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "EMS-Setup_SOU-".$datenow.".csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('SOU No.', 'Kigyo No.', 'Asset Name', 'Supplementary Asset Name', 'Original Asset No.', 'Start of Utilization Date', 'Quantity', 'Managing Department Code', 'Managing Department Name', 'Installation Area Code', 'Installation Area Name', 'Machine No.', 'Equipment No.', 'No. of Units', 'Need to Convert or Standalone', 'Use Purpose', 'Date Updated'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
        $kigyo_no = "=\"".$row['kigyo_no']."\"";
        $machine_no = "=\"".$row['machine_no']."\"";
        $equipment_no = "=\"".$row['equipment_no']."\"";
        $lineData = array($row['sou_no'], $kigyo_no, $row['asset_name'], $row['sup_asset_name'], $row['orig_asset_no'], $row['sou_date'], $row['quantity'], $row['managing_dept_code'], $row['managing_dept_name'], $row['install_area_code'], $row['install_area_name'], $machine_no, $equipment_no, $row['no_of_units'], $row['ntc_or_sa'], $row['use_purpose'], date("Y-m-d h:iA", strtotime($row['date_updated']))); 
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