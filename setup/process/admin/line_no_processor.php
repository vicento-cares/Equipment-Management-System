<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];

// Get Line No Datalist
if ($method == 'fetch_line_datalist') {
    $process = $_POST['process'];
    $sql = "SELECT line_no ";
    if ($process == 'Initial') {
        $sql = $sql . "FROM line_no_initial GROUP BY line_no ORDER BY line_no ASC";
    } else if ($process == 'Final') {
        $sql = $sql . "FROM line_no_final ORDER BY line_no ASC";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . $row['line_no'] . '">';
        }
    }
}

if ($method == 'fetch_line_datalist_search') {
    $sql = "SELECT line_no FROM line_no_initial GROUP BY line_no ORDER BY line_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . $row['line_no'] . '">';
        }
    }

    $sql = "SELECT line_no FROM line_no_final ORDER BY line_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . $row['line_no'] . '">';
        }
    }
}

if ($method == 'get_line_no_details') {
    $line_no = $_POST['line_no'];
    $car_model = '';
    $location = '';

    if (!empty($line_no)) {
        $line_no = addslashes($line_no);
        $sql = "SELECT line_no, car_model, location FROM line_no_final WHERE line_no = '$line_no'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $line_no = $row['line_no'];
                $car_model = $row['car_model'];
                $location = $row['location'];
            }
        }
    }

    $response_arr = array(
        'line_no' => $line_no,
        'car_model' => $car_model,
        'location' => $location
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

$conn = null;
