<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
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
    }
}

require('../db/conn.php');

if (!isset($_GET['id'])) {
    echo 'Query Parameters Not Set';
    exit();
}

$id = $_GET['id'];

$sql = "SELECT id, fat_no, item_name, item_description, machine_no, equipment_no, asset_tag_no, prev_location_group, prev_location_loc, prev_location_grid, date_transfer, new_location_group, new_location_loc, new_location_grid, reason, date_updated FROM fat_forms WHERE id = '$id' ORDER BY id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $delimiter = ",";
    $datenow = date('Y-m-d');
    $filename = "EMS-Setup_FAT-" . $datenow . ".csv";

    // Create a file pointer 
    $f = fopen('php://memory', 'w');

    // Set column headers 
    $fields = array('FAT No.', 'Item Name', 'Item Description', 'Machine No.', 'Equipment No.', 'Asset Tag No.', 'Previous Location - Group', 'Previous Location - Line/Grid', 'Date Transferred', 'New Location - Group', 'New Location - Line/Grid', 'Reason for Transfer', 'Date Updated');
    fputcsv($f, $fields, $delimiter);

    // Output each row of the data, format line as csv and write to file pointer 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $machine_no = "=\"" . $row['machine_no'] . "\"";
        $equipment_no = "=\"" . $row['equipment_no'] . "\"";
        $previous_location_line_grid = "";
        if (!empty($row['prev_location_grid'])) {
            $previous_location_line_grid = $row['prev_location_loc'] . "/" . $row['prev_location_grid'];
        } else {
            $previous_location_line_grid = $row['prev_location_loc'];
        }
        $new_location_line_grid = "";
        if (!empty($row['new_location_grid'])) {
            $new_location_line_grid = $row['new_location_loc'] . "/" . $row['new_location_grid'];
        } else {
            $new_location_line_grid = $row['new_location_loc'];
        }

        $lineData = array($row['fat_no'], $row['item_name'], $row['item_description'], $machine_no, $equipment_no, $row['asset_tag_no'], $row['prev_location_group'], $previous_location_line_grid, $row['date_transfer'], $row['new_location_group'], $new_location_line_grid, $row['reason'], date("Y-m-d h:iA", strtotime($row['date_updated'])));
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
