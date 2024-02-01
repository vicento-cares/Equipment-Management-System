<?php 
// Processor
date_default_timezone_set('Asia/Manila');
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();
require('../db/conn.php');
require('../lib/validate.php');

if (!isset($_POST['method'])) {
	echo 'method not set';
	exit;
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');

function check_existing_username($username, $conn) {
	$username = addslashes($username);
	$sql = "SELECT `username` FROM `machine_sp_accounts` WHERE username = '$username'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		return true;
	} else {
		return false;
	}
}

function check_own_username($id, $own_username, $conn) {
	$sql = "SELECT `username` FROM `machine_sp_accounts` WHERE id = '$id'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
		if ($own_username == $row['username']) {
			return true;
		} else {
			return false;
		}
	}
}

function change_username($id, $username, $date_updated, $conn) {
	$username = addslashes($username);
	$sql = "SELECT `username` FROM `machine_sp_accounts` WHERE username = '$username'";
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() <= 0) {
		$sql = "UPDATE `machine_sp_accounts` SET `username`= '$username', `date_updated`= '$date_updated' WHERE id = '$id'";
		$stmt = $conn -> prepare($sql);
		$stmt -> execute();
		return true;
	} else {
		return false;
	}
}

// Count
if ($method == 'count_data') {
	$search = addslashes($_POST['search']);
	$sql = "SELECT count(id) AS total FROM `machine_sp_accounts`";
	if (!empty($search)) {
		$sql = $sql . " WHERE username LIKE '$search%' OR name LIKE '$search%' OR role LIKE '$search%' OR process LIKE '$search%'";
	}
	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
			echo $row['total'];
		}
	}
}

