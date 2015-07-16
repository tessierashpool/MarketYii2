<?php

$params = require(__DIR__ . '/params.php');
use \kartik\datecontrol\Module;
$config = [
    'id' => 'basic',
    'name'=>'E-SHOP',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Admin',
			'layout'=> 'main'
        ],
        'yii2images' => [
            'class' => 'rico\yii2images\Module',
            //be sure, that permissions ok 
            //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
            'imagesStorePath' => 'uploads/images/store', //path to origin images
            'imagesCachePath' => 'uploads/images/cache', //path to resized copies
            'graphicsLibrary' => 'GD', //but really its better to use 'Imagick' 
            'placeHolderPath' => '@webroot/uploads/images/placeHolder.png', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias
        ],
        /*
		'datecontrol' => [
			'class' => 'kartik\datecontrol\Module',

			// format settings for displaying each date attribute (ICU format example)
			'displaySettings' => [
				Module::FORMAT_DATE => 'dd-MM-yyyy',
				Module::FORMAT_TIME => 'HH:mm:ss a',
				Module::FORMAT_DATETIME => 'dd-MM-yyyy HH:mm:ss a',
				],
				// format settings for saving each date attribute (PHP format example)
				'saveSettings' => [
				Module::FORMAT_DATE => 'php:U', // saves as unix timestamp
				Module::FORMAT_TIME => 'php:H:i:s',
				Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
			],

			// set your display timezone
			'displayTimezone' => 'Asia/Kolkata',

			// set your timezone for date saved to db
			'saveTimezone' => 'UTC',
			// automatically use kartik\widgets for each of the above formats
			'autoWidget' => false,

			// default settings for each widget from kartik\widgets used when autoWidget is true
			'autoWidgetSettings' => [
				Module::FORMAT_DATE => ['type'=>3, 'pluginOptions'=>['autoclose'=>true]], // example
				Module::FORMAT_DATETIME => [], // setup if needed
				Module::FORMAT_TIME => [], // setup if needed
			],
			// custom widget settings that will be used to render the date input instead of kartik\widgets,
			// this will be used when autoWidget is set to false at module or widget level.
			'widgetSettings' => [
					Module::FORMAT_DATE => [
					'class' => 'kartik\widgets\DatePicker', // example
					'options' => [
					'dateFormat' => 'php:d-M-Y',
					'options' => ['class'=>'form-control'],
					]
				]
			]
			// other settings
		]		*/
    ],	
    'components' => [	
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'u7dp47h-pLQmXVVyIcYNvsWvoBQpuSEX',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
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
		'i18n' => [
			'translations' => [
				'*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@app/messages',
					//'sourceLanguage' => 'en-US',
					/*'fileMap' => [
						'app' => 'app.php',
						'app/error' => 'error.php',
					],*/
				],
			],
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
        'db' => require(__DIR__ . '/db.php'),
		'authManager' => [
			'class' => 'yii\rbac\DbManager',
			'defaultRoles' => ['guest'],
		],	
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
				'c/<c>' => 'site/index',
				'<action>' => 'site/<action>',
            ],            
        ],	
    ],
	//'language' => 'ru',
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
