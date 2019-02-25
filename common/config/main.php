<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@cpn/chanpan' => '@common/lib/yii2-chanpan',
//        '@cpn/admin' => '@common/lib/yii2-admin',
        '@appxq/sdii' => '@common/lib/yii2-sdii',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
