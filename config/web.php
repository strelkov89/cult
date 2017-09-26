<?php

$params = require(__DIR__.'/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'Культурный код',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'TcМ9bH_0OomNWZ8P6zUCH-vu5JV5uM23',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => YII_ENV_DEV ? true : false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__.'/db.php'),
        'assetManager' => [
            'bundles' => require(__DIR__.'/'.(YII_ENV_PROD ? 'assets-prod.php' : 'assets-dev.php')),
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                '/project/request-confirm' => '/project/request_confirm',
                '/project/request-reject' => '/project/request_reject',
            ],
        ],
        // custom views for Dektrium's user module
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en-US',
                ],
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'controllerMap' => [
                'settings' => 'app\controllers\user\SettingsController',
                'security' => 'app\controllers\user\SecurityController',
                'registration' => 'app\controllers\user\RegistrationController',
                'recovery' => 'app\controllers\user\RecoveryController',
            ],
            'modelMap' => [
                'Profile' => 'app\models\user\Profile',
                'User' => 'app\models\user\User',
            ],
            'mailer' => [
                'sender' => ['no-reply@culture.apps4all.ru' => 'Культурный код'],
                'welcomeSubject' => 'Добро пожаловать на "Культурный код"',
                'confirmationSubject' => 'Подтверждение регистрации',
                'reconfirmationSubject' => 'Email change subject',
                'recoverySubject' => 'Восстановление пароля',
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';

    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['192.168.56.1', '127.0.0.1', '::1']
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';

    if (YII_ENV == 'dev') {
        $config['components']['mailer'] = [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
            ],
        ];
    }
}

return $config;
