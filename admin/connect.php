<?php
    $dsn    = 'mysql:host=localhost;dbname=shop';
    $user   = 'root';
    $pass   = 'Qwer!234';
    $optin = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    try {
        $con = new PDO($dsn,$user,$pass,$optin);
        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo 'Faild To Connect' . $e->getMessage();
    }