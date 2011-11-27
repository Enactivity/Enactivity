<?php
/**
 * Class file for MenuDefinitions
 * @author Ajay Sharma
 */

/**
 * Used to define the menus in Poncla
 * @see CMenu
 * @author Ajay Sharma
 */
class MenuDefinitions extends CComponent {

	public static function site() {
		return null;
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
	 * @param Group $model Group currently under scrutiny
	 * @return array of menu items for groups
	 */
	public static function group() {
		return array(
			array(
				'label'=>'View Groups', 
				'linkOptions'=>array(
					'class'=>'groups',
				),
				'url'=>array('/group/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Invite People', 
				'url'=>array('group/invite'),
				'linkOptions'=>array('id'=>'group-invite-nav-item'),
			),
		);
	}
	
	/**
	 * @return array of menu items
	 */
	public static function task() {
		return array(
			array(
				'label'=>'Dashboard', 
				'url'=>array('/task/index'), 
			),
			array(
				'label'=>'Calendar', 
				'url'=>array('/task/calendar'), 
			),
		);
	}
	
	/**
	 * @param User $model User current under scrutiny
	 * @return array of menu items for user controller
	 */
	public static function user() {
		return null;
	}
	
	/**
	 * @return array of menu items for user controller
	 */
	public static function settings() {

		$menu = array();
		$menu[] = array('label'=>'Update Profile', 
			'url'=>array('user/update'),
			'linkOptions'=>array('id'=>'user-update-profile-nav-item'), 
		);
		$menu[] = array('label'=>'Update Password', 
			'url'=>array('user/updatepassword'),
			'linkOptions'=>array('id'=>'user-update-password-nav-item'), 
		);
		
		$menu = array_merge($menu, self::adminMenu());
		
		$menu[] = array(
			'label'=>'Logout', 
			'url'=>array('/site/logout'), 
			'visible'=>!Yii::app()->user->isGuest
		);
		
		return $menu;
	}
	
	/**
	 * @return array main menu items
	 */
	public static function globalMenu() {
		return array(
			array(
				'label'=>'P', 
				'itemOptions'=>array(
					'class'=>'poncla-logo',
				),
				'url'=>array('/site/index'), 
				'visible'=>Yii::app()->user->isGuest
			),
			array(
				'label'=>'P', 
				'itemOptions'=>array(
					'class'=>'poncla-logo',
				),
				'url'=>array('/task/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Tasks',
				'itemOptions'=>array(
					'class'=>'dropdown',
				),
				'items'=>self::task(),
				'linkOptions'=>array(
					'class'=>'dropdown-toggle',
				),
				'url'=>array('/task/index'), 
				'visible'=>!Yii::app()->user->isGuest,
			),
			array(
				'label'=>'Groups', 
				'itemOptions'=>array(
					'class'=>'dropdown',
				),
				'items'=>self::group(),
				'linkOptions'=>array(
					'class'=>'dropdown-toggle',
				),
				'url'=>array('/group/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),			
			array(
				'label'=>'Settings',
				'itemOptions'=>array(
					'class'=>'dropdown',
				),
				'items'=>self::settings(),
				'linkOptions'=>array(
					'class'=>'dropdown-toggle',
				),
				'url'=>array('/site/settings'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Login', 
				'url'=>array('/site/login'), 
				'visible'=>Yii::app()->user->isGuest
			),
		);
	}
}