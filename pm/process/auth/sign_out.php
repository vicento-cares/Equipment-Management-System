<?php
session_set_cookie_params(0, "/eems");
session_name("eems");
session_start();

unset($_SESSION['pm_username']);
unset($_SESSION['pm_name']);
unset($_SESSION['pm_role']);
unset($_SESSION['pm_process']);

if (!isset($_SESSION['setup_username']) and !isset($_SESSION['sp_username'])) {
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

if (isset($_COOKIE['pm_name'])) {
    $name = null;
    setcookie('pm_name', $name, 0, "/eems");
}
if (isset($_COOKIE['pm_role'])) {
    $role = null;
    setcookie('pm_role', $role, 0, "/eems");
}
if (isset($_COOKIE['pm_process'])) {
    $pm_process = null;
    setcookie('pm_process', $pm_process, 0, "/eems");
}

header('location:../../../login/');
