<?php

    /* Categories => [ Manage | Edit | Update | Add | Insert | Delete | State ] */

    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage') {
        
    } elseif ($do == 'Add') {
        
    } elseif ($do == 'Insert') {
        
    } else {
        echo '<p>Sorry, Page Doesn\'t Exist</p>';
    }
    