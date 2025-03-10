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

$delimiter = ","; 
$datenow = date('Y-m-d');
$filename = "EMS-PM_CarModels-".$datenow.".csv";
 
// Create a file pointer 
$f = fopen('php://memory', 'w'); 
 
// Set column headers 
$fields = array('car_model'); 
fputcsv($f, $fields, $delimiter); 

$sql = "SELECT car_model FROM line_no_initial ORDER BY car_model ASC";

$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
  // Output each row of the data, format line as csv and write to file pointer 
  while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
      $lineData = array($row['car_model']); 
      fputcsv($f, $lineData, $delimiter); 
  } 
}

$sql = "SELECT car_model FROM line_no_final ORDER BY car_model ASC";

$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
  // Output each row of the data, format line as csv and write to file pointer 
  while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) { 
      $lineData = array($row['car_model']); 
      fputcsv($f, $lineData, $delimiter); 
  } 
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