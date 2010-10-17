<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../yii_framework/yii.php';
//TODO: on production, move protected to non-web folder and redirect here
$config=dirname(__FILE__).'/protected/config/main.php';

// TODO: remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
