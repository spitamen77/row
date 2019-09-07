<?php
// O'zingizni malumotlar bazasini ulash uchun default fayl. nomini db.php ga o'zgartirish sozlashlarni amalga oshiring. @creator Sarvar Makmudjanov
return [
    'class' => 'uni\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=db_name',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
    'enableSchemaCache' => true,
];