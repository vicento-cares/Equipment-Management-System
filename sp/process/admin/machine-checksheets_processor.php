<?php
// Processor
date_default_timezone_set('Asia/Manila');
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();
require('../db/conn.php');
require('../lib/validate.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';

function update_notif_count_machine_checksheets($interface, $mstprc_process_status, $conn)
{
    if ($mstprc_process_status != 'Added' && $mstprc_process_status != 'Saved') {
        $sql = "UPDATE notif_setup_approvers";
        if ($mstprc_process_status == 'Confirmed') {
            $sql = $sql . " SET pending_mstprc = pending_mstprc + 1";
        } else if ($mstprc_process_status == 'Approved 1') {
            $sql = $sql . " SET pending_mstprc = pending_mstprc + 1";
        } else if ($mstprc_process_status == 'Approved 2') {
            $sql = $sql . " SET approved_mstprc = approved_mstprc + 1";
        } else if ($mstprc_process_status == 'Disapproved') {
            $sql = $sql . " SET disapproved_mstprc = disapproved_mstprc + 1";
        }
        $sql = $sql . " WHERE interface = '$interface'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}

function machine_checksheets_mark_as_read($mstprc_no, $mstprc_process_status, $interface, $conn)
{
    $sql = "";
    if ($mstprc_process_status == 'Approved 2' || $mstprc_process_status == 'Disapproved') {
        $sql = $sql . "UPDATE setup_mstprc_history";
    } else {
        $sql = $sql . "UPDATE setup_mstprc";
    }
    if ($interface == 'ADMIN-SETUP') {
        $sql = $sql . " SET is_read_setup = 1";
    } else if ($interface == 'APPROVER-1-SAFETY') {
        $sql = $sql . " SET is_read_safety = 1";
    } else if ($interface == 'APPROVER-2-EQ-MGR') {
        $sql = $sql . " SET is_read_eq_mgr = 1";
    } else if ($interface == 'APPROVER-2-EQ-SP') {
        $sql = $sql . " SET is_read_eq_sp = 1";
    } else if ($interface == 'APPROVER-2-PROD-ENGR-MGR') {
        $sql = $sql . " SET is_read_prod_engr_mgr = 1";
    } else if ($interface == 'APPROVER-2-PROD-SV') {
        $sql = $sql . " SET is_read_prod_sv = 1";
    } else if ($interface == 'APPROVER-2-PROD-MGR') {
        $sql = $sql . " SET is_read_prod_mgr = 1";
    } else if ($interface == 'APPROVER-2-QA-SV') {
        $sql = $sql . " SET is_read_qa_sv = 1";
    } else if ($interface == 'APPROVER-2-QA-MGR') {
        $sql = $sql . " SET is_read_qa_mgr = 1";
    }
    $sql = $sql . " WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($mstprc_process_status != 'Added' && $mstprc_process_status != 'Saved') {
        $sql = "UPDATE notif_setup_approvers";
        if ($mstprc_process_status == 'Confirmed') {
            $sql = $sql . " SET pending_mstprc = CASE WHEN pending_mstprc > 0 THEN pending_mstprc - 1 END";
        } else if ($mstprc_process_status == 'Approved 1') {
            $sql = $sql . " SET pending_mstprc = CASE WHEN pending_mstprc > 0 THEN pending_mstprc - 1 END";
        } else if ($mstprc_process_status == 'Approved 2') {
            $sql = $sql . " SET approved_mstprc = CASE WHEN approved_mstprc > 0 THEN approved_mstprc - 1 END";
        } else if ($mstprc_process_status == 'Disapproved') {
            $sql = $sql . " SET disapproved_mstprc = CASE WHEN disapproved_mstprc > 0 THEN disapproved_mstprc - 1 END";
        }
        $sql = $sql . " WHERE interface = '$interface'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}

// Count
if ($method == 'count_a2_machine_checksheets') {
    $sql = "SELECT count(id) AS total FROM setup_mstprc WHERE mstprc_process_status = 'Approved 1'";

    if (isset($_POST['car_model']) && !empty($_POST['car_model'])) {
        $sql = $sql . " AND car_model LIKE '" . $_POST['car_model'] . "%'";
    }
    if (isset($_POST['location']) && !empty($_POST['location'])) {
        $sql = $sql . " AND location LIKE '" . $_POST['location'] . "%'";
    }
    if (isset($_POST['machine_name']) && !empty($_POST['machine_name'])) {
        $sql = $sql . " AND machine_name LIKE '" . $_POST['machine_name'] . "%'";
    }
    if (isset($_POST['grid']) && !empty($_POST['grid'])) {
        $sql = $sql . " AND grid LIKE '" . $_POST['grid'] . "%'";
    }
    if (isset($_POST['mstprc_no']) && !empty($_POST['mstprc_no'])) {
        $sql = $sql . " AND mstprc_no LIKE '" . $_POST['mstprc_no'] . "%'";
    }
    if (isset($_POST['machine_no']) && !empty($_POST['machine_no'])) {
        $sql = $sql . " AND machine_no LIKE '" . $_POST['machine_no'] . "%'";
    }
    if (isset($_POST['equipment_no']) && !empty($_POST['equipment_no'])) {
        $sql = $sql . " AND equipment_no LIKE '" . $_POST['equipment_no'] . "%'";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    } else {
        echo 0;
    }
}

if ($method == 'a2_machine_checksheets_mark_as_read_all_approvers') {
    machine_checksheets_mark_as_read($_POST['mstprc_no'], $_POST['mstprc_process_status'], 'APPROVER-2-EQ-SP', $conn);
}

// Read / Load
if ($method == 'get_a2_machine_checksheets_all_approvers') {
    $car_model = $_POST['car_model'];
    $location = $_POST['location'];
    $machine_name = $_POST['machine_name'];
    $grid = $_POST['grid'];
    $mstprc_no = $_POST['mstprc_no'];
    $machine_no = $_POST['machine_no'];
    $equipment_no = $_POST['equipment_no'];

    $row_class_arr = array('modal-trigger', 'modal-trigger bg-warning', 'modal-trigger bg-success');
    $row_class = $row_class_arr[0];
    $c = 0;

    $sql = "SELECT mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, is_read_eq_sp, file_name, file_url FROM setup_mstprc WHERE mstprc_process_status = 'Approved 1'";

    if (!empty($car_model)) {
        $sql = $sql . " AND car_model LIKE '$car_model%'";
    }
    if (!empty($location)) {
        $sql = $sql . " AND location LIKE '$location%'";
    }
    if (!empty($machine_name)) {
        $sql = $sql . " AND machine_name LIKE '$machine_name%'";
    }
    if (!empty($grid)) {
        $sql = $sql . " AND grid LIKE '$grid%'";
    }
    if (!empty($mstprc_no)) {
        $sql = $sql . " AND mstprc_no LIKE '$mstprc_no%'";
    }
    if (!empty($machine_no)) {
        $sql = $sql . " AND machine_no LIKE '$machine_no%'";
    }
    if (!empty($equipment_no)) {
        $sql = $sql . " AND equipment_no LIKE '$equipment_no%'";
    }

    $sql = $sql . " ORDER BY id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if (!empty($row['mstprc_eq_sp_personnel'])) {
                $row_class = $row_class_arr[2];
            } else if ($row['is_read_eq_sp'] == 0) {
                $row_class = $row_class_arr[1];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="A2MC_' . $row['mstprc_no'] . '" data-toggle="modal" data-target="#A2MachineChecksheetInfoModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" onclick="get_details_a2_machine_checksheets(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

if ($method == 'approve_a2_mstprc') {
    $mstprc_no = $_POST['mstprc_no'];
    $mstprc_eq_sp_personnel = $_SESSION['sp_name'];

    $sql = "UPDATE setup_mstprc SET mstprc_eq_sp_personnel = '$mstprc_eq_sp_personnel' WHERE mstprc_no = '$mstprc_no'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $machine_name = '';
    $machine_no = '';
    $equipment_no = '';
    $car_model = '';
    $location = '';
    $grid = '';
    $is_new = 0;
    $machine_status = '';
    $new_car_model = '';
    $new_location = '';
    $new_grid = '';
    $pullout_location = '';
    $transfer_reason = '';
    $pullout_reason = '';
    $mstprc_username = '';
    $mstprc_approver_role = '';
    $pic = '';
    $status_date = '';
    $mstprc_eq_g_leader = '';
    $mstprc_safety_officer = '';
    $mstprc_eq_manager = '';
    $mstprc_eq_sp_personnel = '';
    $mstprc_prod_engr_manager = '';
    $mstprc_prod_supervisor = '';
    $mstprc_prod_manager = '';
    $mstprc_qa_supervisor = '';
    $mstprc_qa_manager = '';
    $fat_no = '';
    $sou_no = '';
    $rsir_no = '';
    $file_name = '';
    $file_type = '';
    $file_url = '';

    $fully_approved = false;

    $sql = "SELECT mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, fat_no, sou_no, rsir_no, file_name, file_type, file_url FROM setup_mstprc WHERE mstprc_no = '$mstprc_no' LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            if (!empty($row['mstprc_eq_manager']) && !empty($row['mstprc_eq_sp_personnel']) && !empty($row['mstprc_prod_engr_manager']) && ((!empty($row['mstprc_prod_supervisor']) && !empty($row['mstprc_prod_manager'])) || (!empty($row['mstprc_qa_supervisor']) && !empty($row['mstprc_qa_manager'])))) {

                $machine_name = $row['machine_name'];
                $machine_no = $row['machine_no'];
                $equipment_no = $row['equipment_no'];
                $status_date = $row['mstprc_date'];
                $car_model = $row['car_model'];
                $location = $row['location'];
                $grid = $row['grid'];
                $is_new = $row['is_new'];
                $machine_status = $row['mstprc_type'];
                $new_car_model = $row['to_car_model'];
                $new_location = $row['to_location'];
                $new_grid = $row['to_grid'];
                $pullout_location = $row['pullout_location'];
                $transfer_reason = $row['transfer_reason'];
                $pullout_reason = $row['pullout_reason'];
                $mstprc_username = $row['mstprc_username'];
                $mstprc_approver_role = $row['mstprc_approver_role'];
                $pic = $row['mstprc_eq_member'];
                $mstprc_eq_g_leader = $row['mstprc_eq_g_leader'];
                $mstprc_safety_officer = $row['mstprc_safety_officer'];
                $mstprc_eq_manager = $row['mstprc_eq_manager'];
                $mstprc_eq_sp_personnel = $row['mstprc_eq_sp_personnel'];
                $mstprc_prod_engr_manager = $row['mstprc_prod_engr_manager'];
                $mstprc_prod_supervisor = $row['mstprc_prod_supervisor'];
                $mstprc_prod_manager = $row['mstprc_prod_manager'];
                $mstprc_qa_supervisor = $row['mstprc_qa_supervisor'];
                $mstprc_qa_manager = $row['mstprc_qa_manager'];
                $fat_no = $row['fat_no'];
                $sou_no = $row['sou_no'];
                $rsir_no = $row['rsir_no'];
                $file_name = $row['file_name'];
                $file_type = $row['file_type'];
                $file_url = $row['file_url'];

                $fully_approved = true;
            }
        }
    }

    if ($fully_approved == true) {
        $sql = "INSERT INTO setup_mstprc_history(mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, fat_no, sou_no, rsir_no, file_name, file_type, file_url) VALUES ('$mstprc_no','$machine_status','$machine_name','$machine_no','$equipment_no','$status_date','$car_model','$location','$grid','$is_new','$new_car_model','$new_location','$new_grid','$pullout_location','$transfer_reason','$pullout_reason','$mstprc_username','$mstprc_approver_role','$pic','$mstprc_eq_g_leader','$mstprc_safety_officer','$mstprc_eq_manager','$mstprc_eq_sp_personnel','$mstprc_prod_engr_manager','$mstprc_prod_supervisor','$mstprc_prod_manager','$mstprc_qa_supervisor','$mstprc_qa_manager','Approved 2','$fat_no','$sou_no','$rsir_no','$file_name','$file_type','$file_url')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $sql = "DELETE FROM setup_mstprc WHERE mstprc_no = '$mstprc_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $current_number = 0;
        $process = '';
        $machine_spec = '';
        $asset_tag_no = '';
        $trd_no = '';
        $ns_iv_no = '';

        $sql = "SELECT number, process, machine_spec, asset_tag_no, trd_no, `ns-iv_no` FROM machine_masterlist WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $current_number = intval($row['number']);
                $process = $row['process'];
                $machine_spec = $row['machine_spec'];
                $asset_tag_no = $row['asset_tag_no'];
                $trd_no = $row['trd_no'];
                $ns_iv_no = $row['ns-iv_no'];
            }
        }

        if ($machine_status == 'Setup') {
            $sql = "DELETE FROM unused_machines WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE machine_masterlist SET car_model = '$car_model', location = '$location', grid = '$grid', machine_status = '$machine_status', is_new = 0 WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } else if ($machine_status == 'Pullout') {
            $machine_status = 'UNUSED';

            $sql = "INSERT INTO unused_machines (machine_name, car_model, machine_no, equipment_no, asset_tag_no, unused_machine_location, status, reserved_for, pic, remarks, target_date) VALUES ('$machine_name', '$car_model', '$machine_no', '$equipment_no', '$asset_tag_no', '', '', '', '', '', '')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "UPDATE machine_masterlist SET machine_status = '$machine_status' WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $sql = "INSERT INTO machine_history (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, `ns-iv_no`, machine_status, pic, status_date, history_date_time) VALUES ('$current_number', '$process', '$machine_name', '$machine_spec', '$car_model', '$location', '$grid', '$machine_no', '$equipment_no', '$asset_tag_no', '$trd_no', '$ns_iv_no', 'Pullout', '$pic', '$status_date', '$date_updated')";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            if ($process == 'Initial') {
                $car_model = 'EQ-Initial';
            } else if ($process == 'Final') {
                $car_model = 'EQ-Final';
            }
            $location = 'FAS4';
            $grid = '';
        } else if ($machine_status == 'Transfer') {
            $sql = "UPDATE machine_masterlist SET car_model = '$new_car_model', location = '$new_location', grid = '$new_grid', machine_status = '$machine_status' WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $car_model = $new_car_model;
            $location = $new_location;
            $grid = $new_grid;
        } else {
            $sql = "UPDATE machine_masterlist SET machine_status = '$machine_status' WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        $sql = "INSERT INTO machine_history (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, `ns-iv_no`, machine_status, pic, status_date, history_date_time) VALUES ('$current_number', '$process', '$machine_name', '$machine_spec', '$car_model', '$location', '$grid', '$machine_no', '$equipment_no', '$asset_tag_no', '$trd_no', '$ns_iv_no', '$machine_status', '$pic', '$status_date', '$date_updated')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        update_notif_count_machine_checksheets('ADMIN-SETUP', 'Approved 2', $conn);
    }

    echo 'success';
}

if ($method == 'disapprove_a2_mstprc') {
    $mstprc_no = $_POST['mstprc_no'];
    $disapproved_comment = $_POST['disapproved_comment'];
    $sp_name = $_SESSION['sp_name'];
    $sp_role = $_SESSION['sp_role'];

    if ($sp_role == 'Admin') {
        $sp_role = 'Admin-SP';
    }

    if (!empty($disapproved_comment)) {
        $sql = "SELECT mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, fat_no, sou_no, rsir_no, file_name, file_type, file_url FROM setup_mstprc WHERE mstprc_no = '$mstprc_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
                $mstprc_no = $row['mstprc_no'];
                $mstprc_type = $row['mstprc_type'];
                $machine_name = $row['machine_name'];
                $machine_no = $row['machine_no'];
                $equipment_no = $row['equipment_no'];
                $mstprc_date = $row['mstprc_date'];
                $car_model = $row['car_model'];
                $location = $row['location'];
                $grid = $row['grid'];
                $is_new = $row['is_new'];
                $to_car_model = $row['to_car_model'];
                $to_location = $row['to_location'];
                $to_grid = $row['to_grid'];
                $pullout_location = $row['pullout_location'];
                $transfer_reason = $row['transfer_reason'];
                $pullout_reason = $row['pullout_reason'];
                $mstprc_username = $row['mstprc_username'];
                $mstprc_approver_role = $row['mstprc_approver_role'];
                $mstprc_eq_member = $row['mstprc_eq_member'];
                $mstprc_eq_g_leader = $row['mstprc_eq_g_leader'];
                $mstprc_eq_manager = $row['mstprc_eq_manager'];
                $mstprc_eq_sp_personnel = $row['mstprc_eq_sp_personnel'];
                $mstprc_prod_engr_manager = $row['mstprc_prod_engr_manager'];
                $mstprc_prod_supervisor = $row['mstprc_prod_supervisor'];
                $mstprc_prod_manager = $row['mstprc_prod_manager'];
                $mstprc_qa_supervisor = $row['mstprc_qa_supervisor'];
                $mstprc_qa_manager = $row['mstprc_qa_manager'];
                $fat_no = $row['fat_no'];
                $sou_no = $row['sou_no'];
                $rsir_no = $row['rsir_no'];
                $file_name = $row['file_name'];
                $file_type = $row['file_type'];
                $file_url = $row['file_url'];
            }
        }

        $sql = "INSERT INTO setup_mstprc_history(mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, is_new, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_username, mstprc_approver_role, mstprc_eq_member, mstprc_eq_g_leader, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, disapproved_by, disapproved_by_role, disapproved_comment, fat_no, sou_no, rsir_no, file_name, file_type, file_url) VALUES ('$mstprc_no','$mstprc_type','$machine_name','$machine_no','$equipment_no','$mstprc_date','$car_model','$location','$grid','$is_new','$to_car_model','$to_location','$to_grid','$pullout_location','$transfer_reason','$pullout_reason','$mstprc_username','$mstprc_approver_role','$mstprc_eq_member','$mstprc_eq_g_leader','$mstprc_eq_manager','$mstprc_eq_sp_personnel','$mstprc_prod_engr_manager','$mstprc_prod_supervisor','$mstprc_prod_manager','$mstprc_qa_supervisor','$mstprc_qa_manager','Disapproved','$sp_name','$sp_role','$disapproved_comment','$fat_no','$sou_no','$rsir_no','$file_name','$file_type','$file_url')";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $sql = "DELETE FROM setup_mstprc WHERE mstprc_no = '$mstprc_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        update_notif_count_machine_checksheets('ADMIN-SETUP', 'Disapproved', $conn);

        echo 'success';
    } else
        echo 'Comment Empty';
}

