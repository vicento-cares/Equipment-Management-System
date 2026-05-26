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

function get_current_number_by_id($machine_no, $equipment_no, $conn)
{
    $number = 0;

    $sql = "SELECT number FROM m_machine_masterlist";
    $params = [];

    if (!empty($machine_no) && !empty($equipment_no)) {
        $sql = $sql . " WHERE machine_no = ? AND equipment_no = ?";
        $params = [
            $machine_no,
            $equipment_no
        ];
    } else if (!empty($machine_no)) {
        $sql = $sql . " WHERE machine_no = ?";
        $params[] = $machine_no;
    } else if (!empty($equipment_no)) {
        $sql = $sql . " WHERE equipment_no = ?";
        $params[] = $equipment_no;
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $number = intval($row['number']);
    }

    return $number;
}

if ($method == 'fetch_pm_plan_years_datalist_search') {
    $sql = "SELECT pm_plan_year FROM t_machine_pm_plan GROUP BY pm_plan_year ORDER BY pm_plan_year ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['pm_plan_year']) . '">';
    }
}

if ($method == 'fetch_all_ww_no_datalist_search') {
    $sql = "SELECT ww_no FROM t_machine_pm_plan GROUP BY ww_no ORDER BY ww_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['ww_no']) . '">';
    }
}

