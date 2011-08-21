<?php
return array(
	'components'=>array(
		'fixture'=>array(
			'class'=>'system.test.CDbFixtureManager',
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=blog.localhost_test',
			'emulatePrepare' => true,
			'username' => 'yii.blog',
			'password' => 'yii.blog',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
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
);
