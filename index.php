<?php
/**
 * Used only for including corresponding
 * server configuration file,
 * can be predefined by Apache
 * (SetEnv APPLICATION_ENV "production")
 * ['local' | 'dev' | 'production']
 */ 
$_SERVER['APPLICATION_ENV'] = isset($_SERVER['APPLICATION_ENV']) ? $_SERVER['APPLICATION_ENV'] : 'production';
$_SERVER['YII_INCLUDE_PATH'] = isset($_SERVER['YII_INCLUDE_PATH']) ? $_SERVER['YII_INCLUDE_PATH'] : '/../../yii_framework/yii.php';

require_once($_SERVER[YII_INCLUDE_PATH]); // defined in config/server.*.php or via Apache

#must be included before Yii to define YII_DEBUG, YII_TRACE_LEVEL
$config = include dirname(__FILE__) 
	. '/protected/config/server.'
	. $_SERVER[APPLICATION_ENV]
	. '.php';
 
// run the site
Yii::createWebApplication($config)->run();