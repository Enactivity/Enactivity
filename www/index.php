<?php

$path = dirname(__FILE__) . '/../yii_framework/yii.php';
require_once($path);

#must be included before Yii to define YII_DEBUG, YII_TRACE_LEVEL
$config = include dirname(__FILE__) . '/../protected/config/web.local.php';
 
// run the site
Yii::createWebApplication($config)->run();