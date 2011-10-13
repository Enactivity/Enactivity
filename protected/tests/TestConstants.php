<?php
/**
 * Defined constants that can be used for tests.  Should not
 * be confused with fixtures
 */

/**
 * Change the following URL based on your server configuration
 * Make sure the URL ends with a slash so that we can use relative URLs in test cases
 */
$_SERVER['APPLICATION_ENV'] = 'test';
define('TEST_BASE_URL', 'http://localhost/poncla-yii/index.php/');

// test  constants
define(ADMIN_EMAIL, 'admin@poncla.com');
define(ADMIN_PASSWORD, 'chewychocolatechips');

define(USER_EMAIL, 'user@poncla.com');
define(USER_PASSWORD, 'test');