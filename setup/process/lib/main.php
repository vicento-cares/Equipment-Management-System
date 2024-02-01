<?php
// Main (All Reusable Function)

// Check Line No.
function check_line_no_initial($car_model, $conn) {
	$sql = "SELECT `id` FROM `line_no_initial` WHERE `car_model`= ?";
	$stmt = $conn -> prepare($sql);
	$params = array($car_model);
    $stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

// Check Line No.
function check_line_no_final($car_model, $conn) {
	$sql = "SELECT `id` FROM `line_no_final` WHERE `car_model`= ?";
	$stmt = $conn -> prepare($sql);
	$params = array($car_model);
    $stmt -> execute($params);
	if ($stmt -> rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

// Get Machine Details
function get_machine_details($machine_name, $conn) {
	$machine_name = addslashes($machine_name);
	$process = '';
	$trd = 0;
	$ns_iv = 0;

	$sql = "SELECT `process`, `trd`, `ns-iv` FROM `machines` WHERE `machine_name`= '$machine_name'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$process = $row['process'];
			$trd = intval($row['trd']);
			$ns_iv = intval($row['ns-iv']);
		}
	}

	$response_arr = array(
		'process' => $process,
		'trd' => $trd,
		'ns_iv' => $ns_iv
	);

	return $response_arr;
}

function save_current_number($machine_name, $current_number, $conn) {
    $machine_name = addslashes($machine_name);
    $sql = "UPDATE `machines` SET `number`= '$current_number' WHERE `machine_name`= '$machine_name'";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
}

function check_existing_machine_info($machine_info, $id, $conn) {
    $machine_no_exists = false;
    $equipment_no_exists = false;
    $trd_no_exists = false;
    $ns_iv_no_exists = false;

    if (!empty($machine_info['machine_no'])) {
        $machine_no = addslashes($machine_info['machine_no']);
        $sql = "SELECT `machine_no` FROM `machine_masterlist` WHERE `machine_no`= '$machine_no'";
        if (!empty($id)) {
            $sql = $sql . " AND `id`!= '$id'";
        }
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            $machine_no_exists = true;
        }
    }
    if (!empty($machine_info['equipment_no'])) {
        $equipment_no = addslashes($machine_info['equipment_no']);
        $sql = "SELECT `equipment_no` FROM `machine_masterlist` WHERE `equipment_no`= '$equipment_no'";
        if (!empty($id)) {
            $sql = $sql . " AND `id`!= '$id'";
        }
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            $equipment_no_exists = true;
        }
    }
    if (!empty($machine_info['trd_no'])) {
        $trd_no = $machine_info['trd_no'];
        $sql = "SELECT `trd_no` FROM `machine_masterlist` WHERE `trd_no`= '$trd_no'";
        if (!empty($id)) {
            $sql = $sql . " AND `id`!= '$id'";
        }
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            $trd_no_exists = true;
        }
    }
    if (!empty($machine_info['ns_iv_no'])) {
        $ns_iv_no = $machine_info['ns_iv_no'];
        $sql = "SELECT `ns-iv_no` FROM `machine_masterlist` WHERE `ns-iv_no`= '$ns_iv_no'";
        if (!empty($id)) {
            $sql = $sql . " AND `id`!= '$id'";
        }
        $stmt = $conn -> prepare($sql);
        $stmt -> execute();
        if ($stmt -> rowCount() > 0) {
            $ns_iv_no_exists = true;
        }
    }

    $is_exists_arr = array(
        'id' => $id,
        'machine_no_exists' => $machine_no_exists,
        'equipment_no_exists' => $equipment_no_exists,
        'trd_no_exists' => $trd_no_exists,
        'ns_iv_no_exists' => $ns_iv_no_exists
    );

    return $is_exists_arr;
}

function get_machine_details_by_id($machine_no, $equipment_no, $conn) {
    $machine_no = addslashes($machine_no);
    $equipment_no = addslashes($equipment_no);
    $number = '';
    $asset_tag_no = '';
    $trd_no = '';
    $ns_iv_no = '';
    $machine_name = '';
    $machine_spec = '';
    $process = '';
    $location = '';
    $grid = '';
    $car_model = '';
    $machine_status = '';
    $is_new = 0;
    $registered = false;

    $sql = "SELECT `number`, `process`, `machine_name`, `machine_spec`, `car_model`, `location`, `grid`, `machine_no`, `equipment_no`, `asset_tag_no`, `trd_no`, `ns-iv_no`, `machine_status`, `is_new` FROM `machine_masterlist`";
    if (!empty($machine_no) && !empty($equipment_no)) {
        $sql = $sql . " WHERE machine_no = '$machine_no' AND equipment_no = '$equipment_no'";
    } else if (!empty($machine_no)) {
        $sql = $sql . " WHERE machine_no = '$machine_no'";
    } else if (!empty($equipment_no)) {
        $sql = $sql . " WHERE equipment_no = '$equipment_no'";
    }
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    if ($stmt -> rowCount() > 0) {
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
            $number = $row['number'];
            $process = $row['process'];
            $machine_name = $row['machine_name'];
            $machine_spec = $row['machine_spec'];
            $car_model = $row['car_model'];
            $location = $row['location'];
            $grid = $row['grid'];
            $machine_no = $row['machine_no'];
            $equipment_no = $row['equipment_no'];
            $asset_tag_no = $row['asset_tag_no'];
            $trd_no = $row['trd_no'];
            $ns_iv_no = $row['ns-iv_no'];
            $machine_status = $row['machine_status'];
            $is_new = intval($row['is_new']);
        }
        $registered = true;
    }

    $response_arr = array(
        'number' => $number,
        'process' => $process,
        'machine_name' => $machine_name,
        'machine_spec' => $machine_spec,
        'car_model' => $car_model,
        'location' => $location,
        'grid' => $grid,
        'machine_no' => $machine_no,
        'equipment_no' => $equipment_no,
        'asset_tag_no' => $asset_tag_no,
        'trd_no' => $trd_no,
        'ns_iv_no' => $ns_iv_no,
        'machine_status' => $machine_status,
        'is_new' => $is_new,
        'registered' => $registered
    );

    return $response_arr;
}

// Check RSIR that is already on process of approval
function check_pm_rsir_on_process($machine_no, $equipment_no, $rsir_eq_group, $conn) {
    $sql = "SELECT id FROM `pm_rsir` WHERE `machine_no`= '$machine_no' AND `equipment_no`= '$equipment_no' AND `rsir_process_status` != 'Returned' AND `rsir_eq_group`= '$rsir_eq_group'";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    if ($stmt -> rowCount() > 0) {
        echo true;
    } else {
        echo false;
    }
}

?>