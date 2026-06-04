<?php
session_set_cookie_params(0, "/eems");
session_name("eems");
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
set_time_limit(0);
date_default_timezone_set("Asia/Manila");

$date_updated = date('Y-m-d H:i:s');

require('../lib/validate.php');
require('../lib/main.php');

// parse Date
function parseDate($date_sample) {
    // Define an array of possible date formats
    $formats = [
        'm/d/Y', // MM/DD/YYYY
        'd/m/Y', // DD/MM/YYYY
        'Y-m-d', // YYYY-MM-DD
        'm-d-Y', // MM-DD-YYYY
        'd-m-Y', // DD-MM-YYYY
        'Y/m/d', // YYYY/MM/DD
        'd/m/y', // DD/MM/YY
        'm/d/y', // MM/DD/YY
        // Add more formats as needed
    ];

    foreach ($formats as $format) {
        $dateTime = DateTime::createFromFormat($format, $date_sample);
        if ($dateTime) {
            return $dateTime; // Return the DateTime object
        }
    }

    // If no format matched, return an error or handle it as needed
    return "Invalid date format: " . htmlspecialchars($date_sample);
}

function check_csv($file, $conn)
{
    // READ FILE
    $csvFile = fopen($file, 'r');

    // SKIP FIRST LINE
    $first_line = fgets($csvFile);

    // SKIP SECOND LINE (EXAMPLE ROW)
    fgets($csvFile);

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

            $ww_start_date_result = parseDate($ww_start_date);

            // Check if the result is a DateTime object or an error message
            if ($ww_start_date_result instanceof DateTime) {
                $ww_start_date = $ww_start_date_result->format('Y-m-d'); // Outputs: 2025-05-28
            } else {
                $hasError = 1;
                $notValidWWStartDate = 1;
                array_push($notValidWWStartDateArr, $check_csv_row);
            }

            // CHECK ROW VALIDATION
            $sql = "SELECT id FROM m_machine_masterlist 
                    WHERE process = ? AND machine_name = ? AND machine_spec = ? AND car_model = ? AND 
                        location = ? AND grid = ? AND machine_no = ? AND 
                        equipment_no = ? AND trd_no = ? AND [ns_iv_no] = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $process, $machine_name, $machine_spec, $car_model, 
                $location, $grid, $machine_no, 
                $equipment_no, $trd_no, $ns_iv_no
            ]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$row) {
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
            $sql = "SELECT id FROM t_machine_pm_plan 
                    WHERE process = ? AND machine_name = ? AND machine_spec = ? AND car_model = ? AND 
                        location = ? AND grid = ? AND machine_no = ? AND 
                        equipment_no = ? AND trd_no = ? AND [ns_iv_no] = ? AND 
                        pm_plan_year = ? AND ww_no = ? AND frequency = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                $process, $machine_name, $machine_spec, $car_model, 
                $location, $grid, $machine_no, 
                $equipment_no, $trd_no, $ns_iv_no, 
                $pm_plan_year, $ww_no, $frequency
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

// SKIP SECOND LINE (EXAMPLE ROW)
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

    $sql = "INSERT INTO t_machine_pm_plan (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, trd_no, [ns_iv_no], pm_plan_year, ww_no, ww_start_date, frequency, date_updated) VALUES ";
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
        $trd_no = custom_trim($line[9]);
        $ns_iv_no = custom_trim($line[10]);
        $pm_plan_year = custom_trim($line[11]);
        $ww_no = custom_trim($line[12]);
        $ww_start_date = custom_trim($line[13]);
        $frequency = custom_trim($line[14]);

        $ww_start_date_result = parseDate($ww_start_date);

        // Check if the result is a DateTime object or an error message
        if ($ww_start_date_result instanceof DateTime) {
            $ww_start_date = $ww_start_date_result->format('Y-m-d'); // Outputs: 2025-05-28
        } else {
            exit("Parse Date Error on Machine No. (".$machine_no.") or Equipment No. (".$machine_no.")" . $result);
        }

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
            $trd_no,
            $ns_iv_no,
            $pm_plan_year,
            $ww_no,
            $ww_start_date,
            $frequency,
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
            $sql = "INSERT INTO t_machine_pm_plan (number, process, machine_name, machine_spec, car_model, location, grid, machine_no, equipment_no, trd_no, [ns_iv_no], pm_plan_year, ww_no, ww_start_date, frequency, date_updated) VALUES ";
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
