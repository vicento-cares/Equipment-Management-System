<?php
// Processor
date_default_timezone_set('Asia/Manila');
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();
require('../db/conn.php');
require('../lib/validate.php');
require('../lib/main.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');
$date_only_updated = date('Y-m-d');

function update_machine_status($machine_no, $equipment_no, $machine_status, $conn)
{
    $date_updated = date('Y-m-d H:i:s');
    $process = '';
    $car_model = '';
    $location = 'FAS4';

    $sql = "SELECT process FROM m_machine_masterlist WHERE machine_no = ? AND equipment_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$machine_no, $equipment_no]);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $process = $row['process'];
    }

    if ($process == 'Initial') {
        $car_model = 'EQ-Initial';
    } else if ($process == 'Final') {
        $car_model = 'EQ-Final';
    }

    $sql = "UPDATE m_machine_masterlist SET car_model = ?, location = ?, grid = '', machine_status = ?, date_updated = ? WHERE machine_no = ? AND equipment_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$car_model, $location, $machine_status, $date_updated, $machine_no, $equipment_no]);
}

function update_unused_machine($unused_machine_info, $conn)
{
    $id = $unused_machine_info['id'];
    $status = $unused_machine_info['status'];
    $reserved_for = $unused_machine_info['reserved_for'];
    $remarks = $unused_machine_info['remarks'];
    $pic = $unused_machine_info['pic'];
    $unused_machine_location = $unused_machine_info['unused_machine_location'];
    $target_date = $unused_machine_info['target_date'];
    $date_updated = $unused_machine_info['date_updated'];

    $sql = "UPDATE t_unused_machines 
            SET status = '$status', reserved_for = '$reserved_for', remarks = '$remarks', pic = '$pic', 
            unused_machine_location = '$unused_machine_location', target_date = '$target_date', date_updated = '$date_updated' 
            WHERE id = '$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $status, $reserved_for, $remarks, $pic, 
        $unused_machine_location, $target_date, $date_updated, $id
    ]);
}

function insert_machine_history_unused($machine_info, $pic, $status_date, $conn)
{
    $current_number = $machine_info['number'];
    $process = $machine_info['process'];
    $machine_name = $machine_info['machine_name'];
    $machine_spec = $machine_info['machine_spec'];
    $car_model = $machine_info['car_model'];
    $location = $machine_info['location'];
    $grid = $machine_info['grid'];
    $machine_no = $machine_info['machine_no'];
    $equipment_no = $machine_info['equipment_no'];
    $asset_tag_no = $machine_info['asset_tag_no'];
    $trd_no = $machine_info['trd_no'];
    $ns_iv_no = $machine_info['ns_iv_no'];
    $machine_status = $machine_info['machine_status'];
    $date_updated = date('Y-m-d H:i:s');

    $sql = "INSERT INTO t_machine_history (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, [ns_iv_no], machine_status, pic, status_date, history_date_time) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $current_number,
        $process,
        $machine_name,
        $machine_spec,
        $car_model,
        $location,
        $grid,
        $machine_no,
        $equipment_no,
        $asset_tag_no,
        $trd_no,
        $ns_iv_no,
        $machine_status,
        $pic,
        $status_date,
        $date_updated
    ]);
}

// Count
if ($method == 'count_unused_machines') {
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $machine_name = $_POST['machine_name'];
    $status = $_POST['status'];
    $car_model = $_POST['car_model'];
    $unused_machine_location = $_POST['unused_machine_location'];

    $sql = "SELECT COUNT(id) AS total FROM t_unused_machines";
    $params = [];

    if (!empty($machine_no) || !empty($equipment_no) || !empty($machine_name) || !empty($status) || !empty($car_model) || !empty($unused_machine_location)) {
        $sql = $sql . " WHERE machine_no LIKE ? OR equipment_no LIKE ? OR 
                        machine_name LIKE ? OR status LIKE ? OR 
                        car_model LIKE ? OR unused_machine_location LIKE ?";
        $params = [
            $machine_no . "%",
            $equipment_no . "%",
            $machine_name . "%",
            $status . "%",
            $car_model . "%",
            $unused_machine_location . "%"
        ];
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['total'];
    }
}

