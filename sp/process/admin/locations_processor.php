<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];

if ($method == 'fetch_location_datalist_search') {
    $sql = "SELECT location FROM m_locations ORDER BY location ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="' . $row['location'] . '">';
    }
}

$conn = null;
