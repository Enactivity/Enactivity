<?php
/**
 * CDbException class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CDbException represents an exception that is caused by some DB-related operations.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CDbException.php 2320 2010-08-18 14:54:58Z qiang.xue $
 * @package system.db
 * @since 1.0
 */
class CDbException extends CException
{
	/**
	 * @var mixed the error info provided by a PDO exception. This is the same as returned
	 * by {@link http://www.php.net/manual/en/pdo.errorinfo.php PDO::errorInfo}.
	 * @since 1.1.4
	 */
	public $errorInfo;

	/**
	 * Constructor.
	 * @param string PDO error message
	 * @param integer PDO error code
	 * @param mixed PDO error info
	 */
	public function __construct($message,$code=0,$errorInfo=null)
	{
		$this->errorInfo=$errorInfo;
		parent::__construct($message,$code);
	}
}