// Read / Load
if ($method == 'get_unused_machines') {
    $id = $_POST['id'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $machine_name = $_POST['machine_name'];
    $status = $_POST['status'];
    $car_model = $_POST['car_model'];
    $unused_machine_location = $_POST['unused_machine_location'];
    $c = $_POST['c'];
    $row_class_arr = array('modal-trigger', 'modal-trigger bg-danger', 'modal-trigger bg-warning', 'modal-trigger bg-success');
    $row_class = $row_class_arr[0];

    $sql = "SELECT TOP 25 id, machine_name, car_model, machine_no, equipment_no, asset_tag_no, unused_machine_location, status, reserved_for, pic, remarks, target_date, disposed, borrowed, sold, date_updated FROM t_unused_machines";
    $params = [];

    if (empty($id)) {
        if (!empty($machine_no) || !empty($equipment_no) || !empty($machine_name) || !empty($status) || !empty($car_model) || !empty($unused_machine_location)) {
            $sql = $sql . " WHERE machine_no LIKE ? OR equipment_no LIKE ? OR 
                            machine_name LIKE ? OR status LIKE ? OR 
                            car_model LIKE ? OR unused_machine_location LIKE ?";
            $params = [
                $machine_no . "%",
                $equipment_no . "%",
                $machine_name . "%",
                $status . "%",
                $car_model . "%",
                $unused_machine_location . "%"
            ];
        }
    } else if (empty($machine_no) && empty($equipment_no) && empty($machine_name) && empty($status) && empty($car_model) && empty($unused_machine_location)) {
        $sql = $sql . " WHERE id > ?";
        $params[] = $id;
    } else {
        $sql = $sql . " WHERE id > ? AND (machine_no LIKE ? OR equipment_no LIKE ? OR 
                        machine_name LIKE ? OR status LIKE ? OR 
                        car_model LIKE ? OR unused_machine_location LIKE ?)";
        $params = [
            $id,
            $machine_no . "%",
            $equipment_no . "%",
            $machine_name . "%",
            $status . "%",
            $car_model . "%",
            $unused_machine_location . "%"
        ];
    }
    $sql = $sql . " ORDER BY id ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        do {
            $c++;
            if (intval($row['disposed']) == 1) {
                $row_class = $row_class_arr[1];
            } else if ($row['borrowed'] == 1) {
                $row_class = $row_class_arr[2];
            } else if ($row['sold'] == 1) {
                $row_class = $row_class_arr[3];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="' . $row['id'] . '" data-toggle="modal" data-target="#UnusedMachineInfoModal" data-id="' . $row['id'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-asset_tag_no="' . $row['asset_tag_no'] . '" data-status="' . $row['status'] . '" data-reserved_for="' . $row['reserved_for'] . '" data-remarks="' . $row['remarks'] . '" data-pic="' . $row['pic'] . '" data-unused_machine_location="' . $row['unused_machine_location'] . '" data-target_date="' . $row['target_date'] . '" data-disposed="' . $row['disposed'] . '" data-borrowed="' . $row['borrowed'] . '" data-sold="' . $row['sold'] . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['asset_tag_no'] . '</td>';
            echo '<td>' . $row['status'] . '</td>';
            echo '<td>' . $row['reserved_for'] . '</td>';
            echo '<td>' . $row['remarks'] . '</td>';
            echo '<td>' . $row['pic'] . '</td>';
            echo '<td>' . htmlspecialchars($row['unused_machine_location']) . '</td>';
            if (!empty($row['target_date'])) {
                echo '<td>' . date("Y-m-d", strtotime($row['target_date'])) . '</td>';
            } else {
                echo '<td></td>';
            }
            echo '</tr>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<tr>';
        echo '<td colspan="12" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Create / Insert
if ($method == 'save_unused_machine') {
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $car_model = custom_trim($_POST['car_model']);
    $machine_name = custom_trim($_POST['machine_name']);
    $asset_tag_no = custom_trim($_POST['asset_tag_no']);
    $status = custom_trim($_POST['status']);
    $reserved_for = custom_trim($_POST['reserved_for']);
    $remarks = custom_trim($_POST['remarks']);
    $pic = custom_trim($_POST['pic']);
    $target_date = custom_trim($_POST['target_date']);
    $unused_machine_location = custom_trim($_POST['unused_machine_location']);
    $pic_user = $_COOKIE['setup_name'];

    $is_valid = false;
    if (!empty($machine_no) || !empty($equipment_no)) {
        if (!empty($machine_name)) {
            $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
            if ($machine_info['registered'] == true) {
                if (!empty($status)) {
                    if (!empty($reserved_for)) {
                        if (!empty($pic)) {
                            if (!empty($target_date)) {
                                if (!empty($unused_machine_location)) {
                                    if (($machine_info['machine_status'] == 'Setup' || $machine_info['machine_status'] == 'Transfer' || $machine_info['machine_status'] == 'Relayout') && $machine_info['is_new'] == 0) {
                                        $is_valid = true;
                                    } else
                                        echo 'Not For Unused';
                                } else
                                    echo 'Unused Machine Location Empty';
                            } else
                                echo 'Target Date Not Set';
                        } else
                            echo 'PIC Not Set';
                    } else
                        echo 'Reserved For Empty';
                } else
                    echo 'Status Empty';
            } else
                echo 'Unregistered Machine';
        } else
            echo 'Forgotten Enter Key';
    } else
        echo 'Machine Indentification Empty';

    if ($is_valid == true) {
        $target_date = date_create($target_date);
        $target_date = date_format($target_date, "Y-m-d");
        $status_date = $date_only_updated;

        $sql = "INSERT INTO t_unused_machines (machine_name, car_model, machine_no, equipment_no, asset_tag_no, unused_machine_location, status, reserved_for, remarks, pic, target_date, date_updated) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $machine_name,
            $car_model,
            $machine_no,
            $equipment_no,
            $asset_tag_no,
            $unused_machine_location,
            $status,
            $reserved_for,
            $remarks,
            $pic,
            $target_date,
            $date_updated
        ]);

        // CODES FOR MACHINE HISTORY AND UPDATING MACHINE STATUS HERE
        $machine_status = 'UNUSED';
        update_machine_status($machine_no, $equipment_no, $machine_status, $conn);
        $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
        insert_machine_history_unused($machine_info, $pic_user, $status_date, $conn);

        echo 'success';
    }
}

