<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['pm_username'])) {
    header('location:../../../login/');
    exit();
} else {
    if ($_SESSION['pm_role'] == "Prod") {
        header('location:../prod/home.php');
        exit();
    } else if ($_SESSION['pm_role'] == "QA") {
        header('location:../qa/home.php');
        exit();
    }
}

require('../db/conn.php');

switch (true) {
    case !isset($_GET['pm_plan_year']):
    case !isset($_GET['ww_no']):
        echo 'Query Parameters Not Set';
        exit();
        break;
}

$pm_plan_year = $_GET['pm_plan_year'];
$ww_no = $_GET['ww_no'];

$sql = "SELECT id, number, process, machine_name, car_model, machine_no, equipment_no, pm_plan_year, ww_no, ww_start_date, frequency, manpower, sched_start_date_time, sched_end_date_time, machine_status, pm_status FROM machine_pm_plan WHERE pm_plan_year LIKE '$pm_plan_year%'";

if (!empty($ww_no)) {
    $sql = $sql . " AND ww_no LIKE '$ww_no%'";
}

$stmt = $conn->prepare($sql);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $delimiter = ",";
    $datenow = date('Y-m-d');
    $filename = "EMS-PM_WorkWeek_" . $pm_plan_year . "-" . $datenow . ".csv";

    // Create a file pointer 
    $f = fopen('php://memory', 'w');

    // Set column headers 
    $fields = array('No.', 'PM Plan Year', 'WW No.', 'Machine Name', 'Machine No.', 'Equipment No.', 'Frequency', 'Car Model', 'Manpower', 'WW Start Date', 'Start Date & Time', 'End Date & Time', 'Machine Status', 'PM Status');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as csv and write to file pointer 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $machine_no = "=\"" . $row['machine_no'] . "\"";
        $equipment_no = "=\"" . $row['equipment_no'] . "\"";
        $sched_start_date_time = $row['sched_start_date_time'];
        $sched_end_date_time = $row['sched_end_date_time'];
        if (!empty($sched_start_date_time)) {
            $sched_end_date_time = date("Y-m-d h:iA", strtotime($row['sched_start_date_time']));
        }
        if (!empty($sched_end_date_time)) {
            $sched_end_date_time = date("Y-m-d h:iA", strtotime($row['sched_end_date_time']));
        }
        $lineData = array($row['number'], $row['pm_plan_year'], $row['ww_no'], $row['machine_name'], $machine_no, $equipment_no, $row['frequency'], $row['car_model'], $row['manpower'], $row['ww_start_date'], $sched_end_date_time, $sched_end_date_time, $row['machine_status'], $row['pm_status']);
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
