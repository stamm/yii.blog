<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/all.php'),
	array(
		'defaultController'=>'post',
	),
	require(dirname(__FILE__).'/main.custom.php')
);
