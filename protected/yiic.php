<?php

// change the following paths if necessary
$yiic=dirname(__FILE__).'/../yii_framework/yiic.php';

// use local config if it exists
$config=file_exists(dirname(__FILE__).'/config/console.local.php') 
	? dirname(__FILE__).'/config/console.local.php' 
	: dirname(__FILE__).'/config/console.php';

require_once($yiic);