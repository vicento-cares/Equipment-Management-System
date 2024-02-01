<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['sp_username'])) {
  header('location:../../../login/');
  exit;
}

require('../db/conn.php');

switch (true) {
    case !isset($_GET['concern_date_from']):
    case !isset($_GET['concern_date_to']):
    case !isset($_GET['machine_name']):
    case !isset($_GET['car_model']):
    case !isset($_GET['pm_concern_id']):
    case !isset($_GET['pm_concern_status']):
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
$pm_concern_status = $_GET['pm_concern_status'];
$c = 0;

$sql = "SELECT `id`, `pm_concern_id`, `machine_line`, `machine_name`, `car_model`, `trd_no`, `ns-iv_no`, `problem`, `request_by`, `confirm_by`, `comment`, `concern_date_time`, `parts_code`, `quantity`, `po_date`, `po_no`, `no_spare_status`, `date_arrived`, `status`, `date_updated`";

if ($pm_concern_status == 'Pending') {
  $sql = $sql . " FROM `machine_pm_no_spare`";
} else if ($pm_concern_status == 'Done') {
  $sql = $sql . " FROM `machine_pm_no_spare_history`";
}

if (!empty($machine_name) || !empty($car_model) || !empty($pm_concern_id) || (!empty($concern_date_from) && !empty($concern_date_to))) {
  $sql = $sql . " WHERE `machine_name` LIKE '$machine_name%' AND `car_model` LIKE '$car_model%' AND `pm_concern_id` LIKE '$pm_concern_id%' AND (concern_date_time >= '$concern_date_from' AND concern_date_time <= '$concern_date_to')";
}

$sql = $sql . " AND `no_spare_status`= 'CLOSE' ORDER BY id DESC";

$stmt = $conn -> prepare($sql);
$stmt -> execute();
if ($stmt -> rowCount() > 0) {
	$delimiter = ","; 
    $datenow = date('Y-m-d');
    $filename = "EMS-PM_NoSpareHistory-".$datenow.".csv";
     
    // Create a file pointer 
    $f = fopen('php://memory', 'w'); 
     
    // Set column headers 
    $fields = array('No.', 'Date Updated', 'PM Concern ID', 'Machine Line', 'Machine Name', 'Car Model', 'TRD No.', 'NS-IV No.', 'Problem', 'Request By', 'Confirm By', 'Comment', 'Concern Date & Time', 'Parts Code', 'Quantity', 'PO Date', 'PO No.', 'No Spare Status', 'Date Arrived', 'Status'); 
    fputcsv($f, $fields, $delimiter); 
     
    // Output each row of the data, format line as csv and write to file pointer 
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
      $c++; 
      $date_updated = $row['date_updated'];
      if (!empty($date_updated)) {
        $date_updated = date("Y-m-d h:iA", strtotime($row['date_updated']));
      }
      $concern_date_time = $row['concern_date_time'];
      if (!empty($concern_date_time)) {
        $concern_date_time = date("Y-m-d h:iA", strtotime($row['concern_date_time']));
      }
      $po_date = $row['po_date'];
      if (!empty($po_date)) {
        $po_date = date("Y-m-d", strtotime($row['po_date']));
      }
      $date_arrived = $row['date_arrived'];
      if (!empty($date_arrived)) {
        $date_arrived = date("Y-m-d", strtotime($row['date_arrived']));
      }

      $lineData = array($c, $date_updated, $row['pm_concern_id'], $row['machine_line'], $row['machine_name'], $row['car_model'], $row['trd_no'], $row['ns-iv_no'], $row['problem'], $row['request_by'], $row['confirm_by'], $row['comment'], $concern_date_time, $row['parts_code'], $row['quantity'], $po_date, $row['po_no'], $row['no_spare_status'], $date_arrived, $row['status']); 
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