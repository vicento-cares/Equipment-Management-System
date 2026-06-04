<?php
session_set_cookie_params(0, "/eems");
session_name("eems");
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
    } else if ($_SESSION['setup_approver_role'] == "3") {
        header('location:../approver3/home.php');
        exit();
    }
}

//error_reporting(0); // comment this line to see errors
set_time_limit(0);
date_default_timezone_set("Asia/Manila");

$date_updated = date('Y-m-d H:i:s');

require('../lib/validate.php');
require('../lib/main.php');

function get_current_number_by_name($machine_name, $conn)
{
    $number = 0;
    $sql = "SELECT TOP 1 number FROM m_machines WHERE machine_name = ? ORDER BY number DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$machine_name]);
    
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $number = intval($row['number']);

    return ++$number;
}

function get_machines($conn)
{
    $data = array();

    $sql = "SELECT machine_name FROM m_machines ORDER BY machine_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['machine_name']);
    }

    return $data;
}

function get_lines_final($conn)
{
    $data = array();

    $sql = "SELECT car_model FROM m_line_no_final ORDER BY car_model ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['car_model']);
    }

    return $data;
}

function get_lines_initial($conn)
{
    $data = array();

    $sql = "SELECT car_model FROM m_line_no_initial ORDER BY car_model ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['car_model']);
    }

    return $data;
}

function get_locations($conn)
{
    $data = array();

    $sql = "SELECT location FROM m_locations ORDER BY location ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['location']);
    }

    return $data;
}

