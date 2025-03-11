<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

unset($_SESSION['setup_username']);
unset($_SESSION['setup_name']);
unset($_SESSION['setup_role']);
unset($_SESSION['setup_approver_role']);
unset($_SESSION['setup_process']);

if (!isset($_SESSION['pm_username']) and !isset($_SESSION['sp_username'])) {
    session_unset();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}

if (isset($_COOKIE['setup_approver_role'])) {
    $setup_approver_role = null;
    setcookie('setup_approver_role', $setup_approver_role, 0, "/ems");
}

if (isset($_COOKIE['setup_name'])) {
    $name = null;
    setcookie('setup_name', $name, 0, "/ems");
}
if (isset($_COOKIE['setup_role'])) {
    $role = null;
    setcookie('setup_role', $role, 0, "/ems");
}
if (isset($_COOKIE['setup_process'])) {
    $setup_process = null;
    setcookie('setup_process', $setup_process, 0, "/ems");
}

header('location:../../../login/');
