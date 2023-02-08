<?php
    session_start();
    include('server.php');

    if (isset($_SESSION['username'])) {
        if ($_SESSION['user_role'] !== 'admin') {
            header('location: index.php');
        }
    } else {
        header('location: index.php');
    }
?>