<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/all.php'),
	array(
		'import' => array(
			'application.tests.functional.cases.*',
		),
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'db'=>array(
				'connectionString' => 'mysql:host=#TESTDATABASEHOST#;dbname=#TESTDATABASENAME#',
				'emulatePrepare' => true,
				'username' => '#TESTDATABASEUSER#',
				'password' => '#TESTDATABASEPASSWORD#',
				'charset' => 'utf8',
			),
			'log'=>array(
				'class'=>'CLogRouter',
				 'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'error, warning, trace, info, profile',
						'logFile'=>'test.log',
					),
				),
			),
		),
	),
	require(dirname(__FILE__).'/test.custom.php')
);
