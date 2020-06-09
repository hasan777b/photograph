<?php

include($_SERVER['DOCUMENT_ROOT']."/photograph/backEnd/functions/backEndFunctions/globalFunctions.php");
is_login() == false ? header('Location: /photograph/login') : '';
logOutAfterTime();
include($_SERVER['DOCUMENT_ROOT']."/photograph/backEnd/Class/ACL.php");


?>
    <!DOCTYPE html>
    <html lang="en">
<?php include("head.php");?>


<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
    </div>

    <!-- Begin page -->
<div id="wrapper">


    <!-- Left Sidebar End -->
<?php include("side_menu.php");?>
    <!-- Start right Content here -->

    <div class="content-page">
        <!-- Start content -->
        <div class="content">
<?php include("topbar.php");?>