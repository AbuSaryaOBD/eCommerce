<?php
    function lang($phrase)
    {
        static $lang = array (
            // Dashboard Page
            'HOME_ADMIN'      => 'Home',
            'CATEGORIES'      => 'Categories',
            'ITEMS'           => 'Items',
            'MEMBERS'         => 'Members',
            'STATISTICS'      => 'Statistics',
            'LOGS'            => 'Logs',
            'EDIT_PROFILE'    => 'Edit Profile',
            'SETTING'         => 'Setting',
            'LOGOUT'          => 'Logout',
        );
        return $lang[$phrase];
    }