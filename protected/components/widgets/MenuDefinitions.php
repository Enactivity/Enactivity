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
				'label'=>'<i></i>Next', 
				'linkOptions'=>array(
					'id'=>'application-navigation-task-index',
				),
				'url'=>array('/task/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'<i></i>Calendar',
				'linkOptions'=>array(
					'id'=>'application-navigation-task-calendar',
				),
				'url'=>array('/task/calendar'), 
				'visible'=>!Yii::app()->user->isGuest,
			),
			array(
				'label'=>'<i></i>Groups', 
				'linkOptions'=>array(
					'id'=>'application-navigation-membership-index',
				),
				'url'=>array('/membership/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'<i></i>New',
				'linkOptions'=>array(
					'id'=>'application-navigation-task-create',
				),
				'url'=>array('/task/create'), 
				'visible'=>!Yii::app()->user->isGuest,
			),
			array(
				'label'=>'Admin',
				'linkOptions'=>array(
					'id'=>'application-navigation-site-admin',
				),
				'url'=>array('site/admin'),
				'visible'=>Yii::app()->user->isAdmin
			),
			array(
				'label'=>'<i></i>Sign in with Facebook',
				'linkOptions'=>array(
					'id'=>'application-navigation-facebook-login',
				),
				'itemOptions'=>array(
					'class'=>'secondary',
				),
				'url'=>Yii::app()->FB->loginUrl,
				'visible'=>Yii::app()->user->isGuest
			),
		);
	}
	
	/**
	 * @return array of menu items for admins
	 */
	public static function adminMenu() {
		return array(
			array(
				'label'=>'Create Group', 
				'url'=>array('group/create'),
				'linkOptions'=>array('id'=>'group-create-nav-item'), 
				'visible'=>Yii::app()->user->isAdmin
			),
			array(
				'label'=>'Manage Groups', 
				'url'=>array('group/admin'), 
				'linkOptions'=>array('id'=>'group-manage-nav-item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
			array(
				'label'=>'Manage Store', 
				'url'=>array('store/admin'), 
				'linkOptions'=>array('id'=>'store-manage-nav-item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
			array(
				'label'=>'Manage Users', 
				'url'=>array('user/admin'),
				'linkOptions'=>array('id'=>'user-admin-nav-item'), 
				'visible'=>Yii::app()->user->isAdmin
			),
			array(
				'label'=>'Manage Tasks', 
				'url'=>array('task/admin'), 
				'linkOptions'=>array('id'=>'task-admin-nav-item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
			array(
				'label'=>'Manage Comments', 
				'url'=>array('comment/admin'), 	
				'linkOptions'=>array('id'=>'comment-admin-nav-item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
			array(
				'label'=>'Manage Feed', 
				'url'=>array('feed/admin'), 	
				'linkOptions'=>array('id'=>'feed-admin-nav-item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
		);
	}
	
	public static function comment() {
		return null;
	}
	
	public static function feed() {
		return null;
	}
	
	/**
	 * @return array of menu items
	 */
	public static function task() {
		return null;
	}
	
	/**
	 * @param User $model User current under scrutiny
	 * @return array of menu items for user controller
	 */
	public static function user() {
		return null;
	}
}