<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];

// Get Car Model Dropdown
if ($method == 'fetch_car_model_dropdown') {
    $sql = "SELECT car_model FROM m_car_models ORDER BY car_model ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option disabled selected value="">Select Car Model</option>';
        do {
            echo '<option value="' . htmlspecialchars($row['car_model']) . '">' . htmlspecialchars($row['car_model']) . '</option>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<option disabled selected value="">Select Car Model</option>';
    }
}

// Get Car Model Dropdown
if ($method == 'fetch_car_model_dropdown_search') {
    $sql = "SELECT car_model FROM m_car_models ORDER BY car_model ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option selected value="All">All Car Models</option>';
        do {
            echo '<option value="' . htmlspecialchars($row['car_model']) . '">' . htmlspecialchars($row['car_model']) . '</option>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<option selected value="All">All Car Models</option>';
    }
}

// Get Car Model Datalist
if ($method == 'fetch_car_model_datalist') {
    $process = $_POST['process'];
    $sql = "SELECT car_model ";
    if ($process == 'Initial') {
        $sql = $sql . "FROM m_line_no_initial GROUP BY car_model ORDER BY car_model ASC";
    } else if ($process == 'Final') {
        $sql = $sql . "FROM m_line_no_final ORDER BY car_model ASC";
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row['car_model'] . '">';
    }
}

if ($method == 'fetch_car_model_datalist_search') {
    $sql = "SELECT car_model FROM m_line_no_initial GROUP BY car_model ORDER BY car_model ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row['car_model'] . '">';
    }

    $sql = "SELECT car_model FROM m_line_no_final ORDER BY car_model ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row['car_model'] . '">';
    }
}

if ($method == 'get_car_model_details') {
    $car_model = $_POST['car_model'];
    $location = '';

    if (!empty($car_model)) {
        $sql = "SELECT car_model, location FROM m_line_no_final WHERE car_model = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$car_model]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $car_model = $row['car_model'];
            $location = $row['location'];
        }
    }

    $response_arr = array(
        'car_model' => $car_model,
        'location' => $location
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

$conn = null;
