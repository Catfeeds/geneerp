<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=geneerp',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'tablePrefix' => 't_',
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 24 * 3600,
    'schemaCache' => 'cache',
];
