<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

require('../db/conn.php');

if (!isset($_POST['username']) && !isset($_POST['password'])) {
    echo 'not set';
} else if (empty($_POST['username']) || empty($_POST['password'])) {
    echo 'empty';
} else {
    $username = addslashes($_POST['username']);
    $password = addslashes($_POST['password']);

    $sql = "SELECT username, name, role, approver_role, process FROM machine_setup_accounts WHERE username = BINARY convert('$username' using utf8mb4) collate utf8mb4_bin AND password = BINARY convert('$password' using utf8mb4) collate utf8mb4_bin";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['setup_username'] = $row['username'];
            $_SESSION['setup_name'] = $row['name'];
            $_SESSION['setup_role'] = $row['role'];
            $_SESSION['setup_approver_role'] = $row['approver_role'];
            $_SESSION['setup_process'] = $row['process'];
        }
        setcookie('setup_name', $_SESSION['setup_name'], 0, "/ems");
        setcookie('setup_role', $_SESSION['setup_role'], 0, "/ems");
        setcookie('setup_approver_role', $_SESSION['setup_approver_role'], 0, "/ems");
        setcookie('setup_process', $_SESSION['setup_process'], 0, "/ems");
        echo 'success';
    } else {
        echo 'failed';
    }
}

$conn = null;
