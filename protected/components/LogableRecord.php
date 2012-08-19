<?php

/**
 * Interface to control notifications
 */
interface LogableRecord
{
	/**
	 * @return string The central model of the record, not necessarily the one that changed, but the one that can stand-alone  
	 **/
	public function getFocalModelClassForLog();

	/**
	 * @return int the primary key for the focal model to log
	 **/
	public function getFocalModelIdForLog();

	/**
	 * @return string a name for the model as it should appear in notifications
	 **/
	public function getFocalModelNameForLog();
}
