<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit;
}
$method = $_POST['method'];

// Get Factory Area Dropdown
if ($method == 'fetch_location_dropdown') {
    $sql = "SELECT location FROM locations ORDER BY location ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        echo '<option disabled selected value="">Select Location</option>';
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . htmlspecialchars($row['location']) . '">' . htmlspecialchars($row['location']) . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Select Location</option>';
    }
}

if ($method == 'fetch_location_datalist_search') {
    $sql = "SELECT location FROM locations ORDER BY location ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        foreach ($stmt->fetchAll() as $row) {
            echo '<option value="' . $row['location'] . '">';
        }
    }
}

$conn = null;
