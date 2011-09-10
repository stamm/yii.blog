<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	// autoloading model and component classes
	'import'=>array(
		'application.extensions.yiidebugtb.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(

		'cache'=>array(
			'class'=>'CMemCache',
			'servers'=>array(
				array(
					#'host'=>'unix:///tmp/memcached.sock', 'port'=>NULL
					'host'=>'127.0.0.1',
					'port'=>11211,
				),
			),
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=blog.localhost',
			'emulatePrepare' => true,
			'username' => 'yii.blog',
			'password' => 'yii.blog',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
			//TODO: в продакешене поставить
			'schemaCachingDuration'=>0,
			'enableProfiling'=>true,
			'enableParamLogging' => true,
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
						'class' => 'CProfileLogRoute',
				),
				array(
						'class' => 'CEmailLogRoute',
						'categories' => 'example',
						'levels' => CLogger::LEVEL_ERROR,
						'emails' => array('stammru@gmail.com'),
						//'sentFrom' => 'log@example.com',
						'subject' => 'Error at example.com',
				),
				array(
					'class'=>'CFileLogRoute',
					//'levels'=>'error, warning, trace, info, profile',
					'levels'=>'error, warning, info, profile',
					'logFile'=>'my.log',
				),
				array(
					'class'=>'CWebLogRoute',
				),
				// configuration for the toolbar
				array(
					'class'=>'XWebDebugRouter',
					'config'=>'alignRight, opaque, runInDebug, fixedPos,  yamlStyle',
					'levels'=>'error, warning, trace, profile, info',
					'allowedIPs'=>array('127.0.0.1'),
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);