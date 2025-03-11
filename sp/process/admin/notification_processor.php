<?php
// Processor
date_default_timezone_set('Asia/Manila');
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];

if ($method == 'count_notif_sp') {
    $new_pm_concerns = 0;
    $pending_mstprc = 0;

    $sql = "SELECT new_pm_concerns FROM notif_pm_no_spare WHERE interface = 'ADMIN-SP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $new_pm_concerns = intval($row['new_pm_concerns']);
        }
    }

    $sql = "SELECT pending_mstprc FROM notif_setup_approvers WHERE interface = 'APPROVER-2-EQ-SP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pending_mstprc = intval($row['pending_mstprc']);
        }
    }

    $total = $new_pm_concerns + $pending_mstprc;

    $response_arr = array(
        'new_pm_concerns' => $new_pm_concerns,
        'pending_mstprc' => $pending_mstprc,
        'total' => $total
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'update_notif_new_pm_concerns') {
    $sql = "UPDATE notif_pm_no_spare SET new_pm_concerns = 0 WHERE interface = 'ADMIN-SP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

if ($method == 'update_notif_pending_mstprc') {
    $sql = "UPDATE notif_setup_approvers SET pending_mstprc = 0 WHERE interface = 'APPROVER-2-EQ-SP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

$conn = null;
