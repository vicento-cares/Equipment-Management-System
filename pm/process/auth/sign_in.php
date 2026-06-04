<?php
session_set_cookie_params(0, "/eems");
session_name("eems");
session_start();

require('../db/conn.php');

if (!isset($_POST['username']) && !isset($_POST['password'])) {
    echo 'not set';
} else if (empty($_POST['username']) || empty($_POST['password'])) {
    echo 'empty';
} else {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT username, name, role, process FROM m_machine_pm_accounts 
            WHERE username = ? COLLATE SQL_Latin1_General_CP1_CS_AS AND 
            password = ? COLLATE SQL_Latin1_General_CP1_CS_AS";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username, $password]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        do {
            $_SESSION['pm_username'] = $row['username'];
            $_SESSION['pm_name'] = $row['name'];
            $_SESSION['pm_role'] = $row['role'];
            $_SESSION['pm_process'] = $row['process'];
        } while ($row = $stmt->fetch(PDO::FETCH_ASSOC));
        
        setcookie('pm_name', $_SESSION['pm_name'], 0, "/eems");
        setcookie('pm_role', $_SESSION['pm_role'], 0, "/eems");
        setcookie('pm_process', $_SESSION['pm_process'], 0, "/eems");
        echo 'success';
    } else {
        echo 'failed';
    }
}

$conn = null;
