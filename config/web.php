<?php

$baseDir = __DIR__;
$params = require($baseDir . '/params.php');
$vendorDir = dirname($baseDir) . '/vendor';
$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'sourceLanguage' => 'en',
    'language' => 'de',
    'bootstrap' => ['log', 'lang'],
    'homeUrl' => ['site/index'],
    'extensions' => require($vendorDir . '/yiisoft/extensions.php'),
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'test',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\components\UserIdentity',
            'class' => 'app\components\WebUser',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => YII_DEBUG ? 0 : ['error', 'warning'],
                ],
            ],
        ],
        'db' => require($baseDir . '/db.php'),
        'lang' => '\app\components\widgets\LanguageSwitcher',
        'urlManager' => [
            'enablePrettyUrl' => false,
            'showScriptName' => false,
            'rules' => [],
        ],
        'session' => [
            'class' => 'yii\web\DbSession',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}
return $config;
