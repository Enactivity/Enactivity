<?php

/**
 * Interface to control facebook group feeds
 */

interface FacebookFeedable
{
	/**
	 * @return string a email for facebook group feed posts
	 **/
	public function getViewLink();

}
