<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');
require('../lib/validate.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');

if ($method == 'fetch_machines_datalist_search') {
    $sql = "SELECT machine_name FROM m_machines ORDER BY machine_name ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['machine_name']) . '">';
    }
}

if ($method == 'fetch_machine_no_datalist') {
    $sql = "SELECT machine_no FROM m_machine_masterlist WHERE machine_no != '' ORDER BY machine_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['machine_no']) . '">';
    }
}

if ($method == 'fetch_equipment_no_datalist') {
    $sql = "SELECT equipment_no FROM m_machine_masterlist WHERE equipment_no != '' ORDER BY equipment_no ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . htmlspecialchars($row['equipment_no']) . '">';
    }
}

$conn = null;
