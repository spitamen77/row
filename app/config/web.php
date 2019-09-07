<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'defaultRoute'=>'users/default/index',
    'bootstrap' => ['log'],
    'components' => [
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\UIAsset' => [
                    //'js'=>[],
                    //'css' => [],
                ],
            ],
        ],
    
        'urlManager' => [

            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'class'=>'app\components\manager\LangUrlManager',
            'rules' => [
                'http://<subdomain>.simplex.uz' => 'users/default/dashboard',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<item:\w+>/<id:\d+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<item:\d+>/<id:\d+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<item:\w+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/<_c>/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/view/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/edit/<id:\d+>' => '<_m>/<_c>/edit',
                '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/view',
                '<_m:[\w\-]+>' => '<_m>/default/index',
                '<_m:[\w\-]+>/<_a:[\w\-]+>' => '<_m>/default/<_a>',
                '<_m:[\w\-]+>/<_c:[\w\-]+>' => '<_m>/<_c>/index',
                '<controller>' => '<controller>/index',
                '<controller:\w+>' => '<controller:\w+>/index',
                '<controller>/<action>' => '<controller>/<action>',
                '<controller>/<action:\w+>/*' => '<controller>/<action:\w+>',
                '<controller:\w+>/<action:\w+>/*' => '<controller:\w+>/<action:\w+>',
                '<controller:\w+>/<action:\w+>/<id:\w+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>/<id:\w+>/<page:\w+>' => '<controller>/<action>',
            ]
        ],
        'language'=>'ru-RU',
        'i18n' => [
            'translations' => [
                "app"=>[
                    'class' => 'uni\i18n\DbMessageSource',
                    'sourceLanguage' => 'en-US',
                ],
                "model"=>[
                    'class' => 'uni\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        'model' => 'model.php',
                    ],
                ],
            ],
        ],
        'request' => [
            'class' => 'app\components\manager\RequestManager',
             'cookieValidationKey' => 'qbbazxswedcvfrtgbnhyujm',
        ],
        'cache' => [
            'class' => 'uni\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UserModel',
            'enableAutoLogin' => true,
            'loginUrl' => '/users/auth/login',
        ],
        'authManager'=>[
            'class' => 'app\rbac\AccessManager',
            'defaultRoles' => ['admin','user'],
        ],
        'errorHandler' => [
            'errorAction' => 'users/maintenance/index',
        ],
        'mailer' => [
            'class' => 'uni\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'bitsimplex.net@gmail.com',
                'password' => 'b1t$!mplex',
                'port' => '587',
                'encryption' => 'tls',
            ],
        ],

        'log' => [
            'traceLevel' => UNI_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'uni\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        'db' => require(__DIR__ . '/db.php'),
    ],
    'modules'=>[
        'users' => [
            'class' => 'app\modules\users\Users',
        ],
        'reference' => [
            'class' => 'app\modules\reference\Reference',
        ],
        'litsenziya' => [
            'class' => 'app\modules\litsenziya\Litsenziya',
        ],
        'settings' => [
            'class' => 'app\modules\settings\Settings',
        ],
        'api' => [
            'class' => 'app\modules\api\API',
        ],
        'hr' => [
            'class' => 'app\modules\hr\HR',
        ],
        'gridview'=>[
            'class' => '\kartik\grid\Module',
        ],
        'arrival'=>[
            'class' => 'app\modules\arrival\Arrival',
        ],
        'handbook' => [
            'class' => 'app\modules\handbook\Handbook',
        ],
        'cpanel' => [
            'class' => 'app\modules\cpanel\CPanel',
        ],
        'reestr' => [
            'class' => 'app\modules\reestr\Reestr',
        ],
        'preparat' => [
            'class' => 'app\modules\preparat\Preparat',
        ],
        'report' => [
            'class' => 'app\modules\report\Report',
        ],
         'vaksinatsiya' => [
             'class' => 'app\modules\vaksina\Vaksina',
         ],
        'filemanager' => [
            'class' => 'app\modules\filemanager\Filemanager',
        ],
        'video' => [

            'class' => 'app\modules\video\Video',
        ],
        'comment' => [

            'class' => 'app\modules\comment\CommentModule',

        ],
        'laboratory' => [

            'class' => 'app\modules\laboratory\Laboratory',

        ],
        'diagnose' => [

            'class' => 'app\modules\diagnose\Diagnose',

        ],
    ],
    'params' => $params,
];

if (UNI_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
   $config['modules']['debug'] = [
    'class'=>'uni\debug\Module',
    'allowedIPs'=>['127.0.0.1','213.230.73.239']
    ];

    $config['bootstrap'][] = 'generator';
    $config['modules']['generator'] = 'uni\generator\Module';
}

return $config;
