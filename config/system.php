<?php

return [
    'db'=> [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=123.206.114.100;dbname=test',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ],

    'redis' => [
        'class' => 'yii\redis\Connection',
        'hostname' => '127.0.0.1',
        'port' => 6379,
        'database' => 0,
    ],

    'queue' => [
        'class' => 'yii\queue\redis\Queue',
        'redis' => 'redis',
        'channel' => 'queue',  //Queue channel key
    ],


    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
