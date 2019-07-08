<?php

return [
    // MySQL
//    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=localhost;dbname=portfolio_blog',
//    'username' => 'root',
//    'password' => '',
//    'charset' => 'utf8',

    // PostgreSQL
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=127.0.0.1;port=5432;dbname=portfolio_blog',
    'username' => 'postgres',
    'password' => 'admin',
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql'=> [
            'class'=>'yii\db\pgsql\Schema',
            'defaultSchema' => 'public' //specify your schema here
        ]
    ],

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