// Read / Load
if ($method == 'fetch_data') {
	$id = $_POST['id'];
	$search = addslashes($_POST['search']);
	$c = $_POST['c'];
	$own_username = $_SESSION['sp_username'];
	$own_role = $_COOKIE['sp_role'];
	$own_name = $_COOKIE['sp_name'];
	$row_class_arr = array('modal-trigger', 'modal-trigger bg-lime');
	$row_class = $row_class_arr[0];
	$sql = "SELECT `id`, `username`, `password`, `name`, `role`, `process`, `date_updated` FROM `machine_sp_accounts`";

	if (!empty($id) && empty($search)) {
		$sql = $sql . " WHERE id > '$id'";
	} else if (empty($id) && !empty($search)) {
		$sql = $sql . " WHERE username LIKE '$search%' OR name LIKE '$search%' OR role LIKE '$search%' OR process LIKE '$search%'";
	} else if (!empty($id) && !empty($search)) {
		$sql = $sql . " WHERE id > '$id' AND (username LIKE '$search%' OR name LIKE '$search%' OR role LIKE '$search% OR process LIKE '$search%'')";
	}
	$sql = $sql . " ORDER BY id ASC LIMIT 10";

	$stmt = $conn -> prepare($sql);
	$stmt -> execute();
	if ($stmt -> rowCount() > 0) {
		foreach($stmt -> fetchAll() as $row) {
			$c++;
			if ($own_username == $row['username'] && $own_name == $row['name'] && $own_role == $row['role']) {
				$row_class = $row_class_arr[1];
			} else {
				$row_class = $row_class_arr[0];
			}
			echo '<tr style="cursor:pointer;" class="'.$row_class.'" id="'.$row['id'].'" data-toggle="modal" data-target="#AccountInfoModal" data-id="'.$row['id'].'" data-username="'.htmlspecialchars($row['username']).'" data-name="'.htmlspecialchars($row['name']).'" data-role="'.$row['role'].'" data-process="'.$row['process'].'" data-date_updated="'.$row['date_updated'].'" onclick="get_details(this)">';
			echo '<td>'.$c.'</td>';
			echo '<td>'.htmlspecialchars($row['username']).'</td>';
			echo '<td>'.htmlspecialchars($row['name']).'</td>';
			echo '<td>'.$row['role'].'</td>';
			echo '<td>'.$row['process'].'</td>';
			echo '<td>'.date("Y-m-d h:iA", strtotime($row['date_updated'])).'</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '<td colspan="6" style="text-align:center; color:red;">No Results Found</td>';
		echo '</tr>';
	}
}

// Create / Insert
if ($method == 'save_data') {
	$username = custom_trim($_POST['username']);
	$password = $_POST['password'];
	$name = custom_trim($_POST['name']);
	$role = $_POST['role'];
	$process = $_POST['process'];
	$own_role = $_COOKIE['sp_role'];

	$is_valid = false;
	$is_valid_username = validate_username($username);
	$is_valid_password = validate_password($password);
	$is_valid_name = validate_name($name);
	if ($is_valid_username == true) {
		if ($is_valid_password == true) {
			if ($is_valid_name == true) {
				if ($role != '') {
					if ($process != '') {
						$is_valid = true;
					} else echo 'Process Not Set';
				} else echo 'Role Not Set';
			} else echo 'Invalid Name';
		} else echo 'Invalid Password';
	} else echo 'Invalid Username';

	if ($is_valid == true) {
		if ($own_role == 'Admin') {
			$is_existing = check_existing_username($username, $conn);
			if ($is_existing == false) {
				$username = addslashes($username);
				$password = addslashes($password);
				$name = addslashes($name);
				$sql = "INSERT INTO `machine_sp_accounts` (`username`, `password`, `name`, `role`, `process`, `date_updated`) VALUES ('$username', '$password', '$name', '$role', '$process', '$date_updated')";
				$stmt = $conn -> prepare($sql);
				$stmt -> execute();
				echo 'success';
			} else {
				echo 'Username Exists';
			}
		} else {
			echo 'Unauthorized Access';
		}
	}
}

// Update / Edit
if ($method == 'update_username') {
	$id = $_POST['id'];
	$username = custom_trim($_POST['username']);
	$own_username = $_SESSION['sp_username'];
	$own_role = $_COOKIE['sp_role'];

	$is_valid_username = validate_username($username);
	if ($is_valid_username == true) {
		$is_own_username = check_own_username($id, $own_username, $conn);
		if ($own_role != 'Admin' && $is_own_username == false) {
			echo 'Unauthorized Access';
		} else {
			$is_changed = change_username($id, $username, $date_updated, $conn);
			if ($is_changed == true) {
				if ($is_own_username == true) {
					$_SESSION['sp_username'] = $username;
				}
				echo 'success';
			} else {
				echo 'Username Exists';
			}
		}
	} else {
		echo 'Invalid Username';
	}
}

// Update / Edit
if ($method == 'update_password') {
	$id = $_POST['id'];
	$password = $_POST['password'];
	$own_username = $_SESSION['sp_username'];
	$own_role = $_COOKIE['sp_role'];

	$is_valid_password = validate_password($password);

	if ($is_valid_password == true) {
		$is_own_username = check_own_username($id, $own_username, $conn);
		if ($own_role != 'Admin' && $is_own_username == false) {
			echo 'Unauthorized Access';
		} else {
			$password = addslashes($password);
			$sql = "UPDATE `machine_sp_accounts` SET `password`= '$password', `date_updated`= '$date_updated' WHERE id = '$id'";
			$stmt = $conn -> prepare($sql);
			$stmt -> execute();
			echo 'success';
		}
	} else {
		echo 'Invalid Password';
	}
}

// Update / Edit
if ($method == 'update_data') {
	$id = $_POST['id'];
	$name = custom_trim($_POST['name']);
	$role = $_POST['role'];
	$process = $_POST['process'];
	$own_username = $_SESSION['sp_username'];
	$own_role = $_COOKIE['sp_role'];

	$is_valid = false;
	$is_valid_name = validate_name($name);
	
	if ($is_valid_name == true) {
		if ($role != '') {
			if ($process != '') {
				$is_valid = true;
			} else echo 'Process Not Set';
		} else echo 'Role Not Set';
	} else echo 'Invalid Name';

	if ($is_valid == true) {
		$is_own_username = check_own_username($id, $own_username, $conn);
		if ($own_role == 'Admin') {
			if ($is_own_username == true && $role != 'Admin') {
				echo 'Own Account';
			} else {
				$name = addslashes($name);
				$sql = "UPDATE `machine_sp_accounts` SET `name`= '$name', `role`= '$role', `process`= '$process', `date_updated`= '$date_updated' WHERE `id`= '$id'";
				$stmt = $conn -> prepare($sql);
				$stmt -> execute();
				if ($is_own_username == true) {
					setcookie('sp_name', $name, 0, "/ems");
					$_SESSION['sp_name'] = $name;
				}
				echo 'success';
			}
		} else {
			if ($role == 'Admin') {
				echo 'Unauthorized Access';
			} else if ($is_own_username == false) {
				echo 'Unauthorized Access';
			} else {
				$name = addslashes($name);
				$sql = "UPDATE `machine_sp_accounts` SET `name`= '$name', `date_updated`= '$date_updated' WHERE `id`= '$id'";
				$stmt = $conn -> prepare($sql);
				$stmt -> execute();
				if ($is_own_username == true) {
					setcookie('sp_name', $name, 0, "/ems");
				}
				echo 'success';
			}
		}
	}
}

// Delete
if ($method == 'delete_data') {
	$id = $_POST['id'];
	$own_username = $_SESSION['sp_username'];
	$own_role = $_COOKIE['sp_role'];

	$is_own_username = check_own_username($id, $own_username, $conn);

	if ($is_own_username == false) {
		if ($own_role == 'Admin') {
			$sql = "DELETE FROM `machine_sp_accounts` WHERE id = '$id'";
			$stmt = $conn -> prepare($sql);
			$params = array($id);
			$stmt -> execute($params);
			echo 'success';
		} else {
			echo 'Unauthorized Access';
		}
	} else {
		echo 'Own Account';
	}
}

$conn = null;
?>