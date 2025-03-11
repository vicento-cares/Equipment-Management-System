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

    $sql = "SELECT username, name, role, approver_role, process FROM machine_sp_accounts WHERE username = BINARY convert('$username' using utf8mb4) collate utf8mb4_bin AND password = BINARY convert('$password' using utf8mb4) collate utf8mb4_bin";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['sp_username'] = $row['username'];
            $_SESSION['sp_name'] = $row['name'];
            $_SESSION['sp_role'] = $row['role'];
            $_SESSION['sp_approver_role'] = $row['approver_role'];
            $_SESSION['sp_process'] = $row['process'];
        }
        setcookie('sp_name', $_SESSION['sp_name'], 0, "/ems");
        setcookie('sp_role', $_SESSION['sp_role'], 0, "/ems");
        setcookie('sp_process', $_SESSION['sp_process'], 0, "/ems");
        echo 'success';
    } else {
        echo 'failed';
    }
}

$conn = null;
