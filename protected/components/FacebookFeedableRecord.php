<?php

/**
 * Interface to control facebook group feeds
 */

interface FacebookFeedableRecord
{
	/**
	 * @return string a URL for facebook group feed posts
	 **/
	public function getViewURL();


	/**
	 * @return string a model name used for facebook group feed
	 **/
	public function getFacebookFeedableName();

}
