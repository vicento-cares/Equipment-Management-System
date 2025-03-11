<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');
require('../lib/validate.php');
require('../lib/main.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');

function check_existing_machine_name($machine_name, $conn)
{
    $machine_name = addslashes($machine_name);
    $sql = "SELECT machine_name FROM machines WHERE machine_name = '$machine_name'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}

// Get Machines Dropdown
if ($method == 'fetch_machines_dropdown') {
    $sql = "SELECT machine_name FROM machines ORDER BY machine_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option disabled selected value="">Select Machine Name</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['machine_name']) . '">' . htmlspecialchars($row['machine_name']) . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Select Machine Name</option>';
    }
}

if ($method == 'fetch_machines_dropdown_all') {
    $sql = "SELECT machine_name FROM machines ORDER BY machine_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option selected value="All">All Machines</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['machine_name']) . '">' . htmlspecialchars($row['machine_name']) . '</option>';
        }
    } else {
        echo '<option selected value="All">All Machines</option>';
    }
}

if ($method == 'fetch_machines_datalist_search') {
    $sql = "SELECT machine_name FROM machines ORDER BY machine_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['machine_name']) . '">';
        }
    }
}

if ($method == 'get_machine_details') {
    $machine_name = $_POST['machine_name'];
    $response_arr = get_machine_details($machine_name, $conn);

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'get_machine_details_by_id') {
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $response_arr = get_machine_details_by_id($machine_no, $equipment_no, $conn);

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'fetch_machine_no_datalist') {
    $sql = "SELECT machine_no FROM machine_masterlist WHERE machine_no!='' ORDER BY machine_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['machine_no']) . '">';
        }
    }
}

if ($method == 'fetch_equipment_no_datalist') {
    $sql = "SELECT equipment_no FROM machine_masterlist WHERE equipment_no!='' ORDER BY equipment_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['equipment_no']) . '">';
        }
    }
}

// Count
if ($method == 'count_data') {
    $process = $_POST['process'];
    $machine_name = addslashes($_POST['machine_name']);
    $sql = "SELECT count(id) AS total FROM machines";
    if (!empty($machine_name)) {
        $sql = $sql . " WHERE machine_name LIKE '$machine_name%'";
        if ($process != 'All') {
            $sql = $sql . " AND process = '$process'";
        }
    } else if ($process != 'All') {
        $sql = $sql . " WHERE process = '$process'";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    }
}

// Read / Load
if ($method == 'fetch_data') {
    $id = $_POST['id'];
    $process = $_POST['process'];
    $machine_name = addslashes($_POST['machine_name']);
    $c = $_POST['c'];
    $sql = "SELECT id, number, process, machine_name, date_updated FROM machines";

    if (empty($id)) {
        if (!empty($machine_name)) {
            $sql = $sql . " WHERE machine_name LIKE '$machine_name%'";
            if ($process != 'All') {
                $sql = $sql . " AND process = '$process'";
            }
        } else if ($process != 'All') {
            $sql = $sql . " WHERE process = '$process'";
        }
    } else {
        $sql = $sql . " WHERE id > '$id'";
        if (!empty($machine_name)) {
            $sql = $sql . " AND (machine_name LIKE '$machine_name%'";
            if ($process != 'All') {
                $sql = $sql . " AND process = '$process'";
            }
            $sql = $sql . ")";
        } else if ($process != 'All') {
            $sql = $sql . " AND (process = '$process'";
            $sql = $sql . ")";
        }
    }
    $sql = $sql . " ORDER BY id ASC LIMIT 25";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr id="' . $row['id'] . '">';
            echo '<td>' . $row['number'] . '</td>';
            echo '<td>' . $row['process'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="4" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Create / Insert
if ($method == 'save_data') {
    $process = $_POST['process'];
    $machine_name = custom_trim($_POST['machine_name']);

    $is_valid = false;

    if (!empty($process)) {
        if (!empty($machine_name)) {
            $is_valid = true;
        } else
            echo 'Machine Name Empty';
    } else
        echo 'Process Not Set';

    if ($is_valid == true) {
        $is_exists = check_existing_machine_name($machine_name, $conn);
        if ($is_exists == true) {
            echo 'Machine Name Exists';
        } else {
            $machine_name = addslashes($machine_name);

            $sql = "INSERT INTO machines (process, machine_name, date_updated) VALUES ('$process', '$machine_name', '$date_updated')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            echo 'success';
        }
    }
}

$conn = null;
