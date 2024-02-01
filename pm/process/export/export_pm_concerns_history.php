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
    case !isset($_GET['concern_date_from']):
    case !isset($_GET['concern_date_to']):
    case !isset($_GET['machine_name']):
    case !isset($_GET['car_model']):
    case !isset($_GET['pm_concern_id']):
        echo 'Query Parameters Not Set';
        exit;
        break;
}

$concern_date_from = $_GET['concern_date_from'];
if (!empty($concern_date_from)) {
  $concern_date_from = date_create($concern_date_from);
  $concern_date_from = date_format($concern_date_from,"Y-m-d H:i:s");
}
$concern_date_to = $_GET['concern_date_to'];
if (!empty($concern_date_to)) {
  $concern_date_to = date_create($concern_date_to);
  $concern_date_to = date_format($concern_date_to,"Y-m-d H:i:s");
}
$machine_name = addslashes($_GET['machine_name']);
$car_model = addslashes($_GET['car_model']);
$pm_concern_id = $_GET['pm_concern_id'];
$c = 0;

$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `confirm_by`, `comment`, `concern_date_time`, `no_of_parts` FROM `machine_pm_concerns`";

if (!empty($machine_name) || !empty($car_model) || !empty($pm_concern_id) || (!empty($concern_date_from) && !empty($concern_date_to))) {
  $sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `car_model` LIKE '$car_model%' AND `pm_concern_id` LIKE '$pm_concern_id%' AND (concern_date_time >= '$concern_date_from' AND concern_date_time <= '$concern_date_to')";
}

$sql = $sql . " AND `status`= 'Done' ORDER BY id DESC";

$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "EMS-PM_Concerns-".$datenow.".csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('No.', 'PM Concern ID', 'Machine Line', 'Machine Name', 'Car Model', 'TRD No.', 'NS-IV No.', 'Problem', 'Request By', 'Confirm By', 'Comment', 'No. of Parts', 'Concern Date & Time'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
      $c++; 
      $concern_date_time = $row['concern_date_time'];
      if (!empty($concern_date_time)) {
        $concern_date_time = date("Y-m-d h:iA", strtotime($row['concern_date_time']));
      }
      $lineData = array($c, $row['pm_concern_id'], $row['machine_line'], $row['machine_name'], $row['car_model'], $row['trd_no'], $row['ns-iv_no'], $row['problem'], $row['request_by'], $row['confirm_by'], $row['comment'], $row['no_of_parts'], $concern_date_time); 
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