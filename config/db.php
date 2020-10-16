<?php
require (__DIR__ . '/constant.php');

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.HOST_IP.';dbname=storage',
    'username' => 'root',
    'password' => '123456',
    'charset' => 'utf8',
];
