<?php
// Processor
date_default_timezone_set('Asia/Manila');
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();
require('../db/conn.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];

if ($method == 'count_notif_setup') {
    $new_act_sched = 0;
    $approved_mstprc = 0;
    $disapproved_mstprc = 0;

    $sql = "SELECT new_act_sched FROM notif_setup_activities WHERE interface = 'ADMIN-SETUP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $new_act_sched = intval($row['new_act_sched']);
        }
    }
    $sql = "SELECT approved_mstprc FROM notif_setup_approvers WHERE interface = 'ADMIN-SETUP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $approved_mstprc = intval($row['approved_mstprc']);
        }
    }
    $sql = "SELECT disapproved_mstprc FROM notif_setup_approvers WHERE interface = 'ADMIN-SETUP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $disapproved_mstprc = intval($row['disapproved_mstprc']);
        }
    }

    $total = $new_act_sched + $approved_mstprc + $disapproved_mstprc;

    $response_arr = array(
        'new_act_sched' => $new_act_sched,
        'approved_mstprc' => $approved_mstprc,
        'disapproved_mstprc' => $disapproved_mstprc,
        'total' => $total
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'count_notif_public_act_sched') {
    $accepted_act_sched = 0;
    $declined_act_sched = 0;
    $total = 0;
    $sql = "SELECT accepted_act_sched, declined_act_sched FROM notif_setup_activities WHERE interface = 'PUBLIC-PAGE'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accepted_act_sched = intval($row['accepted_act_sched']);
            $declined_act_sched = intval($row['declined_act_sched']);
        }
    }
    $total = $accepted_act_sched + $declined_act_sched;

    $response_arr = array(
        'accepted_act_sched' => $accepted_act_sched,
        'declined_act_sched' => $declined_act_sched,
        'total' => $total
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'count_notif_pending_mstprc') {
    $setup_role = $_SESSION['setup_role'];
    $interface = '';
    switch ($setup_role) {
        case 'Safety':
            $interface = 'APPROVER-1-SAFETY';
            break;
        case 'EQ Manager':
            $interface = 'APPROVER-2-EQ-MGT';
            break;
        case 'Production Engineering Manager':
            $interface = 'APPROVER-2-PROD-ENGR-MGT';
            break;
        case 'Production Supervisor':
            $interface = 'APPROVER-2-PROD-SV';
            break;
        case 'Production Manager':
            $interface = 'APPROVER-2-PROD-MGT';
            break;
        case 'QA Supervisor':
            $interface = 'APPROVER-2-QA-SV';
            break;
        case 'QA Manager':
            $interface = 'APPROVER-2-QA-MGT';
            break;
        default:
            break;
    }
    if (!empty($interface)) {
        $sql = "SELECT pending_mstprc FROM notif_setup_approvers WHERE interface = '$interface'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo intval($row['pending_mstprc']);
            }
        }
    }
}

if ($method == 'update_notif_new_act_sched') {
    $sql = "UPDATE notif_setup_activities SET new_act_sched = 0 WHERE interface = 'ADMIN-SETUP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

if ($method == 'update_notif_approved_mstprc') {
    $sql = "UPDATE notif_setup_approvers SET approved_mstprc = 0 WHERE interface = 'ADMIN-SETUP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

if ($method == 'update_notif_disapproved_mstprc') {
    $sql = "UPDATE notif_setup_approvers SET disapproved_mstprc = 0 WHERE interface = 'ADMIN-SETUP'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

if ($method == 'update_notif_public_act_sched') {
    $sql = "UPDATE notif_setup_activities SET accepted_act_sched = 0, declined_act_sched = 0 WHERE interface = 'PUBLIC-PAGE'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
}

if ($method == 'update_notif_pending_mstprc') {
    $setup_role = $_SESSION['setup_role'];
    $interface = '';
    switch ($setup_role) {
        case 'Safety':
            $interface = 'APPROVER-1-SAFETY';
            break;
        case 'EQ Manager':
            $interface = 'APPROVER-2-EQ-MGT';
            break;
        case 'Production Engineering Manager':
            $interface = 'APPROVER-2-PROD-ENGR-MGT';
            break;
        case 'Production Supervisor':
            $interface = 'APPROVER-2-PROD-SV';
            break;
        case 'Production Manager':
            $interface = 'APPROVER-2-PROD-MGT';
            break;
        case 'QA Supervisor':
            $interface = 'APPROVER-2-QA-SV';
            break;
        case 'QA Manager':
            $interface = 'APPROVER-2-QA-MGT';
            break;
        default:
            break;
    }
    if (!empty($interface)) {
        $sql = "UPDATE notif_setup_approvers SET pending_mstprc = 0 WHERE interface = '$interface'";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
    }
}

$conn = null;