// Count
if ($method == 'count_a2_machine_checksheets_history') {
    $mstprc_date_from = $_POST['mstprc_date_from'];
    if (!empty($mstprc_date_from)) {
        $mstprc_date_from = date_create($mstprc_date_from);
        $mstprc_date_from = date_format($mstprc_date_from, "Y-m-d");
    }
    $mstprc_date_to = $_POST['mstprc_date_to'];
    if (!empty($mstprc_date_to)) {
        $mstprc_date_to = date_create($mstprc_date_to);
        $mstprc_date_to = date_format($mstprc_date_to, "Y-m-d");
    }
    $machine_name = addslashes($_POST['machine_name']);
    $car_model = addslashes($_POST['car_model']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $mstprc_no = $_POST['mstprc_no'];

    $history_option = $_POST['history_option'];

    $sql = "SELECT count(id) AS total";

    if ($history_option == 1) {
        $sql = $sql . " FROM setup_mstprc";

        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to') AND mstprc_process_status = 'Approved 1'";
        } else {
            $sql = $sql . " WHERE mstprc_process_status = 'Approved 1'";
        }
    } else if ($history_option == 2) {
        $sql = $sql . " FROM setup_mstprc_history";

        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to') AND (mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved')";
        } else {
            $sql = $sql . " WHERE (mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved')";
        }
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    } else {
        echo 0;
    }
}

