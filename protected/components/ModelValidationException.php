<?php
/**
 * ModelValidationException class file.
 */

/**
 * ModelValidationException represents an exception that is
 * caused by some Model failing to validate.  Best to use
 * when calling a save function as part of a static call.
 */
class ModelValidationException extends CException
{
	/**
	 * Constructor.
	 * @param string $message PDO error message
	 * @param integer $code PDO error code
	 * @param mixed $errorInfo PDO error info
	 */
	public function __construct($message,$model,$code=0)
	{
		$message .= PHP_EOL . ' Scenario:' . CVarDumper::dumpAsString($model->scenario); 
		$message .= PHP_EOL . ' Errors: ' . CVarDumper::dumpAsString($model->errors);
		$message .= PHP_EOL . ' Attributes: ' . CVarDumper::dumpAsString($model->attributes);
		
		parent::__construct($message,$code);
	}
}