// Count
if ($method == 'count_pm_plan') {
    $pm_plan_year = $_POST['pm_plan_year'];
    $ww_no = $_POST['ww_no'];
    $car_model = $_POST['car_model'];
    $machine_spec = $_POST['machine_spec'];
    $machine_name = $_POST['machine_name'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];

    $sql = "SELECT COUNT(id) AS total FROM t_machine_pm_plan";
    $params = [];

    if (!empty($pm_plan_year) || !empty($ww_no) || !empty($car_model) || !empty($machine_spec) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
        $sql = $sql . " WHERE pm_plan_year LIKE ? AND ww_no LIKE ? AND 
                        car_model LIKE ? AND machine_spec LIKE ? AND 
                        machine_name LIKE ? AND machine_no LIKE ? AND 
                        equipment_no LIKE ?";
        $params = [
            $pm_plan_year . "%",
            $ww_no . "%",
            $car_model . "%",
            $machine_spec . "%",
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
if ($method == 'get_pm_plan') {
    $id = $_POST['id'];
    $pm_plan_year = $_POST['pm_plan_year'];
    $ww_no = $_POST['ww_no'];
    $car_model = $_POST['car_model'];
    $machine_spec = $_POST['machine_spec'];
    $machine_name = $_POST['machine_name'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $c = $_POST['c'];

    $sql = "SELECT TOP 25 
                id, number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, trd_no, [ns_iv_no], pm_plan_year, ww_no, ww_start_date, frequency, machine_status, pm_status, internal_comment 
            FROM t_machine_pm_plan";
    $params = [];

    if (empty($id)) {
        if (!empty($pm_plan_year) || !empty($ww_no) || !empty($car_model) || !empty($machine_spec) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
            $sql = $sql . " WHERE pm_plan_year LIKE '$pm_plan_year%' AND ww_no LIKE '$ww_no%' AND 
                            car_model LIKE '$car_model%' AND machine_spec LIKE '$machine_spec%' AND 
                            machine_name LIKE '$machine_name%' AND machine_no LIKE '$machine_no%' AND 
                            equipment_no LIKE '$equipment_no%'";
            $params = [
                $pm_plan_year . "%",
                $ww_no . "%",
                $car_model . "%",
                $machine_spec . "%",
                $machine_name . "%",
                $machine_no . "%",
                $equipment_no . "%"
            ];
        }
    } else {
        $sql = $sql . " WHERE id > ?";
        $params[] = $id;
        if (!empty($pm_plan_year) || !empty($ww_no) || !empty($car_model) || !empty($machine_spec) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
            $sql = $sql . " AND (pm_plan_year LIKE ? AND ww_no LIKE ? AND 
                            car_model LIKE ? AND machine_spec LIKE ? AND 
                            machine_name LIKE ? AND machine_no LIKE ? AND 
                            equipment_no LIKE ?)";
            $params[] = $pm_plan_year . "%";
            $params[] = $ww_no . "%";
            $params[] = $car_model . "%";
            $params[] = $machine_spec . "%";
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
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="' . $row['id'] . '" data-toggle="modal" data-target="#SinglePmPlanInfoModal" data-id="' . $row['id'] . '" data-pm_plan_year="' . $row['pm_plan_year'] . '" data-ww_no="' . $row['ww_no'] . '" data-process="' . $row['process'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_spec="' . htmlspecialchars($row['machine_spec']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-trd_no="' . $row['trd_no'] . '" data-ns_iv_no="' . $row['ns_iv_no'] . '" data-machine_status="' . $row['machine_status'] . '" data-pm_status="' . $row['pm_status'] . '" data-frequency="' . $row['frequency'] . '" data-ww_start_date="' . $row['ww_start_date'] . '" data-internal_comment="' . $row['internal_comment'] . '" onclick="get_details(this)">';
            echo '<td>' . $row['number'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_spec']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . htmlspecialchars($row['location']) . '</td>';
            echo '<td>' . htmlspecialchars($row['grid']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . $row['trd_no'] . '</td>';
            echo '<td>' . $row['ns_iv_no'] . '</td>';
            echo '<td>' . $row['pm_plan_year'] . '</td>';
            echo '<td>' . $row['ww_no'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['ww_start_date'])) . '</td>';
            echo '<td>' . $row['frequency'] . '</td>';
            echo '<td>' . $row['machine_status'] . '</td>';
            echo '<td>' . $row['pm_status'] . '</td>';
            echo '</tr>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<tr>';
        echo '<td colspan="16" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Create / Insert
if ($method == 'save_single_pm_plan') {
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $trd_no = custom_trim($_POST['trd_no']);
    $ns_iv_no = custom_trim($_POST['ns_iv_no']);
    $machine_name = custom_trim($_POST['machine_name']);
    $machine_spec = custom_trim($_POST['machine_spec']);
    $process = $_POST['process'];
    $location = custom_trim($_POST['location']);
    $grid = custom_trim($_POST['grid']);
    $car_model = custom_trim($_POST['car_model']);
    $pm_plan_year = custom_trim($_POST['pm_plan_year']);
    $ww_no = custom_trim($_POST['ww_no']);
    $frequency = custom_trim($_POST['frequency']);
    $ww_start_date = $_POST['ww_start_date'];

    $is_valid = false;

    if (!empty($machine_no) || !empty($equipment_no)) {
        if (!empty($machine_name)) {
            $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
            if ($machine_info['registered'] == true) {
                if (!empty($pm_plan_year)) {
                    if (!empty($ww_no)) {
                        if (!empty($frequency)) {
                            if (!empty($ww_start_date)) {
                                $is_valid = true;
                            } else
                                echo 'WW Start Date Not Set';
                        } else
                            echo 'Frequency Not Set';
                    } else
                        echo 'WW No. Empty';
                } else
                    echo 'PM Plan Year Empty';
            } else
                echo 'Unregistered Machine';
        } else
            echo 'Forgotten Enter Key';
    } else
        echo 'Machine Indentification Empty';

    if ($is_valid == true) {
        $current_number = get_current_number_by_id($machine_no, $equipment_no, $conn);
        $ww_start_date = date_create($ww_start_date);
        $ww_start_date = date_format($ww_start_date, "Y-m-d");

        $sql = "INSERT INTO t_machine_pm_plan (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, trd_no, ns_iv_no, ww_no, frequency, pm_plan_year, ww_start_date, date_updated) 
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
            $trd_no,
            $ns_iv_no,
            $ww_no,
            $frequency,
            $pm_plan_year,
            $ww_start_date,
            $date_updated
        ]);

        echo 'success';
    }
}

// Update / Edit
if ($method == 'update_single_pm_plan') {
    $id = $_POST['id'];
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $trd_no = custom_trim($_POST['trd_no']);
    $ns_iv_no = custom_trim($_POST['ns_iv_no']);
    $machine_name = custom_trim($_POST['machine_name']);
    $machine_spec = custom_trim($_POST['machine_spec']);
    $process = $_POST['process'];
    $location = custom_trim($_POST['location']);
    $grid = custom_trim($_POST['grid']);
    $car_model = custom_trim($_POST['car_model']);
    $pm_plan_year = custom_trim($_POST['pm_plan_year']);
    $ww_no = custom_trim($_POST['ww_no']);
    $frequency = custom_trim($_POST['frequency']);
    $ww_start_date = $_POST['ww_start_date'];
    $machine_status = custom_trim($_POST['machine_status']);
    $internal_comment = custom_trim($_POST['internal_comment']);

    $is_valid = false;

    if (!empty($machine_no) || !empty($equipment_no)) {
        if (!empty($machine_name)) {
            $machine_info = get_machine_details_by_id($machine_no, $equipment_no, $conn);
            if ($machine_info['registered'] == true) {
                if (!empty($pm_plan_year)) {
                    if (!empty($ww_no)) {
                        if (!empty($frequency)) {
                            if (!empty($ww_start_date)) {
                                $is_valid = true;
                            } else
                                echo 'WW Start Date Not Set';
                        } else
                            echo 'Frequency Not Set';
                    } else
                        echo 'WW No. Empty';
                } else
                    echo 'PM Plan Year Empty';
            } else
                echo 'Unregistered Machine';
        } else
            echo 'Forgotten Enter Key';
    } else
        echo 'Machine Indentification Empty';

    if ($is_valid == true) {
        $current_number = get_current_number_by_id($machine_no, $equipment_no, $conn);
        $ww_start_date = date_create($ww_start_date);
        $ww_start_date = date_format($ww_start_date, "Y-m-d");

        $sql = "UPDATE t_machine_pm_plan 
                SET number = ?, process = ?, machine_name = ?, machine_spec = ?, car_model = ?, 
                location = ?, grid = ?, machine_no = ?, equipment_no = ?, 
                trd_no = ?, [ns_iv_no] = ?, machine_status = ?, internal_comment = ?, 
                pm_plan_year = ?, ww_no = ?, frequency = ?, ww_start_date = ?, date_updated = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            $current_number, $process, $machine_name, $machine_spec, $car_model, 
            $location, $grid, $machine_no, $equipment_no, 
            $trd_no, $ns_iv_no, $machine_status, $internal_comment, 
            $pm_plan_year, $ww_no, $frequency, $ww_start_date, $date_update, $id
        ]);
        echo 'success';
    }
}

// Delete
if ($method == 'delete_single_pm_plan') {
    $id = $_POST['id'];

    $sql = "DELETE FROM t_machine_pm_plan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    echo 'success';
}

$conn = null;
