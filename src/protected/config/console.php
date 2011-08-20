<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$aConfig = CMap::mergeArray(
	CMap::mergeArray(
		require(dirname(__FILE__).'/main.php'),
		array(
			'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
			'name'=>'My Console Application',
			// application components
			'components'=>array(
				'db'=>array(
					'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
				),
				// uncomment the following to use a MySQL database
				/*
				'db'=>array(
					'connectionString' => 'mysql:host=localhost;dbname=testdrive',
					'emulatePrepare' => true,
					'username' => 'root',
					'password' => '',
					'charset' => 'utf8',
				),
				*/
			),
		)
	),
	require(dirname(__FILE__).'/console.custom.php')
);

//Disable XWebDebugRouter
foreach( $aConfig['components']['log']['routes'] as $k => $v ){
	if( $v['class'] == 'XWebDebugRouter' ){
		unset( $aConfig['components']['log']['routes'][$k] );
	}
}

return $aConfig;