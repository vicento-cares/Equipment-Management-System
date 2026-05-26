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
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT username, name, role, approver_role, process 
            FROM m_machine_sp_accounts 
            WHERE username = ? COLLATE SQL_Latin1_General_CP1_CS_AS AND 
            password = ? COLLATE SQL_Latin1_General_CP1_CS_AS";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        do {
            $_SESSION['sp_username'] = $row['username'];
            $_SESSION['sp_name'] = $row['name'];
            $_SESSION['sp_role'] = $row['role'];
            $_SESSION['sp_approver_role'] = $row['approver_role'];
            $_SESSION['sp_process'] = $row['process'];
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
        setcookie('sp_name', $_SESSION['sp_name'], 0, "/ems");
        setcookie('sp_role', $_SESSION['sp_role'], 0, "/ems");
        setcookie('sp_process', $_SESSION['sp_process'], 0, "/ems");
        echo 'success';
    } else {
        echo 'failed';
    }
}

$conn = null;
