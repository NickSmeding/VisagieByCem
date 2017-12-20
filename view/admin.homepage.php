<?php
    session_start();
    include_once('inc/head.php');
    include_once('../classes/database.class.php');
    include_once('../classes/user.class.php');

    $userClass = new User();

    if(!$userClass->checkAdmin()){
        header("Location: admin.php");
        exit();
    }

    include_once('inc/admin.header.php');
?>