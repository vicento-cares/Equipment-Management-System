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

function get_current_number_by_name($machine_name, $conn)
{
    $number = 0;
    $sql = "SELECT TOP 1 number FROM m_machine_masterlist WHERE machine_name = ? ORDER BY number DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$machine_name]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $number = intval($row['number']);
    
    return ++$number;
}

// Count
if ($method == 'count_data') {
    $process = $_POST['process'];
    $car_model = $_POST['car_model'];
    $machine_spec = $_POST['machine_spec'];
    $machine_name = $_POST['machine_name'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];

    $sql = "SELECT COUNT(id) AS total FROM m_machine_masterlist";
    $params = [];
    if (!empty($car_model) || !empty($machine_spec) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
        $sql = $sql . " WHERE car_model LIKE ? AND machine_spec LIKE ? AND 
                        machine_name LIKE ? AND machine_no LIKE ? AND equipment_no LIKE ?";

        $params = [
            $car_model . "%",
            $machine_spec . "%",
            $machine_name . "%",
            $machine_no . "%",
            $equipment_no . "%",
        ];
        
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
    $car_model = $_POST['car_model'];
    $machine_spec = $_POST['machine_spec'];
    $machine_name = $_POST['machine_name'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];
    $c = $_POST['c'];

    $sql = "SELECT TOP 25 
                id, number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, [ns_iv_no], machine_status, is_new, date_updated 
            FROM m_machine_masterlist";
    $params = [];

    if (empty($id)) {
        if (!empty($car_model) || !empty($machine_spec) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
            $sql = $sql . " WHERE car_model LIKE ? AND machine_spec LIKE ? AND 
                            machine_name LIKE ? AND machine_no LIKE ? AND equipment_no LIKE ?";
            $params = [
                $car_model . "%",
                $machine_spec . "%",
                $machine_name . "%",
                $machine_no . "%",
                $equipment_no . "%",
            ];
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
        if (!empty($car_model) || !empty($machine_spec) || !empty($machine_name) || !empty($machine_no) || !empty($equipment_no)) {
            $sql = $sql . " AND (car_model LIKE ? AND machine_spec LIKE ? 
                            AND machine_name LIKE ? AND machine_no LIKE ? AND equipment_no LIKE ?";
            $params[] = $car_model . "%";
            $params[] = $machine_spec . "%";
            $params[] = $machine_name . "%";
            $params[] = $machine_no . "%";
            $params[] = $equipment_no . "%";
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
        do {
            $c++;
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="' . $row['id'] . '" data-toggle="modal" data-target="#MachineInfoModal" data-id="' . $row['id'] . '" data-number="' . $row['number'] . '" data-process="' . $row['process'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_spec="' . htmlspecialchars($row['machine_spec']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-asset_tag_no="' . $row['asset_tag_no'] . '" data-trd_no="' . $row['trd_no'] . '" data-ns_iv_no="' . $row['ns_iv_no'] . '" data-machine_status="' . $row['machine_status'] . '" data-is_new="' . $row['is_new'] . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details(this)">';
            echo '<td>' . $row['number'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_spec']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . htmlspecialchars($row['location']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Create / Insert
if ($method == 'save_data') {
    $number = 0;
    $process = $_POST['process'];
    $machine_name = custom_trim($_POST['machine_name']);
    $machine_spec = custom_trim($_POST['machine_spec']);
    $machine_no = custom_trim($_POST['machine_no']);
    $equipment_no = custom_trim($_POST['equipment_no']);
    $asset_tag_no = custom_trim($_POST['asset_tag_no']);
    $trd_no = $_POST['trd_no'];
    $ns_iv_no = $_POST['ns_iv_no'];
    $is_new = 1;
    $car_modal = '';
    $location = 'FAS4';
    $grid = '';

    if (empty($asset_tag_no)) {
        $asset_tag_no = 'N/A';
    }

    $is_valid = false;

    if (!empty($machine_name)) {
        if (!empty($machine_no) || !empty($equipment_no)) {
            $machine_details_arr = get_machine_details($machine_name, $conn);
            if ($machine_details_arr['trd'] == 1 && empty($trd_no)) {
                echo 'TRD No. Empty';
            } else if ($machine_details_arr['ns_iv'] == 1 && empty($ns_iv_no)) {
                echo 'NS-IV No. Empty';
            } else {
                $is_valid = true;
            }
        } else
            echo 'Machine Indentification Empty';
    } else
        echo 'Machine Name Not Set';

    if ($is_valid == true) {
        $machine_info = array(
            'machine_no' => $machine_no,
            'equipment_no' => $equipment_no,
            'trd_no' => $trd_no,
            'ns_iv_no' => $ns_iv_no
        );
        $is_exists_arr = check_existing_machine_info($machine_info, 0, $conn);
        if ($is_exists_arr['machine_no_exists'] == true) {
            echo 'Machine No. Exists';
        } else if ($is_exists_arr['equipment_no_exists'] == true) {
            echo 'Equipment No. Exists';
        } else if ($is_exists_arr['trd_no_exists'] == true) {
            echo 'TRD No. Exists';
        } else if ($is_exists_arr['ns_iv_no_exists'] == true) {
            echo 'NS-IV No. Exists';
        } else {
            $current_number = get_current_number_by_name($machine_name, $conn);

            if ($process == 'Initial') {
                $car_model = 'EQ-Initial';
            } else if ($process == 'Final') {
                $car_model = 'EQ-Final';
            }

            $sql = "INSERT INTO m_machine_masterlist 
                        (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, ns_iv_no, is_new, date_updated) 
                    VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

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
                $is_new,
                $date_updated
            ]);

            save_current_number($machine_name, $current_number, $conn);

            echo 'success';
        }
    }
}

// Update / Edit
if ($method == 'update_data') {
    $id = $_POST['id'];
    $process = $_POST['process'];
    /*$machine_name = custom_trim($_POST['machine_name']);
       $machine_spec = custom_trim($_POST['machine_spec']);*/
    $car_model = custom_trim($_POST['car_model']);
    $location = custom_trim($_POST['location']);
    $grid = custom_trim($_POST['grid']);
    /*$machine_no = custom_trim($_POST['machine_no']);
       $equipment_no = custom_trim($_POST['equipment_no']);*/
    $asset_tag_no = custom_trim($_POST['asset_tag_no']);
    /*$trd_no = $_POST['trd_no'];
       $ns_iv_no = $_POST['ns_iv_no'];*/

    if (empty($asset_tag_no)) {
        $asset_tag_no = 'N/A';
    }

    $is_valid = false;

    if (!empty($car_model)) {
        $car_model_exists = false;
        if ($process == 'Initial') {
            $car_model_exists = check_line_no_initial($car_model, $conn);
        } else if ($process == 'Final') {
            $car_model_exists = check_line_no_final($car_model, $conn);
        }
        if ($car_model_exists == true) {
            if (!empty($location)) {
                $is_valid = true;
            } else
                echo 'Location Not Set';
        } else
            echo 'Car Model Doesn\'t Exists';
    } else
        echo 'Car Model Empty';

    if ($is_valid == true) {
        /*$machine_info = array(
                  'machine_no' => $machine_no,
                  'equipment_no' => $equipment_no,
                  'trd_no' => $trd_no,
                  'ns_iv_no' => $ns_iv_no
              );
              $is_exists_arr = check_existing_machine_info($machine_info, $id, $conn);
              if ($is_exists_arr['machine_no_exists'] == true) {
                  echo 'Machine No. Exists';
              } else if ($is_exists_arr['equipment_no_exists'] == true) {
                  echo 'Equipment No. Exists';
              } else if ($is_exists_arr['trd_no_exists'] == true) {
                  echo 'TRD No. Exists';
              } else if ($is_exists_arr['ns_iv_no_exists'] == true) {
                  echo 'NS-IV No. Exists';
              } else {
                  // Code For Insert New Machine
              }*/

        $sql = "UPDATE m_machine_masterlist SET car_model = ?, location = ?, grid = ?, asset_tag_no = ?, date_updated = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$car_model, $location, $grid, $asset_tag_no, $date_updated, $id]);
        echo 'success';
    }
}

if ($method == 'update_asset_tag_no') {
    $id = $_POST['id'];
    $asset_tag_no = custom_trim($_POST['asset_tag_no']);

    if (empty($asset_tag_no)) {
        $asset_tag_no = 'N/A';
    }

    $sql = "UPDATE m_machine_masterlist SET asset_tag_no = ?, date_updated = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$asset_tag_no, $date_updated, $id]);
    echo 'success';
}

// Delete
if ($method == 'delete_data') {
    $id = $_POST['id'];

    $sql = "DELETE FROM m_machine_masterlist WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    echo 'success';
}

$conn = null;
