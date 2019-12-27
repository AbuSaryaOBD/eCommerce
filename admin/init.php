<?php
    include 'connect.php';

    // Routes
    $tp1    = 'includes/templates/';
    $lang   = 'includes/languages/';
    $func   = 'includes/functions/';
    $css    = 'layout/css/';
    $js     = 'layout/js/';
    

    //Include Important Files
    include $func . 'functions.php';
    include $lang . 'english.php';
    include $tp1 . 'header.php';

    //Include Navbar On All Pages Expect The One With $noNavbar
    if (!isset($noNavbar)) { include $tp1 . 'navbar.php'; }
    