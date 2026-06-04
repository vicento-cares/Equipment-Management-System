<?php
session_set_cookie_params(0, "/eems");
session_name("eems");
session_start();

if (!isset($_SESSION['setup_username'])) {
    header('location:../../../login/');
    exit();
} else {
    if ($_SESSION['setup_approver_role'] == "1") {
        header('location:../approver1/home.php');
        exit();
    } else if ($_SESSION['setup_approver_role'] == "2") {
        header('location:../approver2/home.php');
        exit();
    } else if ($_SESSION['setup_approver_role'] == "3") {
        header('location:../approver3/home.php');
        exit();
    }
}

require('../db/conn.php');

switch (true) {
    case !isset($_GET['machine_name']):
    case !isset($_GET['process']):
    case !isset($_GET['car_model']):
        echo 'Query Parameters Not Set';
        exit();
        break;
}

$machine_name = $_GET['machine_name'];
$process = $_GET['process'];
$car_model = $_GET['car_model'];

$sql = "SELECT id, number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, [ns_iv_no], machine_status, is_new, date_updated FROM m_machine_masterlist";
$params = [];

if (!empty($car_model)) {
    $sql = $sql . " WHERE car_model = ?";
    $params[] = $car_model;
    if ($process != 'All' && $machine_name != 'All') {
        $sql = $sql . " AND process = ? AND machine_name = ?";
        $params[] = $process;
        $params[] = $machine_name;
    } else if ($process != 'All' && $machine_name == 'All') {
        $sql = $sql . " AND process = ?";
        $params[] = $process;
    } else if ($process == 'All' && $machine_name != 'All') {
        $sql = $sql . " AND machine_name = ?";
        $params[] = $machine_name;
    }
} else {
    if ($process != 'All' && $machine_name != 'All') {
        $sql = $sql . " WHERE process = ? AND machine_name = ?";
        $params[] = $process;
        $params[] = $machine_name;
    } else if ($process != 'All' && $machine_name == 'All') {
        $sql = $sql . " WHERE process = ?";
        $params[] = $process;
    } else if ($process == 'All' && $machine_name != 'All') {
        $sql = $sql . " WHERE machine_name = ?";
        $params[] = $machine_name;
    }
}

$stmt = $conn->prepare($sql);
$stmt->execute($params);

$delimiter = ",";
$datenow = date('Y-m-d');
$filename = "EMS-Setup_MachineMasterlist-" . $datenow . ".csv";

// Create a file pointer 
$f = fopen('php://memory', 'w');

// Set column headers 
$fields = array('Number', 'Process', 'Machine Name', 'Machine Specification', 'Car Model', 'Location', 'Grid', 'Machine No.', 'Equipment No.', 'Asset Tag No.', 'TRD No.', 'NS-IV No.');
fputcsv($f, $fields, $delimiter);

// Output each row of the data, format line as csv and write to file pointer 
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $machine_no = "=\"" . $row['machine_no'] . "\"";
    $equipment_no = "=\"" . $row['equipment_no'] . "\"";
    $lineData = array($row['number'], $row['process'], $row['machine_name'], $row['machine_spec'], $row['car_model'], $row['location'], $row['grid'], $machine_no, $equipment_no, $row['asset_tag_no'], $row['trd_no'], $row['ns_iv_no']);
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
