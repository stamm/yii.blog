<?php

// Example config for console.custom
return array(
	'components'=>array(
		'authManager'=>array(
				'class'=>'CDbAuthManager',
				'connectionID'=>'db_test',
		),
		'db_test'=>array(
			'class'=>'system.db.CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=blog.localhost_test',
			'emulatePrepare' => true,
			'username' => 'yii.blog',
			'password' => 'yii.blog',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
	),
);