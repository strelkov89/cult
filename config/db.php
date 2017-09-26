<?php

/**
 * DB configuration
 */
if ('prod' === YII_ENV) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=ms_culture',
        'username' => 'ИМЯ ПОЛЬЗОВАТЕЛЯ',
        'password' => 'ПАРОЛЬ',
        'charset' => 'utf8',
    ];
}

// development
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=ms_culture',
    'username' => 'ИМЯ ПОЛЬЗОВАТЕЛЯ',
        'password' => 'ПАРОЛЬ',
    'charset' => 'utf8',
];
