<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['pm_username'])) {
    header('location:../../../login/');
    exit();
} else {
    if ($_SESSION['pm_role'] == "Prod") {
        header('location:../prod/home.php');
        exit();
    } else if ($_SESSION['pm_role'] == "QA") {
        header('location:../qa/home.php');
        exit();
    }
}

//error_reporting(0); // comment this line to see errors
date_default_timezone_set("Asia/Manila");
require('../db/conn.php');
require('../lib/validate.php');
require('../lib/main.php');

$start_row = 1;
$insertsql = "INSERT INTO machine_pm_plan (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, trd_no, `ns-iv_no`, pm_plan_year, ww_no, ww_start_date, frequency, date_updated) VALUES ";
$subsql = "";

$date_updated = date('Y-m-d H:i:s');

function count_row($file)
{
    $linecount = -3;
    $handle = fopen($file, "r");
    while (!feof($handle)) {
        $line = fgets($handle);
        $linecount++;
    }

    fclose($handle);

    return $linecount;
}

function check_csv($file, $conn)
{
    // READ FILE
    $csvFile = fopen($file, 'r');

    // SKIP FIRST LINE
    $first_line = fgets($csvFile);

    $hasError = 0;
    $hasBlankError = 0;
    $isExistsOnDb = 0;
    $isDuplicateOnCsv = 0;
    $notExistsMachine = 0;
    $notValidWWStartDate = 0;
    $hasBlankErrorArr = array();
    $isExistsOnDbArr = array();
    $isDuplicateOnCsvArr = array();
    $dup_temp_arr = array();
    $notExistsMachineArr = array();
    $notValidWWStartDateArr = array();

    $message = "";
    $check_csv_row = 0;

    // CHECK CSV BASED ON HEADER
    $first_line = preg_replace('/[\t\n\r]+/', '', $first_line);
    $valid_first_line1 = 'Number,Process,"Machine Name","Machine Specification","Car Model",Location,Grid,"Machine No.","Equipment No.","TRD No.","NS-IV No.","PM Plan Year","WW No.","WW Start Date",Frequency';
    $valid_first_line2 = "Number,Process,Machine Name,Machine Specification,Car Model,Location,Grid,Machine No.,Equipment No.,TRD No.,NS-IV No.,PM Plan Year,WW No.,WW Start Date,Frequency";
    if ($first_line == $valid_first_line1 || $first_line == $valid_first_line2) {

        // SKIP EXAMPLE LINE (SECOND LINE)
        fgets($csvFile);

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
            $trd_no = custom_trim($line[9]);
            $ns_iv_no = custom_trim($line[10]);
            $pm_plan_year = custom_trim($line[11]);
            $ww_no = custom_trim($line[12]);
            $ww_start_date = custom_trim($line[13]);
            $frequency = custom_trim($line[14]);

            if ($pm_plan_year == '' || $ww_no == '' || $ww_start_date == '' || $frequency == '') {
                // IF BLANK DETECTED ERROR += 1
                $hasBlankError++;
                $hasError = 1;
                array_push($hasBlankErrorArr, $check_csv_row);
            }

            $ww_start_date = str_replace('/', '-', $ww_start_date);
            $is_valid_ww_start_date = validate_date($ww_start_date);

            // CHECK ROW VALIDATION
            if ($is_valid_ww_start_date == false) {
                $hasError = 1;
                $notValidWWStartDate = 1;
                array_push($notValidWWStartDateArr, $check_csv_row);
            }

            // CHECK ROW VALIDATION
            $sql = "SELECT id FROM machine_masterlist WHERE process = '$process' AND machine_name = '$machine_name' AND machine_spec = '$machine_spec' AND car_model = '$car_model' AND location = '$location' AND grid = '$grid' AND machine_no = '$machine_no' AND equipment_no = '$equipment_no' AND trd_no = '$trd_no' AND `ns-iv_no` = '$ns_iv_no'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() <= 0) {
                $notExistsMachine++;
                $hasError = 1;
                array_push($notExistsMachineArr, $check_csv_row);
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
            $sql = "SELECT id FROM machine_pm_plan WHERE process = '$process' AND machine_name = '$machine_name' AND machine_spec = '$machine_spec' AND car_model = '$car_model' AND location = '$location' AND grid = '$grid' AND machine_no = '$machine_no' AND equipment_no = '$equipment_no' AND trd_no = '$trd_no' AND `ns-iv_no` = '$ns_iv_no' AND pm_plan_year = '$pm_plan_year' AND ww_no = '$ww_no' AND frequency = '$frequency'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
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
        if ($notValidWWStartDate == 1) {
            $message = $message . 'Invalid WW Start Date Format on row/s ' . implode(", ", $notValidWWStartDateArr) . '. ';
        }
        if ($notExistsMachine == 1) {
            $message = $message . 'Machine Doesn\'t Exists on row/s ' . implode(", ", $notExistsMachineArr) . '. ';
        }
        if ($isExistsOnDb == 1) {
            $message = $message . 'PM Plan of this Machine Already Saved on row/s ' . implode(", ", $isExistsOnDbArr) . '. ';
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

    if (in_array($_FILES['file']['type'], $mimes)) {

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            $row_count = count_row($_FILES['file']['tmp_name']);

            $chkCsvMsg = check_csv($_FILES['file']['tmp_name'], $conn);

            if ($chkCsvMsg == '') {

                if (($csv_file = fopen($_FILES['file']['tmp_name'], "r")) !== false) {

                    $temp_count = 0;
                    fgets($csv_file);  // read one line for nothing (skip header / first row)
                    fgets($csv_file);  // read one line for nothing (skip example / second row)
                    while (($read_data = fgetcsv($csv_file, 1000, ",")) !== false) {
                        // Check if the row is blank or consists only of whitespace
                        if (empty(implode('', $read_data))) {
                            continue; // Skip blank lines
                        }

                        $ww_start_date = $read_data[13];

                        $column_count = count($read_data);
                        $subsql = $subsql . " (";
                        $temp_count++;
                        $start_row++;
                        for ($c = 0; $c < $column_count; $c++) {
                            if ($c == 13) {
                                $ww_start_date = str_replace('/', '-', $ww_start_date);
                                $ww_start_date = date("Y-m-d", strtotime($ww_start_date));
                                $subsql = $subsql . '\'' . $ww_start_date . '\',';
                            } else {
                                $subsql = $subsql . '\'' . addslashes(custom_trim($read_data[$c])) . '\',';
                            }
                        }
                        $subsql = substr($subsql, 0, strlen($subsql) - 2);
                        $subsql = $subsql . '\', \'' . $date_updated . '\')' . " , ";
                        if ($temp_count % 250 == 0) {
                            $subsql = substr($subsql, 0, strlen($subsql) - 3);
                            $insertsql = $insertsql . $subsql . ";";
                            $insertsql = substr($insertsql, 0, strlen($insertsql));
                            $stmt = $conn->prepare($insertsql);
                            $stmt->execute();
                            $insertsql = "INSERT INTO machine_pm_plan (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, trd_no, `ns-iv_no`, pm_plan_year, ww_no, ww_start_date, frequency, date_updated) VALUES ";
                            $subsql = "";
                        } else if ($temp_count == $row_count) {
                            $subsql = substr($subsql, 0, strlen($subsql) - 3);
                            $insertsql2 = $insertsql . $subsql . ";";
                            $insertsql2 = substr($insertsql2, 0, strlen($insertsql2));
                            $stmt = $conn->prepare($insertsql2);
                            $stmt->execute();
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
