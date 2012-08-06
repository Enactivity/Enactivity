<?php

/**
 * Interface to control notification emails
 */

interface EmailableRecord
{
	/**
	 * @return string a name for the model as it should appear in emails
	 **/
	public function getEmailName();


	/**
	 * @return boolean based on the scenario for the model
	 **/
	public function shouldEmail();

	/**
	 * @return array of emails that will be notified
	 **/
	public function whoToNotifyByEmail();
}
