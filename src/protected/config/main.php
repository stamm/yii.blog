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
			),

			'request'=>array(
				'enableCookieValidation'=>true,
			),

			'session'=>array(
				/*'class' => 'CDbHttpSession',
				'connectionID' => 'db',
				'autoCreateSessionTable' => false,*/
				'sessionName' => 'yii.blog',
				'cookieMode' => 'only',
				'timeout' => 1800,//60*30
				//Вероятность вызова метода отчистки сессий в %
				'gCProbability' => 1,
			),

			'urlManager'=>array(
				'urlFormat'=>'path',
				'urlSuffix'=>'/',
				'rules'=>array(
				),
				'showScriptName'=>false,
			),

			'db'=>array(
				'connectionString' => 'mysql:host=#DATABASEHOST#;dbname=#DATABASENAME#',
				'emulatePrepare' => true,
				'username' => '#DATABASEUSER#',
				'password' => '#DATABASEPASSWORD#',
				'charset' => 'utf8',
				'tablePrefix' => 'tbl_',
				'schemaCachingDuration'=>360,
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
					// uncomment the following to show log messages on web pages
					/*
					array(
						'class'=>'CWebLogRoute',
					),
					*/
				),
			),

			'clientScript'=>array(
				'scriptMap'=>array(
					'jquery.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.js',
					'jquery.min.js'=>'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js',
				)
			),
		),

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
			// this is used in contact page
			'adminEmail'=>'webmaster@example.com',
		),
	),

		require(dirname(__FILE__).'/main.custom.php')

	);
