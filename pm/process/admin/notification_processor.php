<?php 
// Processor
date_default_timezone_set('Asia/Manila');
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();
require('../db/conn.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];

if ($method == 'count_notif_pm') {
	$new_pm_concerns = 0;
	$approved_rsir = 0;
	$disapproved_rsir = 0;

	$sql = "SELECT new_pm_concerns FROM notif_pm_concerns WHERE interface = 'ADMIN-PM'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$new_pm_concerns = intval($row['new_pm_concerns']);
		}
	}
	$sql = "SELECT approved_rsir FROM notif_pm_approvers WHERE interface = 'ADMIN-PM'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$approved_rsir = intval($row['approved_rsir']);
		}
	}
	$sql = "SELECT disapproved_rsir FROM notif_pm_approvers WHERE interface = 'ADMIN-PM'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$disapproved_rsir = intval($row['disapproved_rsir']);
		}
	}

	$total = $new_pm_concerns + $approved_rsir + $disapproved_rsir;

	$response_arr = array(
        'new_pm_concerns' => $new_pm_concerns,
        'approved_rsir' => $approved_rsir,
        'disapproved_rsir' => $disapproved_rsir,
        'total' => $total
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'count_notif_pending_rsir') {
	$pm_role = $_SESSION['pm_role'];
	$interface = '';
	switch ($pm_role) {
		case 'Prod':
			$interface = 'APPROVER-PROD-MGT';
			break;
		case 'QA':
			$interface = 'APPROVER-QA-MGT';
			break;
		default:
			break;
	}
	if (!empty($interface)) {
		$sql = "SELECT pending_rsir FROM notif_pm_approvers WHERE interface = '$interface'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		if ($stmt -> rowCount() > 0) {
			while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
				echo intval($row['pending_rsir']);
			}
		}
	}
}

if ($method == 'count_notif_new_pm_concerns') {
	$sql = "SELECT new_pm_concerns FROM notif_pm_concerns WHERE interface = 'ADMIN-PM'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo intval($row['new_pm_concerns']);
		}
	}
}

if ($method == 'count_notif_public_pm_concerns') {
	$done_pm_concerns = 0;
	$pending_pm_concerns = 0;
	$total = 0;
	$sql = "SELECT done_pm_concerns, pending_pm_concerns FROM notif_pm_concerns WHERE interface = 'PUBLIC-PAGE'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			$done_pm_concerns = intval($row['done_pm_concerns']);
			$pending_pm_concerns = intval($row['pending_pm_concerns']);
		}
	}
	$total = $done_pm_concerns + $pending_pm_concerns;

	$response_arr = array(
        'done_pm_concerns' => $done_pm_concerns,
        'pending_pm_concerns' => $pending_pm_concerns,
        'total' => $total
    );

    echo json_encode($response_arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

if ($method == 'update_notif_new_pm_concerns') {
	$sql = "UPDATE notif_pm_concerns SET new_pm_concerns = 0 WHERE interface = 'ADMIN-PM'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

if ($method == 'update_notif_approved_rsir') {
	$sql = "UPDATE notif_pm_approvers SET approved_rsir = 0 WHERE interface = 'ADMIN-PM'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

if ($method == 'update_notif_disapproved_rsir') {
	$sql = "UPDATE notif_pm_approvers SET disapproved_rsir = 0 WHERE interface = 'ADMIN-PM'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

if ($method == 'update_notif_pending_rsir') {
	$pm_role = $_SESSION['pm_role'];
	$interface = '';
	switch ($pm_role) {
		case 'Prod':
			$interface = 'APPROVER-PROD-MGT';
			break;
		case 'QA':
			$interface = 'APPROVER-QA-MGT';
			break;
		default:
			break;
	}
	if (!empty($interface)) {
		$sql = "UPDATE notif_pm_approvers SET pending_rsir = 0 WHERE interface = '$interface'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
	}
}

if ($method == 'update_notif_public_pm_concerns') {
	$sql = "UPDATE notif_pm_concerns SET done_pm_concerns = 0, pending_pm_concerns = 0 WHERE interface = 'PUBLIC-PAGE'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
}

$conn = null;
?>