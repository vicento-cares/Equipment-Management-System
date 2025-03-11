<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['pm_username'])) {
  header('location:../../login/');
  exit();
} else {
  if ($_SESSION['pm_role'] == "QA") {
    header('location:../qa/home.php');
    exit();
  } else if ($_SESSION['pm_role'] == "Admin") {
    header('location:../admin/home.php');
    exit();
  }
  if(!isset($_COOKIE['pm_name'])) {
    $name = $_SESSION['pm_name'];
    setcookie('pm_name', $name, 0, "/ems");
  }
  if(!isset($_COOKIE['pm_role'])) {
    $role = $_SESSION['pm_role'];
    setcookie('pm_role', $role, 0, "/ems");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">