function check_csv($file, $conn)
{
    // READ FILE
    $csvFile = fopen($file, 'r');

    // SKIP FIRST LINE
    $first_line = fgets($csvFile);

    $machines_arr = get_machines($conn);
    $lines_initial_arr = get_lines_initial($conn);
    $lines_final_arr = get_lines_final($conn);
    $locations_arr = get_locations($conn);

    $hasError = 0;
    $hasBlankError = 0;
    $isExistsOnDb = 0;
    $isDuplicateOnCsv = 0;
    $hasBlankErrorArr = array();
    $isExistsOnDbArr = array();
    $isDuplicateOnCsvArr = array();
    $dup_temp_arr = array();

    $row_valid_arr = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

    $notExistsMachineNameArr = array();
    $notExistsLineNoArr = array();
    $notExistsLocationArr = array();
    $existsMachineNoArr = array();
    $existsEquipmentNoArr = array();
    $existsTrdNoArr = array();
    $existsNsivNoArr = array();
    $notValidCurrentNumberArr = array();
    $notValidCarModelArr = array();
    $notValidLocationArr = array();

    $message = "";
    $check_csv_row = 0;

    // CHECK CSV BASED ON HEADER
    $first_line = preg_replace('/[\t\n\r]+/', '', $first_line);
    $valid_first_line1 = 'Number,Process,"Machine Name","Machine Specification","Car Model",Location,Grid,"Machine No.","Equipment No.","Asset Tag No.","TRD No.","NS-IV No."';
    $valid_first_line2 = "Number,Process,Machine Name,Machine Specification,Car Model,Location,Grid,Machine No.,Equipment No.,Asset Tag No.,TRD No.,NS-IV No.";
    if ($first_line == $valid_first_line1 || $first_line == $valid_first_line2) {
        while (($line = fgetcsv($csvFile)) !== false) {
            // Check if the row is blank or consists only of whitespace
            if (empty(implode('', $line))) {
                continue; // Skip blank lines
            }

            $check_csv_row++;

            $number = intval(custom_trim($line[0]));
            $process = custom_trim($line[1]);
            $machine_name = custom_trim($line[2]);
            $machine_spec = custom_trim($line[3]);
            $car_model = custom_trim($line[4]);
            $location = custom_trim($line[5]);
            $grid = custom_trim($line[6]);
            $machine_no = custom_trim($line[7]);
            $equipment_no = custom_trim($line[8]);
            $asset_tag_no = custom_trim($line[9]);
            $trd_no = custom_trim($line[10]);
            $ns_iv_no = custom_trim($line[11]);

            $machine_name_raw = $line[2];
            $car_model_raw = $line[4];

            if (empty($asset_tag_no)) {
                $asset_tag_no = 'N/A';
            }

            if ($process == '' || $machine_name == '' || $car_model == '' || $location == '' || ($machine_no == '' && $equipment_no == '')) {
                // IF BLANK DETECTED ERROR += 1
                $hasBlankError++;
                $hasError = 1;
                array_push($hasBlankErrorArr, $check_csv_row);
            }

            // CHECK ROW VALIDATION
            if (!in_array($machine_name_raw, $machines_arr)) {
                $hasError = 1;
                $row_valid_arr[0] = 1;
                array_push($notExistsMachineNameArr, $check_csv_row);
            }
            if (!in_array($car_model_raw, $lines_initial_arr) && !in_array($car_model_raw, $lines_final_arr)) {
                $hasError = 1;
                $row_valid_arr[1] = 1;
                array_push($notExistsLineNoArr, $check_csv_row);
            }
            if (!in_array($location, $locations_arr)) {
                $hasError = 1;
                $row_valid_arr[2] = 1;
                array_push($notExistsLocationArr, $check_csv_row);
            }
            $machine_info = array(
                'machine_no' => $machine_no,
                'equipment_no' => $equipment_no,
                'trd_no' => $trd_no,
                'ns_iv_no' => $ns_iv_no
            );
            $is_exists_arr = check_existing_machine_info($machine_info, 0, $conn);
            if ($is_exists_arr['machine_no_exists'] == true) {
                $hasError = 1;
                $row_valid_arr[3] = 1;
                array_push($existsMachineNoArr, $check_csv_row);
            }
            if ($is_exists_arr['equipment_no_exists'] == true) {
                $hasError = 1;
                $row_valid_arr[4] = 1;
                array_push($existsEquipmentNoArr, $check_csv_row);
            }
            if ($is_exists_arr['trd_no_exists'] == true) {
                $hasError = 1;
                $row_valid_arr[5] = 1;
                array_push($existsTrdNoArr, $check_csv_row);
            }
            if ($is_exists_arr['ns_iv_no_exists'] == true) {
                $hasError = 1;
                $row_valid_arr[6] = 1;
                array_push($existsNsivNoArr, $check_csv_row);
            }
            if ($number <= 0) {
                $hasError = 1;
                $row_valid_arr[7] = 1;
                array_push($notValidCurrentNumberArr, $check_csv_row);
            }
            if ($car_model_raw != 'EQ-Initial' && $car_model_raw != 'EQ-Final') {
                $hasError = 1;
                $row_valid_arr[8] = 1;
                array_push($notExistsLineNoArr, $check_csv_row);
            }
            if ($location != 'FAS4') {
                $hasError = 1;
                $row_valid_arr[9] = 1;
                array_push($notValidLocationArr, $check_csv_row);
            }

            // Joining all row values for checking duplicated rows
            $whole_line = join(',', $line);

            // CHECK ROWS IF IT HAS DUPLICATE ON CSV
            if (isset($dup_temp_arr[$whole_line])) {
                $isDuplicateOnCsv = 1;
                $hasError = 1;
                array_push($isDuplicateOnCsvArr, $check_csv_row);
            } else {
                $dup_temp_arr[$whole_line] = 1;
            }

            // CHECK ROWS IF EXISTS
            $sql = "SELECT id FROM m_machine_masterlist 
                    WHERE process = ? AND machine_name = ? AND machine_spec = ? AND 
                            car_model = ? AND location = ? AND grid = ? AND 
                            machine_no = ? AND equipment_no = ? AND asset_tag_no = ? AND 
                            trd_no = ? AND [ns_iv_no] = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $process, $machine_name, $machine_spec, 
                $car_model, $location, $grid, 
                $machine_no, $equipment_no, $asset_tag_no, 
                $trd_no, $ns_iv_no
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $isExistsOnDb = 1;
                $hasError = 1;
                array_push($isExistsOnDbArr, $check_csv_row);
            }
        }
    } else {
        $message = $message . 'Invalid CSV Table Header. Maybe an incorrect CSV file or incorrect CSV header ';
    }

    fclose($csvFile);

    if ($hasError == 1) {
        if ($row_valid_arr[0] == 1) {
            $message = $message . 'Machine Name doesn\'t exists on row/s ' . implode(", ", $notExistsMachineNameArr) . '. ';
        }
        if ($row_valid_arr[1] == 1) {
            $message = $message . 'Car Model doesn\'t exists on row/s ' . implode(", ", $notExistsLineNoArr) . '. ';
        }
        if ($row_valid_arr[2] == 1) {
            $message = $message . 'Location doesn\'t exists on row/s ' . implode(", ", $notExistsLocationArr) . '. ';
        }
        if ($row_valid_arr[3] == 1) {
            $message = $message . 'Machine No. exists on row/s ' . implode(", ", $existsMachineNoArr) . '. ';
        }
        if ($row_valid_arr[4] == 1) {
            $message = $message . 'Equipment No. exists on row/s ' . implode(", ", $existsEquipmentNoArr) . '. ';
        }
        if ($row_valid_arr[5] == 1) {
            $message = $message . 'TRD No. exists on row/s ' . implode(", ", $existsTrdNoArr) . '. ';
        }
        if ($row_valid_arr[6] == 1) {
            $message = $message . 'NS-IV No. exists on row/s ' . implode(", ", $existsNsivNoArr) . '. ';
        }
        if ($row_valid_arr[7] == 1) {
            $message = $message . 'Zero or Negative Current Number on row/s ' . implode(", ", $notValidCurrentNumberArr) . '. ';
        }
        if ($row_valid_arr[8] == 1) {
            $message = $message . 'Car Model must be EQ-Initial or EQ-Final for New Machines on row/s ' . implode(", ", $notValidCarModelArr) . '. ';
        }
        if ($row_valid_arr[9] == 1) {
            $message = $message . 'Location must be FAS4 for New Machines on row/s ' . implode(", ", $notValidLocationArr) . '. ';
        }

        if ($isExistsOnDb == 1) {
            $message = $message . 'Machine Already Registered on row/s ' . implode(", ", $isExistsOnDbArr) . '. ';
        }
        if ($hasBlankError >= 1) {
            $message = $message . 'Blank Cell Exists on row/s ' . implode(", ", $hasBlankErrorArr) . '. ';
        }
        if ($isDuplicateOnCsv == 1) {
            $message = $message . 'Duplicated Record/s on row/s ' . implode(", ", $isDuplicateOnCsvArr) . '. ';
        }
    }
    return $message;
}

