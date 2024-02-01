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

$delimiter = ","; 
$datenow = date('Y-m-d');
$filename = "EMS-PM_PmPlanFormat-".$datenow.".csv";
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 
 
// Set column headers 
$fields = array('Number', 'Process', 'Machine Name', 'Machine Specification', 'Car Model', 'Location', 'Grid', 'Machine No.', 'Equipment No.', 'TRD No.', 'NS-IV No.', 'PM Plan Year', 'WW No.', 'WW Start Date', 'Frequency'); 
fputcsv($f, $fields, $delimiter); 

$sql = "SELECT `number`, `process`, `machine_name`, `machine_spec`, `car_model`, `location`, `grid`, `machine_no`, `equipment_no`, `trd_no`, `ns-iv_no` FROM `machine_masterlist` ORDER BY id DESC LIMIT 1";

$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
  // Output each row of the data, format line as csv and write to file pointer 
  while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
    $lineData = array('Example: ' . $row['number'], 'Process List: (Initial, Final)', $row['machine_name'], $row['machine_spec'], $row['car_model'], $row['location'], $row['grid'], $row['machine_no'], $row['equipment_no'], $row['trd_no'], $row['ns-iv_no'], 'Example: 2023', 'Example: WW1', 'Format: yyyy/mm/dd', 'Freq List: (W, M, 2, 3, 6, Y)'); 
    fputcsv($f, $lineData, $delimiter); 
  } 
} else {
  $lineData = array('Example: 1', 'Process List: (Initial, Final)', 'Example: Wire Stripper', 'machine spec', 'car model', 'location', 'grid', 'machine no.', 'equipment no.', 'trd no.', 'ns-iv no.', 'Example: 2023', 'Example: WW1', 'Format: yyyy/mm/dd', 'Freq List: (W, M, 2, 3, 6, Y)'); 
  fputcsv($f, $lineData, $delimiter); 
}

// Move back to beginning of file 
fseek($f, 0); 
 
// Set headers to download file rather than displayed 
header('Content-Type: text/csv'); 
header('Content-Disposition: attachment; filename="' . $filename . '";'); 
 
//output all remaining data on a file pointer 
fpassthru($f); 

$conn = null;

?>