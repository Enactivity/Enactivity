<?php

// set environment
require_once(dirname(__FILE__) . '/../protected/components/Environment.php');
$environment = new Environment();
 
// set debug and trace level
defined('YII_DEBUG') or define('YII_DEBUG', $environment->yiiDebug);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', $environment->yiiTraceLevel);

// show produced environment configuration
// $environment->showDebug();

// run Yii app
require_once($environment->yiiPath);
$environment->runYiiStatics(); // like Yii::setPathOfAlias()
Yii::createWebApplication($environment->webApplicationConfig)->run();