if (empty($_FILES['file']['name'])) {
    exit("Please upload a CSV file");
}

$mimes = array(
    'text/x-comma-separated-values', 
    'text/comma-separated-values', 
    'application/octet-stream', 
    'application/vnd.ms-excel', 
    'application/x-csv', 
    'text/x-csv', 
    'text/csv', 
    'application/csv', 
    'application/excel', 
    'application/vnd.msexcel', 
    'text/plain'
);

if (!in_array($_FILES['file']['type'], $mimes)) {
    exit("Invalid file format");
}

if (!is_uploaded_file($_FILES['file']['tmp_name'])) {
    exit("Upload Failed! Try Again or Contact IT Personnel if it fails again");
}

require('../db/conn.php');

$chkCsvMsg = check_csv($_FILES['file']['tmp_name'], $conn);

if ($chkCsvMsg != '') {
    exit($chkCsvMsg);
}

//READ FILE
$csvFile = fopen($_FILES['file']['tmp_name'],'r');

// SKIP FIRST LINE (HEADER)
fgets($csvFile);     

// PARSE
$error = 0;

$isTransactionActive = false;
$chunkSize = 250; // Set your desired chunk size

try {
    if (!$isTransactionActive) {
        $conn->beginTransaction();
        $isTransactionActive = true;
    }

    $sql = "INSERT INTO m_machine_masterlist (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, [ns_iv_no], is_new, date_updated) VALUES ";
    $values = [];
    $placeholders = [];

    while (($line = fgetcsv($csvFile)) !== false) {
        // Check if the row is blank or consists only of whitespace
        if (empty(implode('', $line))) {
            continue; // Skip blank lines
        }

        $number = intval(custom_trim($line[0]));
        $process = custom_trim($line[1]);
        $machine_name = custom_trim($line[2]);
        $machine_spec = custom_trim($line[3]);
        $car_model = custom_trim($line[4]);
        $location = custom_trim($line[5]);
        $grid = custom_trim($line[6]);
        $machine_no = custom_trim($line[7]);
        $equipment_no = custom_trim($line[8]);
        $asset_tag_no = custom_trim($line[9]);
        $trd_no = custom_trim($line[10]);
        $ns_iv_no = custom_trim($line[11]);

        $is_new = 1; // New Machines

        if (empty($asset_tag_no)) {
            $asset_tag_no = 'N/A';
        }

        $current_number = get_current_number_by_name($machine_name, $conn);
        save_current_number($machine_name, $current_number, $conn);

        // Create a temporary array for the current row
        $currentValues = [
            $number,
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
        ];

        // Create placeholders for each row
        $generated_placeholders = implode(',', array_fill(0, count($currentValues), '?'));
        $placeholders[] = "($generated_placeholders)";

        // Add current values to the main values array
        $values = array_merge($values, $currentValues);

        // Check if we reached the chunk size
        if (count($placeholders) === $chunkSize) {
            // Combine the SQL statement with the placeholders
            $sql .= implode(', ', $placeholders);
            
            // Prepare the statement
            $stmt = $conn->prepare($sql);
            
            // Execute the statement with the values
            if (!$stmt->execute($values)) {
                $error++;
            }

            // Reset for the next chunk
            $placeholders = [];
            $values = [];
            $sql = "INSERT INTO m_machine_masterlist (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, [ns_iv_no], is_new, date_updated) VALUES ";
        }
    }

    // Insert any remaining rows that didn't fill a complete chunk
    if (!empty($placeholders)) {
        $sql .= implode(', ', $placeholders);
        $stmt = $conn->prepare($sql);
        if (!$stmt->execute($values)) {
            $error++;
        }
    }

    if ($error > 0) {
        if ($isTransactionActive) {
            $conn->rollBack();
            $isTransactionActive = false;
        }
        echo 'Failed. Please Try Again or Call IT Personnel Immediately!';
        exit();
    }

    $conn->commit();
    $isTransactionActive = false;
} catch (Exception $e) {
    if ($isTransactionActive) {
        $conn->rollBack();
        $isTransactionActive = false;
    }
    echo 'Failed. Please Try Again or Call IT Personnel Immediately!: ' . $e->getMessage();
    exit();
}

fclose($csvFile);

if ($error > 0) {
    echo 'error ' . $error;
}

$conn = null;
