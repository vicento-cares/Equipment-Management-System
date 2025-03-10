<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['setup_username'])) {
  header('location:../../../login/');
  exit;
} else {
  if ($_SESSION['setup_approver_role'] == "1") {
    header('location:../approver1/home.php');
    exit;
  } else if ($_SESSION['setup_approver_role'] == "2") {
    header('location:../approver2/home.php');
    exit;
  } else if ($_SESSION['setup_approver_role'] == "3") {
    header('location:../approver3/home.php');
    exit;
  }
}

//error_reporting(0); // comment this line to see errors
date_default_timezone_set("Asia/Manila");
require('../db/conn.php');
require('../lib/validate.php');
require('../lib/main.php');

function get_current_number_by_name($machine_name, $conn) {
    $machine_name = addslashes($machine_name);
    $number = 0;
    $sql = "SELECT number FROM machines WHERE machine_name = '$machine_name' ORDER BY number DESC LIMIT 1";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    if ($stmt -> rowCount() > 0) {
        while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
            $number = intval($row['number']);
        }
    }
    return ++$number;
}

$start_row = 1;
$insertsql = "INSERT INTO machine_masterlist (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, ns-iv_no, is_new, date_updated) VALUES ";
$subsql = "";

$date_updated = date('Y-m-d H:i:s');

function get_machines($conn) {
    $data = array();

    $sql = "SELECT machine_name FROM machines ORDER BY machine_name ASC";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['machine_name']);
    }

    return $data;
}

function get_lines_final($conn) {
    $data = array();

    $sql = "SELECT car_model FROM line_no_final ORDER BY car_model ASC";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['car_model']);
    }
    
    return $data;
}

function get_lines_initial($conn) {
    $data = array();

    $sql = "SELECT car_model FROM line_no_initial ORDER BY car_model ASC";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['car_model']);
    }
    
    return $data;
}

function get_locations($conn) {
    $data = array();

    $sql = "SELECT location FROM locations ORDER BY location ASC";
    $stmt = $conn -> prepare($sql);
    $stmt -> execute();
    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $row['location']);
    }
    
    return $data;
}

function count_row ($file) {
    $linecount = -2;
    $handle = fopen($file, "r");
    while(!feof($handle)){
      $line = fgets($handle);
      $linecount++;
    }

    fclose($handle);

    return $linecount;
}

function check_csv ($file, $conn) {
    // READ FILE
    $csvFile = fopen($file,'r');

    // SKIP FIRST LINE
    $first_line = fgets($csvFile);

    $machines_arr = get_machines($conn);
    $lines_initial_arr = get_lines_initial($conn);
    $lines_final_arr = get_lines_final($conn);
    $locations_arr = get_locations($conn);

    $hasError = 0; $hasBlankError = 0; $isExistsOnDb = 0; $isDuplicateOnCsv = 0;
    $hasBlankErrorArr = array();
    $isExistsOnDbArr = array();
    $isDuplicateOnCsvArr = array();
    $dup_temp_arr = array();

    $row_valid_arr = array(0,0,0,0,0,0,0,0,0,0);

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
            $machine_name = addslashes(custom_trim($line[2]));
            $machine_spec = addslashes(custom_trim($line[3]));
            $car_model = addslashes(custom_trim($line[4]));
            $location = custom_trim($line[5]);
            $grid = addslashes(custom_trim($line[6]));
            $machine_no = addslashes(custom_trim($line[7]));
            $equipment_no = addslashes(custom_trim($line[8]));
            $asset_tag_no = addslashes(custom_trim($line[9]));
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
            $sql = "SELECT id FROM machine_masterlist WHERE process = '$process' AND machine_name = '$machine_name' AND machine_spec = '$machine_spec' AND car_model = '$car_model' AND location = '$location' AND grid = '$grid' AND machine_no = '$machine_no' AND equipment_no = '$equipment_no' AND asset_tag_no = '$asset_tag_no' AND trd_no = '$trd_no' AND ns-iv_no = '$ns_iv_no'";
            $stmt = $conn -> prepare($sql);
            $stmt -> execute();
            if ($stmt -> rowCount() > 0) {
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

$mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

if (!empty($_FILES['file']['name'])) {

    if (in_array($_FILES['file']['type'],$mimes)) {

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $row_count = count_row($_FILES['file']['tmp_name']);

            $chkCsvMsg = check_csv($_FILES['file']['tmp_name'], $conn);

            if ($chkCsvMsg == '') {

                if (($csv_file = fopen($_FILES['file']['tmp_name'], "r")) !== false) {

                    $temp_count = 0;
                    fgets($csv_file);  // read one line for nothing (skip header / first row)
                    while (($read_data = fgetcsv($csv_file, 1000, ",")) !== false) {
                        // Check if the row is blank or consists only of whitespace
                        if (empty(implode('', $read_data))) {
                            continue; // Skip blank lines
                        }
            
                        $current_number = get_current_number_by_name($read_data[2], $conn);
                        $machine_name = addslashes(custom_trim($read_data[2]));
                        $asset_tag_no = addslashes(custom_trim($read_data[9]));

                        $is_new = 1; // New Machines

                        if (empty($asset_tag_no)) {
                            $asset_tag_no = 'N/A';
                        }

                        save_current_number($read_data[2], $current_number, $conn);

                        $column_count = count($read_data);
                        $subsql = $subsql . " (";
                        $temp_count++;
                        $start_row++;
                        for ($c = 0; $c < $column_count; $c++) {
                            if ($c == 9) {
                                $subsql = $subsql . '\'' . $asset_tag_no . '\',';
                            } else {
                                $subsql = $subsql . '\'' . addslashes(custom_trim($read_data[$c])) . '\',';
                            }
                        }
                        $subsql = substr($subsql, 0, strlen($subsql) - 2);
                        $subsql = $subsql . '\', \'' . $is_new . '\', \'' . $date_updated . '\')' . " , ";
                        if ($temp_count % 250 == 0) {
                            $subsql = substr($subsql, 0, strlen($subsql) - 3);
                            $insertsql = $insertsql . $subsql . ";";
                            $insertsql = substr($insertsql, 0, strlen($insertsql));
                            $stmt = $conn -> prepare($insertsql);
                            $stmt -> execute();
                            $insertsql = "INSERT INTO machine_masterlist (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, asset_tag_no, trd_no, ns-iv_no, is_new, date_updated) VALUES ";
                            $subsql = "";
                        } else if ($temp_count == $row_count) {
                            $subsql = substr($subsql, 0, strlen($subsql) - 3);
                            $insertsql2 = $insertsql . $subsql . ";";
                            $insertsql2 = substr($insertsql2, 0, strlen($insertsql2));
                            $stmt = $conn -> prepare($insertsql2);
                            $stmt -> execute();
                        }
                    }
                    
                    fclose($csv_file);

                } else {
                    echo 'Reading CSV file Failed! Try Again or Contact IT Personnel if it fails again';
                }

            } else {
                echo $chkCsvMsg;
            }

        } else {
            echo 'Upload Failed! Try Again or Contact IT Personnel if it fails again';
        }

    } else {
        echo 'Invalid file format';
    }

} else {
    echo 'Please upload a CSV file';
}

$conn = null;
?>