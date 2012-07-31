<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
$aConfig = CMap::mergeArray(
	require(dirname(__FILE__).'/all.php'),
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
		'commandMap' => array(
			'complete' => array(
				'class' => 'ext.complete.LCompleteCommand',
				'bashFile' => '/usr/local/etc/bash_completion.d/yii_applications' //Defaults to </etc/bash_completion.d/yii_applications>. May be changed if needed
			),
		),
	),
	require(dirname(__FILE__).'/console.custom.php')
);

return $aConfig;