<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

unset($_SESSION['sp_username']);
unset($_SESSION['sp_name']);
unset($_SESSION['sp_role']);
unset($_SESSION['sp_approver_role']);
unset($_SESSION['sp_process']);

if (!isset($_SESSION['pm_username']) AND !isset($_SESSION['setup_username'])) {
    session_unset();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}

if(isset($_COOKIE['sp_name'])) {
    $name = null;
    setcookie('sp_name', $name, 0, "/ems");
}
if(isset($_COOKIE['sp_role'])) {
    $role = null;
    setcookie('sp_role', $role, 0, "/ems");
}
if(isset($_COOKIE['sp_process'])) {
    $sp_process = null;
    setcookie('sp_process', $sp_process, 0, "/ems");
}

header('location:../../../login/');
?>