<?php
$params = array_merge(
	require (__DIR__ . '/../../common/config/params.php'),
	require (__DIR__ . '/../../common/config/params-local.php'),
	require (__DIR__ . '/params.php'),
	require (__DIR__ . '/params-local.php')
);

return [
	'id' => '友山教育咨询有限公司',
	'basePath' => dirname(__DIR__),
	'controllerNamespace' => 'backend\controllers',
	'bootstrap' => ['log'],
	'modules' => [],
	'language' => 'zh-CN',
	'components' => [
		'request' => [
			'csrfParam' => '_csrf-backend',
			'csrfCookie' => [
				'httpOnly' => true,
				'path' => '/dashboard',
			],
		],
		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
			'identityCookie' => [
				'name' => '_identity-backend',
				'path' => '/dashboard',
				'httpOnly' => true,
			],
		],
		'session' => [
			// this is the name of the session cookie used for login on the backend
			'name' => 'advanced-backend',
			'cookieParams' => [
				'path' => '/dashboard',
			],
		],
		// 'user' => [
		// 	'identityClass' => 'common\models\User',
		// 	'enableAutoLogin' => true,
		// ],
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
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
			],
		],
		'authManager' => [
			'class' => 'yii\rbac\DbManager', // 使用数据库管理配置文件
		],
		'i18n' => [
			'translations' => [
				'app*' => [
					'class' => 'yii\i18n\PhpMessageSource',
					'basePath' => '@backend/messages',
					'sourceLanguage' => 'en-US',
					'fileMap' => [
						'app' => 'app.php',
						'app/error' => 'error.php',
					],
				],
			],
		],
	],
	// 'as access' => [
	// 	'class' => 'jackh\admin\components\AccessControl',
	// 	'allowActions' => [
	// 		'site/*',
	// 		'gii/*',
	// 		'debug/*',
	// 		'dashboard/*',
	// 		// 'admin/*',
	// 	],
	// ],
	'modules' => [
		'admin' => [
			'class' => 'jackh\admin\Module',
			//'layout'        => 'left-menu',
			'layout' => 'main', // it can be '@path/to/your/layout'.
			'controllerMap' => [
				'assignment' => [
					'class' => 'jackh\admin\controllers\AssignmentController',
					'userClassName' => 'common\models\User',
					'idField' => 'user_id',
				],
			],
		],
		'dashboard' => [
			'class' => 'jackh\dashboard\Module',
			'layout' => 'dashboard', // it can be '@path/to/your/layout'.
			'controllerMap' => [
				'dashboard' => [
					'class' => 'jackh\dashboard\controllers\DefaultController',
					'userClassName' => 'common\models\User',
					'idField' => 'user_id',
				],
			],
		],
    ],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	'params' => $params,
];
