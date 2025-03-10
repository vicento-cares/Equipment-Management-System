<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['pm_username'])) {
  header('location:../../../login/');
  exit;
} else {
  if ($_SESSION['pm_role'] == "Prod") {
    header('location:../prod/home.php');
    exit;
  } else if ($_SESSION['pm_role'] == "QA") {
    header('location:../qa/home.php');
    exit;
  }
}

//error_reporting(0); // comment this line to see errors
date_default_timezone_set("Asia/Manila");
require('../db/conn.php');
require('../lib/validate.php');
require('../lib/main.php');

// Check Machine Docs File
function check_machine_docs_file($machine_docs_file_info, $conn) {
  $message = "";
  $hasError = 0;
  $file_valid_arr = array(0,0,0,0);

  $mimes = array('application/vnd.ms-excel', 'application/excel', 'application/msexcel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-word', 'application/word', 'application/vnd.msword', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.oasis.opendocument.spreadsheet', 'application/vnd.oasis.opendocument.text');

  /*$mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');*/

  /*$mimes = array('application/pdf', 'application/x-pdf', 'application/x-bzpdf', 'application/x-gzpdf', 'applications/vnd.pdf', 'application/acrobat', 'application/x-google-chrome-pdf', 'text/pdf', 'text/x-pdf');*/

  // Check File Mimes
  if (!in_array($machine_docs_file_info['machine_docs_filetype'], $mimes)) {
    $hasError = 1;
    $file_valid_arr[0] = 1;
  }
  // Check File Size
  if ($machine_docs_file_info['machine_docs_size'] > 25000000) {
    $hasError = 1;
    $file_valid_arr[1] = 1;
  }
  // Check File Exists
  if (file_exists($machine_docs_file_info['target_file'])) {
    $hasError = 1;
    $file_valid_arr[2] = 1;
  }
  // Check File Information Exists on Database
  $machine_docs_filename = addslashes($machine_docs_file_info['machine_docs_filename']);
  $machine_docs_filetype = addslashes($machine_docs_file_info['machine_docs_filetype']);
  $machine_docs_url = addslashes($machine_docs_file_info['machine_docs_url']);
  $sql = "SELECT id FROM machine_pm_docs WHERE file_name = '$machine_docs_filename' AND file_type = '$machine_docs_filetype' AND file_url = '$machine_docs_url'";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute();
  if ($stmt -> rowCount() > 0) {
    $hasError = 1;
    $file_valid_arr[3] = 1;
  }

  // Error Collection and Output
  if ($hasError == 1) {
    if ($file_valid_arr[0] == 1) {
      $message = $message . 'Machine Docs file format not accepted! ';
    }
    if ($file_valid_arr[1] == 1) {
      $message = $message . 'Machine Docs file is too large. ';
    }
    if ($file_valid_arr[2] == 1) {
      $message = $message . 'Machine Docs file exists. ';
    }
    if ($file_valid_arr[3] == 1) {
      $message = $message . 'Machine Docs file information exists on the system. ';
    }
  }

  return $message;
}

// Insert File Information
function save_machine_docs_info($machine_docs_file_info, $conn) {
  $process = $machine_docs_file_info['process'];
  $machine_name = addslashes($machine_docs_file_info['machine_name']);
  $machine_docs_type = $machine_docs_file_info['machine_docs_type'];
  $machine_docs_filename = basename($machine_docs_file_info['machine_docs_filename']);
  $machine_docs_filetype = addslashes($machine_docs_file_info['machine_docs_filetype']);
  $machine_docs_url = addslashes($machine_docs_file_info['machine_docs_url']);
  $date_updated = date('Y-m-d H:i:s');

  $sql = "INSERT INTO machine_pm_docs (process, machine_name, machine_docs_type, file_name, file_type, file_url, date_updated) VALUES ('$process', '$machine_name', '$machine_docs_type', '$machine_docs_filename', '$machine_docs_filetype', '$machine_docs_url', '$date_updated')";
  $stmt = $conn -> prepare($sql);
  $stmt -> execute();
}

// Declaration & Initialization
$process = $_POST['process'];
$machine_name = custom_trim($_POST['machine_name']);
$machine_docs_type = $_POST['machine_docs_type'];

$is_valid = false;

// Check All Inputs
if (!empty($machine_name)) {
  if (!empty($machine_docs_type)) {
    $is_valid = true;
  } else echo "Please set Type";
} else echo "Please set Machine Name";

if ($is_valid == true) {

  // Upload File
  if (!empty($_FILES['file']['name'])) {
    $machine_docs_file = $_FILES['file']['tmp_name'];
    $machine_docs_filename = $_FILES['file']['name'];
    $machine_docs_filetype = $_FILES['file']['type'];
    $machine_docs_size = $_FILES['file']['size'];

    //$machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/pm/uploads/machine_docs/";
    //$target_dir = "../../uploads/machine_docs/";
    // $machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/machine_docs/";
    $machine_docs_url = "/uploads/ems/pm/machine_docs/";
    $target_dir = "../../../../uploads/ems/pm/machine_docs/";
    $target_file = $target_dir . basename($machine_docs_filename);
    $machine_docs_url .= rawurlencode(basename($machine_docs_filename));

    $machine_docs_file_info = array(
      'process' => $process,
      'machine_name' => $machine_name,
      'machine_docs_type' => $machine_docs_type,
      'machine_docs_file' => $machine_docs_file,
      'machine_docs_filename' => $machine_docs_filename,
      'machine_docs_filetype' => $machine_docs_filetype,
      'machine_docs_size' => $machine_docs_size,
      'target_file' => $target_file,
      'machine_docs_url' => $machine_docs_url
    );

    // Check Machine Docs File
    $chkMachineDocsFileMsg = check_machine_docs_file($machine_docs_file_info, $conn);

    if ($chkMachineDocsFileMsg == '') {

      // Upload File and Check if successfully uploaded
      // Note: Can overwrite existing file
      if (move_uploaded_file($machine_docs_file, $target_file)) {

        // Insert File Information
        save_machine_docs_info($machine_docs_file_info, $conn);

      } else {
        echo "Sorry, there was an error uploading your file. Try Again or Contact IT Personnel if it fails again";
      }

    } else {
      echo $chkMachineDocsFileMsg;
    }

  } else {
    echo 'Please upload machine docs file';
  }

}

$conn = null;
?>