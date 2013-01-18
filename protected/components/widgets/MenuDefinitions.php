<?php
/**
 * Class file for MenuDefinitions
 * @author Ajay Sharma
 */

/**
 * Used to define the application menus
 * @see CMenu
 * @author Ajay Sharma
 */
class MenuDefinitions extends CComponent {

	public static function site() {
		return null;
	}
	
	/**
	 * @return array main menu items
	 */
	public static function applicationMenu() {
		return array(
			array(
				'label'=>'<i></i> Dashboard', 
				'linkOptions'=>array(
					'id'=>'application-navigation-site-dashboard',
				),
				'url'=>array('/task/next'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'<i></i> Calendar',
				'linkOptions'=>array(
					'id'=>'application-navigation-task-calendar',
				),
				'url'=>array('/task/calendar'), 
				'visible'=>!Yii::app()->user->isGuest,
			),
			array(
				'label'=>'<i></i> Groups', 
				'linkOptions'=>array(
					'id'=>'application-navigation-membership-index',
				),
				'url'=>array('/membership/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'<i></i> New',
				'linkOptions'=>array(
					'id'=>'application-navigation-task-create',
				),
				'url'=>array('/activity/create'), 
				'visible'=>!Yii::app()->user->isGuest,
			),
		);
	}

	/**
	 * @return array main menu items
	 */
	public static function siteMenu() {
		return array(
			array(
				'label'=>'<i></i> Next', 
				'linkOptions'=>array(
					'id'=>'task-next-menu-item',
				),
				'url'=>array('task/next'),
			),
			array(
				'label'=>'<i></i> Timeline', 
				'linkOptions'=>array(
					'id'=>'feed-index-menu-item',
				),
				'url'=>array('feed/index'),
			),
			array(
				'label'=>'<i></i> Drafts', 
				'linkOptions'=>array(
					'id'=>'activity-drafts-menu-item',
				),
				'url'=>array('activity/drafts'),
			),
		);
	}
}