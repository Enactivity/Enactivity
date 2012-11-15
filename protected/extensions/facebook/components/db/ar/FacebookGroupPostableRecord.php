<?php

/**
 * Interface to control facebook group feeds
 */

interface FacebookGroupPostableRecord
{
	/**
	 * @return string a URL for facebook group feed posts
	 **/
	public function getViewURL();


	/**
	 * @return string a model name used for facebook group feed
	 **/
	public function getFacebookGroupPostName();

}
