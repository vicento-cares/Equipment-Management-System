<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];

// Get Factory Area Dropdown
if ($method == 'fetch_location_dropdown') {
    $sql = "SELECT location FROM m_locations ORDER BY location ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        echo '<option disabled selected value="">Select Location</option>';
        do {
            echo '<option value="' . htmlspecialchars($row['location']) . '">' . htmlspecialchars($row['location']) . '</option>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
    } else {
        echo '<option disabled selected value="">Select Location</option>';
    }
}

if ($method == 'fetch_location_datalist_search') {
    $sql = "SELECT location FROM m_locations ORDER BY location ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row['location'] . '">';
    }
}

$conn = null;
