<?php

/**
 * Interface to control facebook group feeds
 */

interface FacebookFeedableRecord
{
	/**
	 * @return a URL for facebook group feed posts
	 **/
	public function getViewURL();


	/**
	 * @return a string used for facebook group feeds
	 **/
	public function getFacebookFeedableName();

}