// Read / Load
if ($method == 'get_a2_machine_checksheets_history') {
    $id = $_POST['id'];
    $mstprc_date_from = $_POST['mstprc_date_from'];
    if (!empty($mstprc_date_from)) {
        $mstprc_date_from = date_create($mstprc_date_from);
        $mstprc_date_from = date_format($mstprc_date_from, "Y-m-d");
    }
    $mstprc_date_to = $_POST['mstprc_date_to'];
    if (!empty($mstprc_date_to)) {
        $mstprc_date_to = date_create($mstprc_date_to);
        $mstprc_date_to = date_format($mstprc_date_to, "Y-m-d");
    }
    $machine_name = addslashes($_POST['machine_name']);
    $car_model = addslashes($_POST['car_model']);
    $machine_no = addslashes($_POST['machine_no']);
    $equipment_no = addslashes($_POST['equipment_no']);
    $mstprc_no = $_POST['mstprc_no'];
    $c = $_POST['c'];

    $history_option = $_POST['history_option'];

    $row_class_arr = array('modal-trigger', 'modal-trigger bg-warning', 'modal-trigger bg-success', 'modal-trigger bg-danger');
    $row_class = $row_class_arr[0];

    $sql = "SELECT id, mstprc_no, mstprc_type, machine_name, machine_no, equipment_no, mstprc_date, car_model, location, grid, to_car_model, to_location, to_grid, pullout_location, transfer_reason, pullout_reason, mstprc_eq_member, mstprc_eq_g_leader, mstprc_safety_officer, mstprc_eq_manager, mstprc_eq_sp_personnel, mstprc_prod_engr_manager, mstprc_prod_supervisor, mstprc_prod_manager, mstprc_qa_supervisor, mstprc_qa_manager, mstprc_process_status, disapproved_by, disapproved_by_role, disapproved_comment, file_name, file_url";

    if ($history_option == 1) {
        $sql = $sql . " FROM setup_mstprc";
    } else if ($history_option == 2) {
        $sql = $sql . " FROM setup_mstprc_history";
    }

    if (empty($id)) {
        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " WHERE machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to')";
        }
    } else {
        $sql = $sql . " WHERE id < '$id'";
        if (!empty($machine_name) || !empty($car_model) || !empty($machine_no) || !empty($equipment_no) || !empty($mstprc_no) || (!empty($mstprc_date_from) && !empty($mstprc_date_to))) {
            $sql = $sql . " AND (machine_name LIKE '$machine_name%' AND car_model LIKE '$car_model%' AND machine_no LIKE '$machine_no%' AND equipment_no LIKE '$equipment_no%' AND mstprc_no LIKE '$mstprc_no%' AND (mstprc_date >= '$mstprc_date_from' AND mstprc_date <= '$mstprc_date_to'))";
        }
    }

    if ($history_option == 1) {
        $sql = $sql . " AND mstprc_process_status = 'Approved 1'";
    } else if ($history_option == 2) {
        $sql = $sql . " AND (mstprc_process_status = 'Approved 2' OR mstprc_process_status = 'Disapproved')";
    }
    $sql = $sql . " ORDER BY id DESC LIMIT 25";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            if ($row['mstprc_process_status'] == 'Approved 1') {
                $row_class = $row_class_arr[1];
            } else if ($row['mstprc_process_status'] == 'Approved 2') {
                $row_class = $row_class_arr[2];
            } else if ($row['mstprc_process_status'] == 'Disapproved') {
                $row_class = $row_class_arr[3];
            } else {
                $row_class = $row_class_arr[0];
            }

            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="A2MC_' . $row['mstprc_no'] . '" data-toggle="modal" data-target="#A2MachineChecksheetInfoHistoryModal" data-mstprc_no="' . $row['mstprc_no'] . '" data-mstprc_type="' . $row['mstprc_type'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_no="' . htmlspecialchars($row['machine_no']) . '" data-equipment_no="' . htmlspecialchars($row['equipment_no']) . '" data-car_model="' . htmlspecialchars($row['car_model']) . '" data-location="' . htmlspecialchars($row['location']) . '" data-grid="' . htmlspecialchars($row['grid']) . '" data-to_car_model="' . htmlspecialchars($row['to_car_model']) . '" data-to_location="' . htmlspecialchars($row['to_location']) . '" data-to_grid="' . htmlspecialchars($row['to_grid']) . '" data-pullout_location="' . htmlspecialchars($row['pullout_location']) . '" data-transfer_reason="' . htmlspecialchars($row['transfer_reason']) . '" data-pullout_reason="' . htmlspecialchars($row['pullout_reason']) . '" data-mstprc_eq_member="' . htmlspecialchars($row['mstprc_eq_member']) . '" data-mstprc_eq_g_leader="' . htmlspecialchars($row['mstprc_eq_g_leader']) . '" data-mstprc_safety_officer="' . htmlspecialchars($row['mstprc_safety_officer']) . '" data-mstprc_eq_manager="' . htmlspecialchars($row['mstprc_eq_manager']) . '" data-mstprc_eq_sp_personnel="' . htmlspecialchars($row['mstprc_eq_sp_personnel']) . '" data-mstprc_prod_engr_manager="' . htmlspecialchars($row['mstprc_prod_engr_manager']) . '" data-mstprc_prod_supervisor="' . htmlspecialchars($row['mstprc_prod_supervisor']) . '" data-mstprc_prod_manager="' . htmlspecialchars($row['mstprc_prod_manager']) . '" data-mstprc_qa_supervisor="' . htmlspecialchars($row['mstprc_qa_supervisor']) . '" data-mstprc_qa_manager="' . htmlspecialchars($row['mstprc_qa_manager']) . '" data-mstprc_process_status="' . $row['mstprc_process_status'] . '" data-mstprc_date="' . date("d-M-y", strtotime($row['mstprc_date'])) . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" data-disapproved_by="' . htmlspecialchars($row['disapproved_by']) . '" data-disapproved_by_role="' . htmlspecialchars($row['disapproved_by_role']) . '" data-disapproved_comment="' . htmlspecialchars($row['disapproved_comment']) . '" onclick="get_details_a2_machine_checksheets_history(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . $row['mstprc_no'] . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['equipment_no']) . '</td>';
            echo '<td>' . htmlspecialchars($row['car_model']) . '</td>';
            echo '<td>' . $row['mstprc_type'] . '</td>';
            echo '<td>' . date("Y-m-d", strtotime($row['mstprc_date'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="8" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

$conn = null;
