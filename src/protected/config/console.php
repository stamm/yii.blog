<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$aConfig = CMap::mergeArray(
	CMap::mergeArray(
		require(dirname(__FILE__).'/main.php'),
		array(
			'components'=>array(
				'log'=>array(
					'class'=>'CLogRouter',
					 'routes'=>array(
						array(
							'class'=>'CFileLogRoute',
							'levels'=>'error, warning, trace, info, profile',
							'logFile'=>'console.log',
						),
					),
				),
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