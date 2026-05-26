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
    $sql = "SELECT machine_name FROM m_machines WHERE machine_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$machine_name]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return true;
    } else {
        return false;
    }
}

// Get m_machines Dropdown
if ($method == 'fetch_machines_dropdown') {
    $sql = "SELECT machine_name FROM m_machines ORDER BY machine_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option disabled selected value="">Select Machine Name</option>';
        do {
            echo '<option value="' . htmlspecialchars($row['machine_name']) . '">' . htmlspecialchars($row['machine_name']) . '</option>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<option disabled selected value="">Select Machine Name</option>';
    }
}

if ($method == 'fetch_machines_dropdown_all') {
    $sql = "SELECT machine_name FROM m_machines ORDER BY machine_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option selected value="All">All m_machines</option>';
        do {
            echo '<option value="' . htmlspecialchars($row['machine_name']) . '">' . htmlspecialchars($row['machine_name']) . '</option>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<option selected value="All">All m_machines</option>';
    }
}

if ($method == 'fetch_machines_datalist_search') {
    $sql = "SELECT machine_name FROM m_machines ORDER BY machine_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['machine_name']) . '">';
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
    $sql = "SELECT machine_no FROM m_machine_masterlist WHERE machine_no !='' ORDER BY machine_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['machine_no']) . '">';
    }
}

if ($method == 'fetch_equipment_no_datalist') {
    $sql = "SELECT equipment_no FROM m_machine_masterlist WHERE equipment_no !='' ORDER BY equipment_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['equipment_no']) . '">';
    }
}

// Count
if ($method == 'count_data') {
    $process = $_POST['process'];
    $machine_name = $_POST['machine_name'];

    $sql = "SELECT COUNT(id) AS total FROM m_machines";
    $params = [];

    if (!empty($machine_name)) {
        $sql = $sql . " WHERE machine_name LIKE ?";
        $params[] = $machine_name . "%";
        if ($process != 'All') {
            $sql = $sql . " AND process = ?";
            $params[] = $process;
        }
    } else if ($process != 'All') {
        $sql = $sql . " WHERE process = ?";
        $params[] = $process;
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['total'];
    }
}

// Read / Load
if ($method == 'fetch_data') {
    $id = $_POST['id'];
    $process = $_POST['process'];
    $machine_name = $_POST['machine_name'];
    $c = $_POST['c'];

    $sql = "SELECT TOP 25 id, number, process, machine_name, date_updated FROM m_machines";
    $params = [];

    if (empty($id)) {
        if (!empty($machine_name)) {
            $sql = $sql . " WHERE machine_name LIKE ?";
            $params[] = $machine_name . "%";
            if ($process != 'All') {
                $sql = $sql . " AND process = ?";
                $params[] = $process;
            }
        } else if ($process != 'All') {
            $sql = $sql . " WHERE process = ?";
            $params[] = $process;
        }
    } else {
        $sql = $sql . " WHERE id > ?";
        $params[] = $id;
        if (!empty($machine_name)) {
            $sql = $sql . " AND (machine_name LIKE ?";
            $params[] = $machine_name . "%";
            if ($process != 'All') {
                $sql = $sql . " AND process = ?";
                $params[] = $process;
            }
            $sql = $sql . ")";
        } else if ($process != 'All') {
            $sql = $sql . " AND (process = ?";
            $params[] = $process;
            $sql = $sql . ")";
        }
    }
    $sql = $sql . " ORDER BY id ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        do{
            $c++;
            echo '<tr id="' . $row['id'] . '">';
            echo '<td>' . $row['number'] . '</td>';
            echo '<td>' . $row['process'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
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
            $sql = "INSERT INTO m_machines (process, machine_name, date_updated) 
                    VALUES (?, ?, ?)";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $process,
                $machine_name,
                $date_updated
            ]);

            echo 'success';
        }
    }
}

$conn = null;
