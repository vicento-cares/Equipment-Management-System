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

// Count
if ($method == 'count_ww') {
    $pm_plan_year = $_POST['pm_plan_year'];
    $ww_no = $_POST['ww_no'];
    $machine_name = $_POST['machine_name'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];

    $sql = "SELECT COUNT(id) AS total FROM t_machine_pm_plan";
    $params = [];

    if (!empty($pm_plan_year) || !empty($ww_no) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
        $sql = $sql . " WHERE pm_plan_year LIKE ? AND ww_no LIKE ? AND 
                        machine_name LIKE ? AND machine_no LIKE ? AND equipment_no LIKE ?";
        $params = [
            $pm_plan_year . "%",
            $ww_no . "%",
            $machine_name . "%",
            $machine_no . "%",
            $equipment_no . "%"
        ];
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['total'];
    }
}

// Read / Load
if ($method == 'get_ww') {
    $id = $_POST['id'];
    $pm_plan_year = $_POST['pm_plan_year'];
    $ww_no = $_POST['ww_no'];
    $machine_name = $_POST['machine_name'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $row_class_arr = array('modal-trigger', 'modal-trigger bg-lime');
    $row_class = $row_class_arr[0];
    $c = $_POST['c'];

    $sql = "SELECT TOP 25 
                id, number, process, machine_name, machine_no, equipment_no, pm_plan_year, ww_no, ww_start_date, ww_next_date, manpower, shift_engineer 
            FROM t_machine_pm_plan";

    $params = [];

    if (empty($id)) {
        if (!empty($pm_plan_year) || !empty($ww_no) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
            $sql = $sql . " WHERE pm_plan_year LIKE ? AND ww_no LIKE ? AND 
                            machine_name LIKE ? AND machine_no LIKE ? AND equipment_no LIKE ?";
            $params = [
                $pm_plan_year . "%",
                $ww_no . "%",
                $machine_name . "%",
                $machine_no . "%",
                $equipment_no . "%"
            ];
        }
    } else {
        $sql = $sql . " WHERE id > ?";
        $params[] = $id;
        if (!empty($pm_plan_year) || !empty($ww_no) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
            $sql = $sql . " AND (pm_plan_year LIKE ? AND ww_no LIKE ? AND 
                            machine_name LIKE ? AND machine_no LIKE ? AND equipment_no LIKE ?)";
            $params[] = $pm_plan_year . "%";
            $params[] = $ww_no . "%";
            $params[] = $machine_name . "%";
            $params[] = $machine_no . "%";
            $params[] = $equipment_no . "%";
        }
    }
    $sql = $sql . " ORDER BY id ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        do {
            $c++;
            if (empty($row['manpower']) || empty($row['ww_next_date']) || empty($row['shift_engineer'])) {
                $row_class = $row_class_arr[1];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr class="' . $row_class . '" id="' . $row['id'] . '">';
            echo '<td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck" value="' . $row['id'] . '" onclick="get_checked_pm()" /><span></span></label></p></td>';
            echo '<td style="cursor:pointer;" data-toggle="modal" data-target="#PmStickerContentModal" data-id="' . $row['id'] . '" data-pm_plan_year="' . $row['pm_plan_year'] . '" data-ww_no="' . $row['ww_no'] . '" data-process="' . $row['process'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-manpower="' . htmlspecialchars($row['manpower']) . '" data-ww_start_date="' . $row['ww_start_date'] . '" data-ww_next_date="' . $row['ww_next_date'] . '" data-shift_engineer="' . htmlspecialchars($row['shift_engineer']) . '" onclick="get_details(this)">' . $row['number'] . '</td>';
            echo '<td>' . $row['pm_plan_year'] . '</td>';
            echo '<td>' . $row['ww_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['manpower']) . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['ww_start_date'])) . '</td>';
            if (empty($row['ww_next_date'])) {
                echo '<td></td>';
            } else {
                echo '<td>' . date("Y-m-d", strtotime($row['ww_next_date'])) . '</td>';
            }
            echo '<td>' . htmlspecialchars($row['shift_engineer']) . '</td></tr>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<tr>';
        echo '<td colspan="11" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Update / Edit
if ($method == 'update_pm_sticker_content') {
    $arr = array();
    $arr = $_POST['arr'];
    $shift_engineer = custom_trim($_POST['shift_engineer']);
    $ww_next_date = $_POST['ww_next_date'];

    $is_valid = false;

    if (!empty($ww_next_date)) {
        if (!empty($shift_engineer)) {
            $is_valid = true;
        } else
            echo 'Shift Engineer Empty';
    } else
        echo 'Next Date Not Set';

    if ($is_valid == true) {
        $ww_next_date = date_create($ww_next_date);
        $ww_next_date = date_format($ww_next_date, "Y-m-d");

        $count = count($arr);
        foreach ($arr as $id) {
            $sql = "UPDATE t_machine_pm_plan SET shift_engineer = ?, ww_next_date = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$shift_engineer, $ww_next_date, $id]);
            $count--;
        }

        if ($count == 0) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}

$conn = null;
