<?php 
    session_start();
    if (isset($_SESSION['username'])) {
        include 'init.php';
        echo 'Welcome';
        include $tp1 . 'footer.php';
    }
    else {
        header('Location: index.php');
        exit();
    }