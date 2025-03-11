<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');
require('../lib/validate.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit;
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';

// Check Machine Docs File
function check_machine_docs_file($machine_docs_file_info, $action, $conn)
{
    $message = "";
    $hasError = 0;
    $file_valid_arr = array(0, 0, 0, 0);

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
        if ($action == 'Insert') {
            $hasError = 1;
            $file_valid_arr[2] = 1;
        } else if ($machine_docs_file_info['old_machine_docs_filename'] != $machine_docs_file_info['machine_docs_filename']) {
            $hasError = 1;
            $file_valid_arr[2] = 1;
        }
    }
    // Check File Information Exists on Database
    $machine_docs_filename = addslashes($machine_docs_file_info['machine_docs_filename']);
    $machine_docs_filetype = addslashes($machine_docs_file_info['machine_docs_filetype']);
    $machine_docs_url = addslashes($machine_docs_file_info['machine_docs_url']);
    $sql = "SELECT id FROM machine_pm_docs WHERE file_name = '$machine_docs_filename' AND file_type = '$machine_docs_filetype' AND file_url = '$machine_docs_url'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        if ($action == 'Insert') {
            $hasError = 1;
            $file_valid_arr[3] = 1;
        } else if ($machine_docs_file_info['old_machine_docs_filename'] != $machine_docs_file_info['machine_docs_filename']) {
            $hasError = 1;
            $file_valid_arr[3] = 1;
        }
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
function save_machine_docs_info($machine_docs_file_info, $conn)
{
    $process = $machine_docs_file_info['process'];
    $machine_name = addslashes($machine_docs_file_info['machine_name']);
    $machine_docs_type = $machine_docs_file_info['machine_docs_type'];
    $machine_docs_filename = basename($machine_docs_file_info['machine_docs_filename']);
    $machine_docs_filetype = addslashes($machine_docs_file_info['machine_docs_filetype']);
    $machine_docs_url = addslashes($machine_docs_file_info['machine_docs_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "INSERT INTO machine_pm_docs (process, machine_name, machine_docs_type, file_name, file_type, file_url, date_updated) VALUES ('$process', '$machine_name', '$machine_docs_type', '$machine_docs_filename', '$machine_docs_filetype', '$machine_docs_url', '$date_updated')";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

// Update File Information
function update_machine_docs_info($machine_docs_file_info, $conn)
{
    $id = $machine_docs_file_info['id'];
    $process = $machine_docs_file_info['process'];
    $machine_name = addslashes($machine_docs_file_info['machine_name']);
    $machine_docs_type = $machine_docs_file_info['machine_docs_type'];
    $machine_docs_filename = basename($machine_docs_file_info['machine_docs_filename']);
    $machine_docs_filetype = addslashes($machine_docs_file_info['machine_docs_filetype']);
    $machine_docs_url = addslashes($machine_docs_file_info['machine_docs_url']);
    $date_updated = date('Y-m-d H:i:s');

    $sql = "UPDATE machine_pm_docs SET process = '$process', machine_name = '$machine_name', machine_docs_type = '$machine_docs_type', file_name = '$machine_docs_filename', file_type = '$machine_docs_filetype', file_url = '$machine_docs_url', date_updated = '$date_updated' WHERE id = '$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

// Count
if ($method == 'count_machine_docs') {
    $search = addslashes($_POST['search']);
    $sql = "SELECT count(id) AS total FROM machine_pm_docs";
    if (!empty($search)) {
        $sql = $sql . " WHERE machine_name LIKE '$search%' OR machine_docs_type LIKE '$search%' OR file_name LIKE '$search%'";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo $row['total'];
        }
    }
}

// Read / Load
if ($method == 'load_machine_docs') {
    $id = $_POST['id'];
    $search = addslashes($_POST['search']);
    $c = $_POST['c'];

    $sql = "SELECT id, process, machine_name, machine_docs_type, file_name, file_url, date_updated FROM machine_pm_docs";

    if (!empty($id) && empty($search)) {
        $sql = $sql . " WHERE id > '$id'";
    } else if (empty($id) && !empty($search)) {
        $sql = $sql . " WHERE machine_name LIKE '$search%' OR machine_docs_type LIKE '$search%' OR file_name LIKE '$search%'";
    } else if (!empty($id) && !empty($search)) {
        $sql = $sql . " WHERE id > '$id' AND (machine_name LIKE '$search%' OR machine_docs_type LIKE '$search%' OR file_name LIKE '$search%')";
    }
    $sql = $sql . " ORDER BY id ASC LIMIT 10";

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $c++;
            echo '<tr style="cursor:pointer;" class="modal-trigger" id="' . $row['id'] . '" data-toggle="modal" data-target="#MachineDocsDetailsModal" data-id="' . $row['id'] . '" data-process="' . $row['process'] . '" data-machine_name="' . htmlspecialchars($row['machine_name']) . '" data-machine_docs_type="' . $row['machine_docs_type'] . '" data-file_name="' . htmlspecialchars($row['file_name']) . '" data-file_url="' . htmlspecialchars($protocol . $_SERVER['SERVER_ADDR'] . ":" . $_SERVER['SERVER_PORT'] . $row['file_url']) . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details_machine_docs(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . htmlspecialchars($row['machine_name']) . '</td>';
            echo '<td>' . $row['machine_docs_type'] . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr>';
        echo '<td colspan="4" style="text-align:center; color:red;">No Results Found</td>';
        echo '</tr>';
    }
}

// Create / Insert
if ($method == 'save_machine_docs') {
    // Declaration & Initialization
    $process = $_POST['process'];
    $machine_name = custom_trim($_POST['machine_name']);
    $machine_docs_type = $_POST['machine_docs_type'];

    $is_valid = false;

    // Check All Inputs
    if (!empty($machine_name)) {
        if (!empty($machine_docs_type)) {
            $is_valid = true;
        } else
            echo "Please set Type";
    } else
        echo "Please set Machine Name";

    if ($is_valid == true) {

        // Upload File
        if (!empty($_FILES['file']['name'])) {
            $machine_docs_file = $_FILES['file']['tmp_name'];
            $machine_docs_filename = $_FILES['file']['name'];
            $machine_docs_filetype = $_FILES['file']['type'];
            $machine_docs_size = $_FILES['file']['size'];

            $machine_docs_url = "";
            $target_dir = "";

            switch ($machine_docs_type) {
                case 'WI':
                    //$machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/pm/uploads/machine_docs/wi/";
                    //$target_dir = "../../uploads/machine_docs/wi/";
                    // $machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/machine_docs/wi/";
                    $machine_docs_url = "/uploads/ems/pm/machine_docs/wi/";
                    $target_dir = "../../../../uploads/ems/pm/machine_docs/wi/";
                    break;
                case 'OP-014':
                    //$machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/pm/uploads/machine_docs/op-014/";
                    //$target_dir = "../../uploads/machine_docs/op-014/";
                    // $machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/machine_docs/op-014/";
                    $machine_docs_url = "/uploads/ems/pm/machine_docs/op-014/";
                    $target_dir = "../../../../uploads/ems/pm/machine_docs/op-014/";
                    break;
                case 'RSIR':
                    //$machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/pm/uploads/machine_docs/rsir/";
                    //$target_dir = "../../uploads/machine_docs/rsir/";
                    // $machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/machine_docs/rsir/";
                    $machine_docs_url = "/uploads/ems/pm/machine_docs/rsir/";
                    $target_dir = "../../../../uploads/ems/pm/machine_docs/rsir/";
                    break;
                default:
                    break;
            }

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
            $chkMachineDocsFileMsg = check_machine_docs_file($machine_docs_file_info, 'Insert', $conn);

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
}

// Update / Edit
if ($method == 'update_machine_docs') {
    // Declaration & Initialization
    $id = $_POST['id'];
    $process = $_POST['process'];
    $machine_name = custom_trim($_POST['machine_name']);
    $machine_docs_type = $_POST['machine_docs_type'];

    $is_valid = false;

    // Check All Inputs
    if (!empty($machine_name)) {
        if (!empty($machine_docs_type)) {
            $is_valid = true;
        } else
            echo "Please set Type";
    } else
        echo "Please set Machine Name";

    if ($is_valid == true) {

        // Upload File
        if (!empty($_FILES['file']['name'])) {
            $machine_docs_file = $_FILES['file']['tmp_name'];
            $machine_docs_filename = $_FILES['file']['name'];
            $machine_docs_filetype = $_FILES['file']['type'];
            $machine_docs_size = $_FILES['file']['size'];

            $machine_docs_url = "";
            $target_dir = "";

            switch ($machine_docs_type) {
                case 'WI':
                    //$machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/pm/uploads/machine_docs/wi/";
                    //$target_dir = "../../uploads/machine_docs/wi/";
                    // $machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/machine_docs/wi/";
                    $machine_docs_url = "/uploads/ems/pm/machine_docs/wi/";
                    $target_dir = "../../../../uploads/ems/pm/machine_docs/wi/";
                    break;
                case 'OP-014':
                    //$machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/pm/uploads/machine_docs/op-014/";
                    //$target_dir = "../../uploads/machine_docs/op-014/";
                    // $machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/machine_docs/op-014/";
                    $machine_docs_url = "/uploads/ems/pm/machine_docs/op-014/";
                    $target_dir = "../../../../uploads/ems/pm/machine_docs/op-014/";
                    break;
                case 'RSIR':
                    //$machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/ems/pm/uploads/machine_docs/rsir/";
                    //$target_dir = "../../uploads/machine_docs/rsir/";
                    // $machine_docs_url = "http://".$_SERVER['SERVER_ADDR'].":".$_SERVER['SERVER_PORT']."/uploads/ems/pm/machine_docs/rsir/";
                    $machine_docs_url = "/uploads/ems/pm/machine_docs/rsir/";
                    $target_dir = "../../../../uploads/ems/pm/machine_docs/rsir/";
                    break;
                default:
                    break;
            }

            $target_file = $target_dir . basename($machine_docs_filename);
            $machine_docs_url .= rawurlencode(basename($machine_docs_filename));

            $old_machine_docs_filename = '';

            $sql = "SELECT file_name FROM machine_pm_docs WHERE id = '$id'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $old_machine_docs_filename = $row['file_name'];
                }
            }

            $old_target_file = $target_dir . basename($old_machine_docs_filename);

            $machine_docs_file_info = array(
                'id' => $id,
                'process' => $process,
                'machine_name' => $machine_name,
                'machine_docs_type' => $machine_docs_type,
                'machine_docs_file' => $machine_docs_file,
                'machine_docs_filename' => $machine_docs_filename,
                'machine_docs_filetype' => $machine_docs_filetype,
                'machine_docs_size' => $machine_docs_size,
                'target_file' => $target_file,
                'machine_docs_url' => $machine_docs_url,
                'old_machine_docs_filename' => $old_machine_docs_filename
            );

            // Check Machine Docs File
            $chkMachineDocsFileMsg = check_machine_docs_file($machine_docs_file_info, 'Update', $conn);

            if ($chkMachineDocsFileMsg == '') {

                // Delete Old Uploaded File
                if (file_exists($old_target_file)) {
                    if (!unlink($old_target_file)) {
                        echo "Old Machine Docs File cannot be deleted due to an error!";
                    }
                }

                // Upload File and Check if successfully uploaded
                // Note: Can overwrite existing file
                if (move_uploaded_file($machine_docs_file, $target_file)) {

                    // Update File Information
                    update_machine_docs_info($machine_docs_file_info, $conn);

                } else {
                    echo "Sorry, there was an error uploading your file. Try Again or Contact IT Personnel if it fails again";
                }

            } else {
                echo $chkMachineDocsFileMsg;
            }

        } else {
            $sql = "UPDATE machine_pm_docs SET process = '$process', machine_name = '$machine_name', machine_docs_type = '$machine_docs_type', date_updated = '$date_updated' WHERE id = '$id'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }
    }
}

// Delete
if ($method == 'delete_machine_docs') {
    $id = $_POST['id'];
    $machine_docs_type = '';
    $machine_docs_filename = '';
    $target_dir = '';

    $sql = "SELECT machine_docs_type, file_name FROM machine_pm_docs WHERE id = '$id'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $machine_docs_type = $row['machine_docs_type'];
            $machine_docs_filename = $row['file_name'];
        }
    }

    switch ($machine_docs_type) {
        case 'WI':
            $target_dir = "../../uploads/machine_docs/wi/";
            break;
        case 'OP-014':
            $target_dir = "../../uploads/machine_docs/op-014/";
            break;
        case 'RSIR':
            $target_dir = "../../uploads/machine_docs/rsir/";
            break;
        default:
            break;
    }

    // Delete Uploaded File
    $target_file = $target_dir . basename($machine_docs_filename);

    if (file_exists($target_file)) {
        if (unlink($target_file)) {
            $sql = "DELETE FROM machine_pm_docs WHERE id = '$id'";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } else {
            echo "Machine Docs File cannot be deleted due to an error";
        }
    } else {
        echo "Machine Docs File doesn't exist. ";
    }
}

if ($method == 'download_rsir_format') {
    $machine_name = $_POST['machine_name'];
    $file_url = '';

    $sql = "SELECT file_url FROM machine_pm_docs WHERE machine_name = '$machine_name' AND machine_docs_type = 'RSIR'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            $file_url = $row['file_url'];
        }
    }

    echo $file_url;
}

$conn = null;
