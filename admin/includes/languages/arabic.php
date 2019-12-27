<?php
    function lang($phrase)
    {
        static $lang = array (
            // Dashboard Page
            'HOME_ADMIN'      => 'الرئيسية',
            'CATEGORIES'      => 'التصنيفات',
            'ITEMS'           => 'العناصر',
            'MEMBERS'         => 'الاعضاء',
            'STATISTICS'      => 'احصاءات',
            'LOGS'            => 'السجل',
            'EDIT_PROFILE'    => 'تعديل الملف الشخصي',
            'SETTING'         => 'الاعدادت',
            'LOGOUT'          => 'تسجيل الخروج',
        );
        return $lang[$phrase];
    }