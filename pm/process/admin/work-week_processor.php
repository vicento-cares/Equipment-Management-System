<?php
// Processor
date_default_timezone_set('Asia/Manila');
session_set_cookie_params(0, "/eems");
session_name("eems");
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

// Get Manpower Dropdown
if ($method == 'fetch_manpower_dropdown_search') {
    $sql = "SELECT manpower FROM t_machine_pm_plan GROUP BY manpower ORDER BY manpower ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option value="All">All</option>';
        echo '<option value="N/A">N/A</option>';
        do {
            echo '<option value="' . htmlspecialchars($row['manpower']) . '">' . htmlspecialchars($row['manpower']) . '</option>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<option value="All">All</option>';
        echo '<option value="N/A">N/A</option>';
    }
}

// Count
if ($method == 'count_ww') {
    $pm_plan_year = $_POST['pm_plan_year'];
    $ww_opt = intval($_POST['ww_opt']);
    $ww_no = $_POST['ww_no'];
    $ww_start_date_from = $_POST['ww_start_date_from'];
    if (!empty($ww_start_date_from)) {
        $ww_start_date_from = date_create($ww_start_date_from);
        $ww_start_date_from = date_format($ww_start_date_from, "Y-m-d");
    }
    $ww_start_date_to = $_POST['ww_start_date_to'];
    if (!empty($ww_start_date_to)) {
        $ww_start_date_to = date_create($ww_start_date_to);
        $ww_start_date_to = date_format($ww_start_date_to, "Y-m-d");
    }
    $car_model = $_POST['car_model'];
    $machine_name = $_POST['machine_name'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $manpower = '';
    if (isset($_SESSION['pm_name']) && isset($_SESSION['pm_role'])) {
        $pm_name = $_SESSION['pm_name'];
        $pm_role = $_SESSION['pm_role'];
        if (!empty($_POST['manpower']) && $pm_role == 'Admin') {
            $manpower = $_POST['manpower'];
        } else if ($pm_role == 'PM') {
            $manpower = $pm_name;
        }
    }

    $sql = "SELECT COUNT(id) AS total FROM t_machine_pm_plan";
    $params = [];

    if ($ww_opt == 1 && !empty($ww_no)) {
        $sql = $sql . " WHERE ww_no LIKE ?";
        $params[] = $ww_no . "%";
    } else if ($ww_opt == 2 && !empty($ww_start_date_from) && !empty($ww_start_date_to)) {
        $sql = $sql . " WHERE (ww_start_date >= ? AND ww_start_date <= ?)";
        $params[] = $ww_start_date_from;
        $params[] = $ww_start_date_to;
    } else {
        $sql = $sql . " WHERE ww_no != ''";
    }

    if (!empty($pm_plan_year)) {
        $sql = $sql . " AND pm_plan_year LIKE ?";
        $params[] = $pm_plan_year . "%";
    }
    if (!empty($car_model)) {
        $sql = $sql . " AND car_model LIKE ?";
        $params[] = $car_model . "%";
    }
    if (!empty($machine_name)) {
        $sql = $sql . " AND machine_name LIKE ?";
        $params[] = $machine_name . "%";
    }
    if (!empty($machine_no)) {
        $sql = $sql . " AND machine_no LIKE ?";
        $params[] = $machine_no . "%";
    }
    if (!empty($equipment_no)) {
        $sql = $sql . " AND equipment_no LIKE ?";
        $params[] = $equipment_no . "%";
    }
    if (!empty($manpower)) {
        if ($manpower == 'All') {
            $sql = $sql . " AND manpower LIKE '%'";
        } else if ($manpower == 'N/A') {
            $sql = $sql . " AND manpower IN ('', 'N/A', NULL)";
        } else {
            $sql = $sql . " AND manpower LIKE ?";
            $params[] = $manpower . "%";
        }
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
    $interface = $_POST['interface'];
    $pm_plan_year = $_POST['pm_plan_year'];
    $ww_opt = intval($_POST['ww_opt']);
    $ww_no = $_POST['ww_no'];
    $ww_start_date_from = $_POST['ww_start_date_from'];
    if (!empty($ww_start_date_from)) {
        $ww_start_date_from = date_create($ww_start_date_from);
        $ww_start_date_from = date_format($ww_start_date_from, "Y-m-d");
    }
    $ww_start_date_to = $_POST['ww_start_date_to'];
    if (!empty($ww_start_date_to)) {
        $ww_start_date_to = date_create($ww_start_date_to);
        $ww_start_date_to = date_format($ww_start_date_to, "Y-m-d");
    }
    $car_model = $_POST['car_model'];
    $machine_name = $_POST['machine_name'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $manpower = '';
    if (isset($_SESSION['pm_name']) && isset($_SESSION['pm_role'])) {
        $pm_name = $_SESSION['pm_name'];
        $pm_role = $_SESSION['pm_role'];
        if (!empty($_POST['manpower']) && $pm_role == 'Admin') {
            $manpower = $_POST['manpower'];
        } else if ($pm_role == 'PM') {
            $manpower = $pm_name;
        }
    }

    $row_class_arr = array('modal-trigger', 'modal-trigger bg-lime', 'modal-trigger bg-warning', 'modal-trigger bg-lightblue', 'modal-trigger bg-danger');
    $row_class = $row_class_arr[0];
    $c = $_POST['c'];

    $sql = "SELECT TOP 25 
                id, number, process, machine_name, car_model, machine_no, equipment_no, pm_status, machine_status, pm_plan_year, ww_no, ww_start_date, frequency, manpower, sched_start_date_time, sched_end_date_time 
            FROM t_machine_pm_plan";
    $params = [];

    if (empty($id)) {
        if ($ww_opt == 1 && !empty($ww_no)) {
            $sql = $sql . " WHERE ww_no LIKE ?";
            $params[] = $ww_no . "%";
        } else if ($ww_opt == 2 && !empty($ww_start_date_from) && !empty($ww_start_date_to)) {
            $sql = $sql . " WHERE (ww_start_date >= ? AND ww_start_date <= ?)";
            $params[] = $ww_start_date_from;
            $params[] = $ww_start_date_to;
        } else {
            $sql = $sql . " WHERE ww_no != ''";
        }

        if (!empty($pm_plan_year)) {
            $sql = $sql . " AND pm_plan_year LIKE ?";
            $params[] = $pm_plan_year . "%";
        }
        if (!empty($car_model)) {
            $sql = $sql . " AND car_model LIKE ?";
            $params[] = $car_model . "%";
        }
        if (!empty($machine_name)) {
            $sql = $sql . " AND machine_name LIKE ?";
            $params[] = $machine_name . "%";
        }
        if (!empty($machine_no)) {
            $sql = $sql . " AND machine_no LIKE ?";
            $params[] = $machine_no . "%";
        }
        if (!empty($equipment_no)) {
            $sql = $sql . " AND equipment_no LIKE ?";
            $params[] = $equipment_no . "%";
        }
        if (!empty($manpower)) {
            if ($manpower == 'All') {
                $sql = $sql . " AND manpower LIKE '%'";
            } else if ($manpower == 'N/A') {
                $sql = $sql . " AND manpower IN ('', 'N/A', NULL)";
            } else {
                $sql = $sql . " AND manpower LIKE ?";
                $params[] = $manpower . "%";
            }
        }
    } else {
        $sql = $sql . " WHERE id > '$id'";
        $params[] = $id;

        if ($ww_opt == 1 && !empty($ww_no)) {
            $sql = $sql . " AND ww_no LIKE ?";
            $params[] = $ww_no . "%";
        } else if ($ww_opt == 2 && !empty($ww_start_date_from) && !empty($ww_start_date_to)) {
            $sql = $sql . " AND (ww_start_date >= ? AND ww_start_date <= ?)";
            $params[] = $ww_start_date_from;
            $params[] = $ww_start_date_to;
        } else {
            $sql = $sql . " AND ww_no != ''";
        }

        if (!empty($pm_plan_year)) {
            $sql = $sql . " AND pm_plan_year LIKE ?";
            $params[] = $pm_plan_year . "%";
        }
        if (!empty($car_model)) {
            $sql = $sql . " AND car_model LIKE ?";
            $params[] = $car_model . "%";
        }
        if (!empty($machine_name)) {
            $sql = $sql . " AND machine_name LIKE ?";
            $params[] = $machine_name . "%";
        }
        if (!empty($machine_no)) {
            $sql = $sql . " AND machine_no LIKE ?";
            $params[] = $machine_no . "%";
        }
        if (!empty($equipment_no)) {
            $sql = $sql . " AND equipment_no LIKE ?";
            $params[] = $equipment_no . "%";
        }
        if (!empty($manpower)) {
            if ($manpower == 'All') {
                $sql = $sql . " AND manpower LIKE '%'";
            } else if ($manpower == 'N/A') {
                $sql = $sql . " AND manpower IN ('', 'N/A', NULL)";
            } else {
                $sql = $sql . " AND manpower LIKE ?";
                $params[] = $manpower . "%";
            }
        }
    }

    $sql = $sql . " ORDER BY id ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        do {
            $c++;
            if (empty($row['manpower'])) {
                $row_class = $row_class_arr[4];
            } else if (empty($row['sched_start_date_time']) && empty($row['sched_end_date_time'])) {
                $row_class = $row_class_arr[1];
            } else if ($row['pm_status'] == 'Waiting For Confirmation') {
                $row_class = $row_class_arr[2];
            } else if ($row['pm_status'] == 'Done') {
                $row_class = $row_class_arr[3];
            } else {
                $row_class = $row_class_arr[0];
            }

            echo '<tr class="' . $row_class . '" id="' . $row['id'] . '">';
            if ($interface == 'Admin') {
                echo '<td><p class="mb-0"><label class="mb-0"><input type="checkbox" class="singleCheck" value="' . $row['id'] . '" onclick="get_checked_pm()" /><span></span></label></p></td>';
                echo '<td style="cursor:pointer;" data-toggle="modal" data-target="#WWContentModal" data-id="' . $row['id'] . '" data-pm_plan_year="' . $row['pm_plan_year'] . '" data-ww_no="' . $row['ww_no'] . '" data-process="' . $row['process'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-pm_status="' . $row['pm_status'] . '" data-machine_status="' . $row['machine_status'] . '" data-frequency="' . $row['frequency'] . '" data-manpower="' . htmlspecialchars($row['manpower']) . '" data-ww_start_date="' . $row['ww_start_date'] . '" data-sched_start_date_time="' . $row['sched_start_date_time'] . '" data-sched_end_date_time="' . $row['sched_end_date_time'] . '"onclick="get_details(this)">' . $row['number'] . '</td>';
            } else if ($interface == 'Public') {
                echo '<td>' . $row['number'] . '</td>';
            }
            /*echo '<td>'.$row['number'].'</td>';*/
            echo '<td>' . $row['pm_plan_year'] . '</td>';
            echo '<td>' . $row['ww_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . $row['frequency'] . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . htmlspecialchars($row['manpower']) . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['ww_start_date'])) . '</td>';
            if (empty($row['sched_start_date_time'])) {
                echo '<td></td>';
            } else {
                echo '<td>' . date("Y-m-d h:iA", strtotime($row['sched_start_date_time'])) . '</td>';
            }
            if (empty($row['sched_end_date_time'])) {
                echo '<td></td>';
            } else {
                echo '<td>' . date("Y-m-d h:iA", strtotime($row['sched_end_date_time'])) . '</td>';
            }
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<tr>';
        echo '<td colspan="12" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Update / Edit
if ($method == 'update_ww_manpower') {
    $arr = array();
    $arr = $_POST['arr'];
    $manpower = custom_trim($_POST['manpower']);

    $is_valid = false;

    if (!empty($manpower)) {
        $is_valid = true;
    } else
        echo 'Manpower Not Set';

    if ($is_valid == true) {

        $count = count($arr);
        foreach ($arr as $id) {
            $sql = "UPDATE t_machine_pm_plan 
                    SET manpower = ? 
                    WHERE id = ? AND 
                        ((sched_start_date_time = '' OR sched_start_date_timeIS NULL) AND 
                        (sched_end_date_time = '' OR sched_end_date_time IS NULL))";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$manpower, $id]);
            $count--;
        }

        if ($count == 0) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
}

// Update / Edit
if ($method == 'update_ww_content') {
    $id = $_POST['id'];
    $manpower = custom_trim($_POST['manpower']);
    $sched_start_date_time = $_POST['sched_start_date_time'];
    $sched_end_date_time = $_POST['sched_end_date_time'];

    $is_valid = false;

    if (!empty($sched_start_date_time)) {
        if (!empty($sched_end_date_time)) {
            if (!empty($manpower)) {
                $is_valid = true;
            } else
                echo 'Manpower Empty';
        } else
            echo 'End Date Time Not Set';
    } else
        echo 'Start Date Time Not Set';

    if ($is_valid == true) {
        $sched_start_date_time = date_create($sched_start_date_time);
        $sched_start_date_time = date_format($sched_start_date_time, "Y-m-d H:i:s");
        $sched_end_date_time = date_create($sched_end_date_time);
        $sched_end_date_time = date_format($sched_end_date_time, "Y-m-d H:i:s");

        $sql = "UPDATE t_machine_pm_plan 
                SET manpower = ?, sched_start_date_time = ?, sched_end_date_time = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$manpower, $sched_start_date_time, $sched_end_date_time, $id]);
        echo 'success';
    }
}

if ($method == 'set_as_done_ww') {
    $id = $_POST['id'];
    $allow_set_as_done = false;

    $sql = "SELECT machine_name, machine_no, equipment_no, ww_start_date, frequency FROM t_machine_pm_plan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $machine_name = $row['machine_name'];
        $machine_no = $row['machine_no'];
        $equipment_no = $row['equipment_no'];
        $ww_start_date = $row['ww_start_date'];
        $frequency = $row['frequency'];
    }

    $sql = "SELECT rsir_date FROM t_pm_rsir_history WHERE machine_name = ? AND machine_no = ? AND equipment_no = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$machine_name, $machine_no, $equipment_no]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        do {
            $rsir_date = $row['rsir_date'];
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));

        switch ($frequency) {
            case 'Y':
                $ww_start_date_next_year = date('Y-m-d', (strtotime('+1 year', strtotime($ww_start_date))));
                if ($rsir_date >= $ww_start_date && $rsir_date < $ww_start_date_next_year) {
                    $allow_set_as_done = true;
                }
                break;
            case '6':
                $ww_start_date_next_6th_month = date('Y-m-d', (strtotime('+6 months', strtotime($ww_start_date))));
                if ($rsir_date >= $ww_start_date && $rsir_date < $ww_start_date_next_6th_month) {
                    $allow_set_as_done = true;
                }
                break;
            case '3':
                $ww_start_date_next_3rd_month = date('Y-m-d', (strtotime('+3 months', strtotime($ww_start_date))));
                if ($rsir_date >= $ww_start_date && $rsir_date < $ww_start_date_next_3rd_month) {
                    $allow_set_as_done = true;
                }
                break;
            case '2':
                $ww_start_date_next_2nd_month = date('Y-m-d', (strtotime('+2 months', strtotime($ww_start_date))));
                if ($rsir_date >= $ww_start_date && $rsir_date < $ww_start_date_next_2nd_month) {
                    $allow_set_as_done = true;
                }
                break;
            case 'M':
                $ww_start_date_next_month = date('Y-m-d', (strtotime('+1 month', strtotime($ww_start_date))));
                if ($rsir_date >= $ww_start_date && $rsir_date < $ww_start_date_next_month) {
                    $allow_set_as_done = true;
                }
                break;
            case 'W':
                $ww_start_date_next_week = date('Y-m-d', (strtotime('+1 week', strtotime($ww_start_date))));
                if ($rsir_date >= $ww_start_date && $rsir_date < $ww_start_date_next_week) {
                    $allow_set_as_done = true;
                }
                break;
            default:
        }

        if ($allow_set_as_done == true) {
            $pm_status = 'Waiting For Confirmation';
            $sql = "UPDATE t_machine_pm_plan SET pm_status = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$pm_status, $id]);
            echo 'success';
        } else {
            echo 'Updated RSIR Not Found';
        }

    } else {
        echo 'RSIR Not Found';
    }
}

if ($method == 'confirm_as_done_ww') {
    $id = $_POST['id'];
    $pm_status = 'Done';
    $sql = "UPDATE t_machine_pm_plan SET pm_status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$pm_status, $id]);
    echo 'success';
}

$conn = null;