// Update / Edit
if ($method == 'update_unused_machine') {
    $id = $_POST['id'];
    $status = custom_trim($_POST['status']);
    $reserved_for = custom_trim($_POST['reserved_for']);
    $remarks = custom_trim($_POST['remarks']);
    $pic = custom_trim($_POST['pic']);
    $target_date = custom_trim($_POST['target_date']);
    $unused_machine_location = custom_trim($_POST['unused_machine_location']);
    $pic_user = $_COOKIE['setup_name'];

    $is_valid = false;
    if (!empty($status)) {
        if (!empty($reserved_for)) {
            if (!empty($pic)) {
                if (!empty($target_date)) {
                    if (!empty($unused_machine_location)) {
                        $is_valid = true;
                    } else
                        echo 'Unused Machine Location Empty';
                } else
                    echo 'Target Date Not Set';
            } else
                echo 'PIC Not Set';
        } else
            echo 'Reserved For Empty';
    } else
        echo 'Status Empty';

    if ($is_valid == true) {

        $unused_machine_info = array(
            'id' => $id,
            'status' => $status,
            'reserved_for' => $reserved_for,
            'remarks' => $remarks,
            'pic' => $pic,
            'unused_machine_location' => $unused_machine_location,
            'target_date' => $target_date,
            'date_updated' => $date_updated
        );
        update_unused_machine($unused_machine_info, $conn);

        echo 'success';
    }
}

if ($method == 'dispose_machine') {
    $id = $_POST['id'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $status_date = $_POST['status_date'];
    $machine_status = 'DISPOSED';
    $pic = $_COOKIE['setup_name'];

    if (!empty($status_date)) {
        $status_date = date_create($status_date);
        $status_date = date_format($status_date, "Y-m-d");

        $sql = "UPDATE t_unused_machines SET disposed = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        // CODES FOR MACHINE HISTORY AND UPDATING MACHINE STATUS HERE
        update_machine_status($machine_no, $equipment_no, $machine_status, $conn);
        $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
        insert_machine_history_unused($machine_info, $pic, $status_date, $conn);

        echo 'success';
    } else {
        echo 'Status Date Time Not Set';
    }
}

if ($method == 'borrowed_machine') {
    $id = $_POST['id'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $status_date = $_POST['status_date'];
    $machine_status = 'BORROWED';
    $pic = $_COOKIE['setup_name'];

    if (!empty($status_date)) {
        $status_date = date_create($status_date);
        $status_date = date_format($status_date, "Y-m-d");

        $sql = "UPDATE t_unused_machines SET borrowed = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        // CODES FOR MACHINE HISTORY AND UPDATING MACHINE STATUS HERE
        update_machine_status($machine_no, $equipment_no, $machine_status, $conn);
        $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
        insert_machine_history_unused($machine_info, $pic, $status_date, $conn);

        echo 'success';
    } else {
        echo 'Status Date Time Not Set';
    }
}

if ($method == 'sold_machine') {
    $id = $_POST['id'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $status_date = $_POST['status_date'];
    $machine_status = 'SOLD';
    $pic = $_COOKIE['setup_name'];

    if (!empty($status_date)) {
        $status_date = date_create($status_date);
        $status_date = date_format($status_date, "Y-m-d");

        $sql = "UPDATE t_unused_machines SET sold = 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        // CODES FOR MACHINE HISTORY AND UPDATING MACHINE STATUS HERE
        update_machine_status($machine_no, $equipment_no, $machine_status, $conn);
        $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
        insert_machine_history_unused($machine_info, $pic, $status_date, $conn);

        echo 'success';
    } else {
        echo 'Status Date Time Not Set';
    }
}

if ($method == 'reset_unused_machine') {
    $id = $_POST['id'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $status_date = $date_only_updated;
    $machine_status = 'UNUSED';
    $pic = $_COOKIE['setup_name'];

    $sql = "UPDATE t_unused_machines SET disposed = 0, borrowed = 0, sold = 0 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    // CODES FOR MACHINE HISTORY AND UPDATING MACHINE STATUS HERE
    update_machine_status($machine_no, $equipment_no, $machine_status, $conn);
    $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
    insert_machine_history_unused($machine_info, $pic, $status_date, $conn);

    echo 'success';
}

$conn = null;
