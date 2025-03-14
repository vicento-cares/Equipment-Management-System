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

$sql = "SELECT location FROM locations ORDER BY location ASC";

$stmt = $conn->prepare($sql);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $delimiter = ",";
    $datenow = date('Y-m-d');
    $filename = "EMS-PM_Locations-" . $datenow . ".csv";

    // Create a file pointer 
    $f = fopen('php://memory', 'w');

    // Set column headers 
    $fields = array('Location');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as csv and write to file pointer 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $lineData = array($row['location']);
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
