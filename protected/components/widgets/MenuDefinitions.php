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
					'id'=>'application-navigation-my-dashboard',
				),
				'url'=>array('/my/dashboard'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'<i></i> Calendar',
				'linkOptions'=>array(
					'id'=>'application-navigation-my-calendar',
				),
				'url'=>array('/my/calendar'), 
				'visible'=>!Yii::app()->user->isGuest,
			),
			array(
				'label'=>'<i></i> Groups', 
				'linkOptions'=>array(
					'id'=>'application-navigation-my-groups',
				),
				'url'=>array('/my/groups'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'<i></i> New',
				'linkOptions'=>array(
					'id'=>'application-navigation-activity-create',
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
				'label'=>'<i></i> Dashboard', 
				'linkOptions'=>array(
					'class'=>'my-dashboard-menu-item',
				),
				'url'=>array('my/dashboard'),
			),
			array(
				'label'=>'<i></i> Timeline', 
				'linkOptions'=>array(
					'id'=>'my-timeline-menu-item',
				),
				'url'=>array('my/timeline'),
			),
		);
	}
}