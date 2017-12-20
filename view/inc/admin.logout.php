<?php
    session_start();
    include_once('../../classes/database.class.php');
    include_once('../../classes/user.class.php');
    $user = new User();
    $user->logout(true);
?>