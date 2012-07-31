<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	// application components
	'components'=>array(

		'cache'=>array(
			'class'=>'CMemCache',
			'servers'=>array(
				array(
					'host'=>'unix:///tmp/memcached.sock', 'port'=>NULL
					#'host'=>'127.0.0.1',
					#'port'=>11211,
				),
			),
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yii.blog',
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

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					//'levels'=>'error, warning, trace, info, profile',
					'levels'=>'error, warning, info, profile',
					'logFile'=>'my.log',
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