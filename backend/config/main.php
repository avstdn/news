<?php

use yii\helpers\FileHelper;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => true,
            'hashCallback' =>  function ($path) {
                $assetPath = array_map(function($item) {
                    return Yii::getAlias($item);
                }, ['@public/assets']);

                if (in_array($path, $assetPath)) {
                    $files = FileHelper::findFiles($path, ['only' => ['*.js', '*.css']]);
                    $max = 0;
                    foreach ($files as $file) {
                        $max = max($max, filemtime($file));
                    }
                    $hash = $path.$max;
                } else {
                    $path = (is_file($path) ? dirname($path) : $path).filemtime($path);
                    $hash = $path.Yii::getVersion();
                }
                return sprintf('%x', crc32($hash));
            }
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],

    ],
    'params' => $params,
];
