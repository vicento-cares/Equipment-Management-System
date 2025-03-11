<?php
set_time_limit(0);
session_set_cookie_params(0, "/ems");
session_name("ems");
session_start();

if (!isset($_SESSION['setup_username'])) {
    header('location:../../../login/');
    exit;
} else {
    if ($_SESSION['setup_approver_role'] == "1") {
        header('location:../approver1/home.php');
        exit;
    } else if ($_SESSION['setup_approver_role'] == "2") {
        header('location:../approver2/home.php');
        exit;
    } else if ($_SESSION['setup_approver_role'] == "3") {
        header('location:../approver3/home.php');
        exit;
    }
}

require('../db/conn.php');
require('../lib/validate.php');

switch (true) {
    case !isset($_GET['ww_start_date']):
    case !isset($_GET['ww_next_date']):
    case !isset($_GET['machine_no']):
    case !isset($_GET['equipment_no']):
    case !isset($_GET['machine_name']):
    case !isset($_GET['manpower']):
    case !isset($_GET['shift_engineer']):
        echo 'Query Parameters Not Set';
        exit;
        break;
}

$ww_start_date = $_GET['ww_start_date'];
$ww_next_date = $_GET['ww_next_date'];
$machine_no = $_GET['machine_no'];
$equipment_no = $_GET['equipment_no'];
$machine_name = $_GET['machine_name'];
$manpower = $_GET['manpower'];
$shift_engineer = $_GET['shift_engineer'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EMS PM" />
    <meta name="keywords" content="EMS, PM, Sticker" />
    <title>EMS PM | Print Single PM Sticker</title>

    <!-- Bootstrap -->
    <link rel="preload" href="../../../plugins/bootstrap/css/bootstrap.min.css" as="style"
        onload="this.rel='stylesheet'">
    <link rel="stylesheet" href="../../../plugins/bootstrap/css/bootstrap.min.css">
    <style>
        @media print {
            @page {
                size: portrait;
            }
        }

        table,
        tr,
        td,
        th {
            color: black;
            border: 1px solid black;
            border-width: medium;
            border-collapse: collapse;
        }
    </style>

    <noscript>
        <link rel="stylesheet" href="../../../plugins/bootstrap/css/bootstrap.min.css">
    </noscript>

    <link rel="icon" type="image/x-icon" href="../../../dist/img/ems-logo.png">
</head>

<body class="mx-0 my-0">
    <noscript>
        <br>
        <span>We are facing <strong>Script</strong> issues. Kindly enable <strong>JavaScript</strong>!!!</span>
        <br>
        <span>Call IT Personnel Immediately!!! They will fix it right away.</span>
    </noscript>
    <div class="row">

        <div class="col-6">
            <table class="mx-0 my-0" style="height:100%;width:100%;table-layout:fixed;">
                <tbody>
                    <tr>
                        <td class="px-1 py-1">
                            <div class="row ml-1">
                                <div class="d-flex justify-content-between">
                                    <img src="../../../dist/img/FAS.png" alt="EMS Logo" height="60" width="120">
                                    <span class="font-weight-bold ml-1" style="font-size:18px;">FURUKAWA AUTOMOTIVE
                                        SYSTEMS LIMA PHILIPPINES INC.</span>
                                </div>
                            </div>
                            <div class="row ml-1 mb-1">
                                <span class="font-weight-bold font-italic" style="font-size:16px;">Equipment PM Schedule
                                    Sticker</span>
                            </div>
                            <div class="row ml-1">
                                <span class="mr-1" style="font-size:16px;">Equipment Name :</span>
                                <span class="font-weight-bold"
                                    style="font-size:16px;"><?= htmlspecialchars($machine_name) ?></span>
                            </div>
                            <div class="row ml-1">
                                <span class="mr-1" style="font-size:16px;">Machine No. :</span>
                                <span class="font-weight-bold"
                                    style="font-size:16px;"><?= htmlspecialchars($machine_no) ?></span>
                            </div>
                            <div class="row ml-1">
                                <span class="mr-1" style="font-size:16px;">Equipment No. :</span>
                                <span class="font-weight-bold"
                                    style="font-size:16px;"><?= htmlspecialchars($equipment_no) ?></span>
                            </div>
                            <div class="row ml-1">
                                <span class="mr-1" style="font-size:16px;">Setup By :</span>
                                <span class="font-weight-bold"
                                    style="font-size:16px;"><?= htmlspecialchars($manpower) ?></span>
                            </div>
                            <div class="row ml-1">
                                <span class="mr-1" style="font-size:16px;">Setup Date :</span>
                                <span class="font-weight-bold"
                                    style="font-size:16px;"><?= date("Y-m-d", strtotime($ww_start_date)) ?></span>
                            </div>
                            <div class="row ml-1">
                                <span class="mr-1" style="font-size:16px;">Next PM Date :</span>
                                <?php if (!empty($ww_next_date)) { ?>
                                    <span class="font-weight-bold"
                                        style="font-size:16px;"><?= date("Y-m-d", strtotime($ww_next_date)) ?></span>
                                <?php } else { ?>
                                    <span class="font-weight-bold" style="font-size:16px;"></span>
                                <?php } ?>
                            </div>
                            <div class="row ml-1 mt-2">
                                <span class="mr-1" style="font-size:16px;">Shift Engineer :</span>
                                <span class="font-weight-bold"
                                    style="font-size:16px;"><?= htmlspecialchars($shift_engineer) ?></span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

    <!-- jQuery -->
    <script src="../../../plugins/jquery/jquery.min.js"></script>

    <script>
        setTimeout(print_data, 2000);
        function print_data() {
            window.print();
        }
    </script>
</body>

</html>