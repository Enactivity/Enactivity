<?php
/**
 * minScript groups config file for Minify.
 *
 * @author TeamTPG
 * @link http://bitbucket.org/TeamTPG/minscript/
 * @copyright Copyright &copy; 2011-2012 Team T P Giacometti & Co.
 * @license http://bitbucket.org/TeamTPG/minscript/wiki/License
 * @package ext.minScript.vendors.minify.min
 * @since 1.0
 */

/**
 * Create group definition for Minify.
 */
$groupId = (isset($_GET['g'])) ? preg_replace('/[^a-z0-9]/i', '', $_GET['g']) : null;
if (isset($groupId) && ($files = $this -> _minScriptComponent -> minScriptGetGroup($groupId)) !== false) {
	// Get the last modified timestamp for the set of files
	if (($lm = $this -> _minScriptComponent -> minScriptGetLm($files)) === false) {
		Yii::log('The minScript group "'.$groupId.'" could not be served because some files are inaccessible.', CLogger::LEVEL_ERROR, 'ext.minScript.controllers.ExtMinScriptController');
		throw new CHttpException(500, 'Internal Server Error');
	}
	// Loop through files and create ExtMinScriptSource instances
	foreach ($files as $key => $file) {
		$files[$key] = new ExtMinScriptSource( array('filepath' => $file, 'lastModified' => $lm));
	}
	// Return group definition
	return array($groupId => $files);
} else {
	Yii::log('The minScript group "'.$groupId.'" could not be served because it was not found.', CLogger::LEVEL_ERROR, 'ext.minScript.controllers.ExtMinScriptController');
	throw new CHttpException(400, 'Bad Request');
}
