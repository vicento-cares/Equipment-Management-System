<?php
session_set_cookie_params(0, "/eems");
session_name("eems");
session_start();

if (!isset($_SESSION['setup_username'])) {
  header('location:../../login/');
  exit();
} else {
  if ($_SESSION['setup_approver_role'] == "1") {
    header('location:../approver1/home.php');
    exit();
  } else if ($_SESSION['setup_approver_role'] == "2") {
    header('location:../approver2/home.php');
    exit();
  } else if ($_SESSION['setup_approver_role'] == "N/A") {
    header('location:../admin/home.php');
    exit();
  }
  if(!isset($_COOKIE['setup_name'])) {
    $name = $_SESSION['setup_name'];
    setcookie('setup_name', $name, 0, "/eems");
  }
  if(!isset($_COOKIE['setup_role'])) {
    $role = $_SESSION['setup_role'];
    setcookie('setup_role', $role, 0, "/eems");
  }
  if(!isset($_COOKIE['setup_process'])) {
    $setup_process = $_SESSION['setup_process'];
    setcookie('setup_process', $setup_process, 0, "/eems");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">