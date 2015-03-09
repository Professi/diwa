<?php

$baseDir = __DIR__;
$params = require($baseDir . DIRECTORY_SEPARATOR . 'params.php');
$vendorDir = dirname($baseDir) . '/vendor';
$mailer = require ($baseDir . DIRECTORY_SEPARATOR . 'mailer.php');
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
            //you SHOULD change it
            'cookieValidationKey' => 'Pheinen5AhNei9shaiX6ge7AAex8Au2jDoogoh8B',
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
        'mailer' => $mailer,
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
            'enablePrettyUrl' => false, //see http://stackoverflow.com/questions/26525320/enable-clean-url-in-yii2
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
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
