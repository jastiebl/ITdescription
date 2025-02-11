<?php


    session_start();
    if (isset($_SESSION['online_user'])) {

        $role = $_SESSION['online_user']['role'];

        if (in_array($role, ['admin', 'employee', 'client'])) {
            header("Location: index.php");
        } else {
            header("Location: admin_login.php");
        }
        exit(); 
    }
    