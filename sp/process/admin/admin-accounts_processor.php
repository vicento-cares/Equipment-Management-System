<?php
// Processor
date_default_timezone_set('Asia/Manila');
session_set_cookie_params(0, "/eems");
session_name("eems");
session_start();
require('../db/conn.php');
require('../lib/validate.php');

if (!isset($_POST['method'])) {
    echo 'method not set';
    exit();
}
$method = $_POST['method'];
$date_updated = date('Y-m-d H:i:s');

function check_existing_username($username, $conn)
{
    $sql = "SELECT username FROM m_machine_sp_accounts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return true;
    } else {
        return false;
    }
}

function check_own_username($id, $own_username, $conn)
{
    $sql = "SELECT username FROM m_machine_sp_accounts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        if ($own_username == $row['username']) {
            return true;
        } else {
            return false;
        }
    }
}

function change_username($id, $username, $date_updated, $conn)
{
    $sql = "SELECT username FROM m_machine_sp_accounts WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        $sql = "UPDATE m_machine_sp_accounts SET username = ?, date_updated = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$username, $date_updated, $id]);
        return true;
    } else {
        return false;
    }
}

// Count
if ($method == 'count_data') {
    $search = $_POST['search'];
    $sql = "SELECT COUNT(id) AS total FROM m_machine_sp_accounts";
    $params = [];
    if (!empty($search)) {
        $sql = $sql . " WHERE username LIKE ? OR name LIKE ? OR role LIKE ? OR process LIKE ?";
        $params = [
            $search . "%",
            $search . "%",
            $search . "%",
            $search . "%"
        ];
    }
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['total'];
    }
}

// Read / Load
if ($method == 'fetch_data') {
    $id = $_POST['id'];
    $search = $_POST['search'];
    $c = $_POST['c'];
    $own_username = $_SESSION['sp_username'];
    $own_role = $_COOKIE['sp_role'];
    $own_name = $_COOKIE['sp_name'];
    $row_class_arr = array('modal-trigger', 'modal-trigger bg-lime');
    $row_class = $row_class_arr[0];

    $sql = "SELECT TOP 10 id, username, password, name, role, process, date_updated FROM m_machine_sp_accounts";
    $params = [];

    if (!empty($id) && empty($search)) {
        $sql = $sql . " WHERE id > ?";
        $params[] = $id;
    } else if (empty($id) && !empty($search)) {
        $sql = $sql . " WHERE username LIKE ? OR name LIKE ? OR role LIKE ? OR process LIKE ?";
        $params = [
            $search . "%",
            $search . "%",
            $search . "%",
            $search . "%"
        ];
    } else if (!empty($id) && !empty($search)) {
        $sql = $sql . " WHERE id > ? AND (username LIKE ? OR name LIKE ? OR role LIKE ? OR process LIKE ?)";
        $params = [
            $id,
            $search . "%",
            $search . "%",
            $search . "%",
            $search . "%"
        ];
    }
    $sql = $sql . " ORDER BY id ASC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        do {
            $c++;
            if ($own_username == $row['username'] && $own_name == $row['name'] && $own_role == $row['role']) {
                $row_class = $row_class_arr[1];
            } else {
                $row_class = $row_class_arr[0];
            }
            echo '<tr style="cursor:pointer;" class="' . $row_class . '" id="' . $row['id'] . '" data-toggle="modal" data-target="#AccountInfoModal" data-id="' . $row['id'] . '" data-username="' . htmlspecialchars($row['username']) . '" data-name="' . htmlspecialchars($row['name']) . '" data-role="' . $row['role'] . '" data-process="' . $row['process'] . '" data-date_updated="' . $row['date_updated'] . '" onclick="get_details(this)">';
            echo '<td>' . $c . '</td>';
            echo '<td>' . htmlspecialchars($row['username']) . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . $row['role'] . '</td>';
            echo '<td>' . $row['process'] . '</td>';
            echo '<td>' . date("Y-m-d h:iA", strtotime($row['date_updated'])) . '</td>';
            echo '</tr>';
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
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
                    } else
                        echo 'Process Not Set';
                } else
                    echo 'Role Not Set';
            } else
                echo 'Invalid Name';
        } else
            echo 'Invalid Password';
    } else
        echo 'Invalid Username';

    if ($is_valid == true) {
        if ($own_role == 'Admin') {
            $is_existing = check_existing_username($username, $conn);
            if ($is_existing == false) {
                $sql = "INSERT INTO m_machine_sp_accounts (username, password, name, role, process, date_updated) 
                        VALUES (?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->execute([
                    $username,
                    $password,
                    $name,
                    $role,
                    $process,
                    $date_updated
                ]);
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
            $sql = "UPDATE m_machine_sp_accounts SET password = ?, date_updated = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$password, $date_updated, $id]);
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
            } else
                echo 'Process Not Set';
        } else
            echo 'Role Not Set';
    } else
        echo 'Invalid Name';

    if ($is_valid == true) {
        $is_own_username = check_own_username($id, $own_username, $conn);
        if ($own_role == 'Admin') {
            if ($is_own_username == true && $role != 'Admin') {
                echo 'Own Account';
            } else {
                $sql = "UPDATE m_machine_sp_accounts SET name = ?, role = ?, process = ?, date_updated = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $role, $process, $date_updated, $id]);
                if ($is_own_username == true) {
                    setcookie('sp_name', $name, 0, "/eems");
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
                $sql = "UPDATE m_machine_sp_accounts SET name = ?, date_updated = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name, $date_updated, $id]);
                if ($is_own_username == true) {
                    setcookie('sp_name', $name, 0, "/eems");
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
            $sql = "DELETE FROM m_machine_sp_accounts WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$id]);
            echo 'success';
        } else {
            echo 'Unauthorized Access';
        }
    } else {
        echo 'Own Account';
    }
}

$conn = null;
