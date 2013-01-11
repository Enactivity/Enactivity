<?php

// set environment
require_once(dirname(__FILE__) . '/components/Environment.php');
$environment = new Environment();

// run Yii app
$config = $environment->consoleApplicationConfig;
require_once($environment->yiicPath);