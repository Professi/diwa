<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=diwa', //MySQL
//    'dsn' => 'pgsql:host=localhost;port=5432;dbname=diwa', // PostgreSQL
    'username' => 'diwa',
    'password' => 'diwa',
    'charset' => 'utf8',
    'enableQueryCache'=> !YII_DEBUG,
    'enableSchemaCache' => !YII_DEBUG,
];
