<?php
    // Checking if user authenticated
    session_start();
    if(!isset($_SESSION["email"])) {
        // header("Location: login.php");
        header("Location: https://tim1.alwaysdata.net/crowdfunding/login.php");
        exit();
    }
?>