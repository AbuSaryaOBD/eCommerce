<?php
    include 'connect.php';

    // Routes
    $tp1    = 'includes/templates/';
    $css    = 'layout/css/';
    $js     = 'layout/js/';
    $lang   = 'includes/languages/';

    //Include Important Files
    include $lang . 'english.php';
    include $tp1 . 'header.php';

    //Include Navbar On All Pages Expect The One With $noNavbar
    if (!isset($noNavbar)) { include $tp1 . 'navbar.php'; }
    