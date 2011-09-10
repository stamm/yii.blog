<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
	array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'Yii Blog',
		'sourceLanguage' => 'en_us',
		'language' => 'ru',
		'defaultController'=>'post',

		// preloading 'log' component
		'preload'=>array('log'),

		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
		),

		'modules'=>array(
		),

		// application components
		'components'=>array(
			'user'=>array(
				// enable cookie-based authentication
				'allowAutoLogin'=>true,
			),

			'authManager'=>array(
				'class'=>'CDbAuthManager',
				'connectionID'=>'db',
				'assignmentTable' => 'tbl_auth_assignment',
				'itemTable' => 'tbl_auth_item',
				'itemChildTable' => 'tbl_auth_item_child',
			),

			'request'=>array(
				'enableCookieValidation'=>true,
			),

			'assetManager'=>array(
				'linkAssets' => true,
			),

//			'session'=>array(
//				/*'class' => 'CDbHttpSession',
//				'connectionID' => 'db',
//				'autoCreateSessionTable' => false,*/
//				'sessionName' => 'yii.blog',
//				'cookieMode' => 'only',
//				'timeout' => 1800,//60*30
//				//Вероятность вызова метода отчистки сессий в %
//				'gCProbability' => 1,
//			),

			'urlManager'=>array(
				'urlFormat'=>'path',
				'showScriptName'=>false,
				'urlSuffix'=>'/',
				'rules'=>array(
					// When you add some rule for here - add same one to Post::$aDisabledTitle
					'/' => 'post/index',
					'post/<action:create|admin>'=>'post/<action>',
					'post/update/<id:\d+>'=>'post/update',
					'post/<id:\d+>'=>'post/view',
					'post/<url:[^\/]+>'=>'post/view',
					'find'=>'post/find',
					'posts/page/<page:\d+>'=>'post/index',
					'posts(/<tag:.*?>)?'=>'post/index',
					'tag/<tag:.*?>'=>'post/index',

					'<view:about>' => 'site/page',
					'<action:(login|logout)>' => 'site/<action>',
					
					'sitemap\.xml' => 'post/sitemap',
					'gii' => 'gii',
					'rss' => 'rss/index',
					'<id:\d+>'=>'post/view',
					'<url:[^\/]+>' => 'post/view',
					'<url:[^\/]+>/rss' => 'rss/post',
				),
			),

			'db'=>array(
				'connectionString' => 'mysql:host=#DATABASEHOST#;dbname=#DATABASENAME#',
				'emulatePrepare' => true,
				'username' => '#DATABASEUSER#',
				'password' => '#DATABASEPASSWORD#',
				'charset' => 'utf8',
				'tablePrefix' => 'tbl_',
				'schemaCachingDuration'=>360,
				'autoConnect' => false,
			),

			'cache'=>array(
				'class'=>'CMemCache',
				'servers'=>array(
					array(
						'host'=>'127.0.0.1',
						'port'=>11211,
					),
				),
			),
			'session' => array(
				'class' => 'CCacheHttpSession',
				'cacheID' => 'sessionCache',
			),
			'sessionCache' => array(
				'class' => 'CApcCache',
			),

			'errorHandler'=>array(
				// use 'site/error' action to display errors
				'errorAction'=>'site/error',
			),
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning',
					),

				),
			),

			'clientScript'=>array(
				'scriptMap'=>array(
					'jquery.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js',
					'jquery.min.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js',
					'jquery.synctranslit.js' => '/static/js/synctranslit/jquery.synctranslit.js',
					'jquery.synctranslit.js' => '/static/js/synctranslit/jquery.synctranslit.min.js',
				),
				'packages' => array(
					'synctranslit' => array(
						'js'=>array(YII_DEBUG ? 'jquery.synctranslit.js' : 'jquery.synctranslit.min.js'),
						'depends'=>array('jquery'),
					)
				),
			),
		),

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
			'cacheTime' => 3600,
			'adminEmail'=>'webmaster@example.com',
		),
	),

		require(dirname(__FILE__).'/main.custom.php')

	);
