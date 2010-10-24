<?php
/**
 * CMysqlColumnSchema class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright Copyright &copy; 2008-2010 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

/**
 * CMysqlColumnSchema class describes the column meta data of a MySQL table.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @version $Id: CMysqlColumnSchema.php 2298 2010-08-02 15:31:37Z qiang.xue $
 * @package system.db.schema.mysql
 * @since 1.0
 */
class CMysqlColumnSchema extends CDbColumnSchema
{
	/**
	 * Extracts the PHP type from DB type.
	 * @param string DB type
	 */
	protected function extractType($dbType)
	{
		if(strncmp($dbType,'enum',4)===0)
			$this->type='string';
		else if(strpos($dbType,'float')!==false || strpos($dbType,'double')!==false)
			$this->type='double';
		else if(strpos($dbType,'bool')!==false)
			$this->type='boolean';
		else if(strpos($dbType,'int')===0 && strpos($dbType,'unsigned')===false || preg_match('/(bit|tinyint|smallint|mediumint)/',$dbType))
			$this->type='integer';
		else
			$this->type='string';
	}

	protected function extractDefault($defaultValue)
	{
		if($this->dbType==='timestamp' && $defaultValue==='CURRENT_TIMESTAMP')
			$this->defaultValue=null;
		else
			parent::extractDefault($defaultValue);
	}

	/**
	 * Extracts size, precision and scale information from column's DB type.
	 * @param string the column's DB type
	 */
	protected function extractLimit($dbType)
	{
		if (strncmp($dbType, 'enum', 4)===0 && preg_match('/\((.*)\)/',$dbType,$matches))
		{
			$values = explode(',', $matches[1]);
			$size = 0;
			foreach($values as $value)
			{
				if(($n=strlen($value)) > $size)
					$size=$n;
			}
			$this->size = $this->precision = $size-2;
		}
		else
			parent::extractLimit($dbType);
	}
}