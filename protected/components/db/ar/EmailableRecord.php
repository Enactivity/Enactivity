<?php

/**
 * Interface to control notification emails
 */

interface EmailableRecord
{
	/**
	 * @return string a name for the model as it should appear in emails
	 **/
	public function getNameForEmails();

	/**
	 * @return array of emails that will be notified
	 **/
	public function getWhoToNotifyByEmail();
}
