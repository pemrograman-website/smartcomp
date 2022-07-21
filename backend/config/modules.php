<?php
return [
    'admin' => [
        'class' => 'mdm\admin\Module',
        'layout' => 'right-menu',
        'mainLayout' => '@app/views/layouts/main.php',
    ],
    'as access' => [
        'class' => 'mdm\admin\component\AccessController',
        'allowActions' => [
            '*',
        ]
    ],
    'gridview' =>  [
        'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
    ]
];
