<?php

/**
 * Interface to control notification emails
 */

interface EmailableRecord
{
	public function shouldEmail();
	public function whoToNotifyByEmail();
}
