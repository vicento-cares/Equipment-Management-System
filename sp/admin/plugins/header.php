<?php
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['sp_username'])) {
  header('location:../../login/');
  exit;
} else {
  if(!isset($_COOKIE['sp_name'])) {
    $name = $_SESSION['sp_name'];
    setcookie('sp_name', $name, 0, "/ems");
  }
  if(!isset($_COOKIE['sp_role'])) {
    $role = $_SESSION['sp_role'];
    setcookie('sp_role', $role, 0, "/ems");
  }
  if(!isset($_COOKIE['sp_process'])) {
    $sp_process = $_SESSION['sp_process'];
    setcookie('sp_process', $sp_process, 0, "/ems");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">