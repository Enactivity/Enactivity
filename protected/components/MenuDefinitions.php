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
				'linkOptions'=>array('id'=>'group_create_menu_item'), 
				'visible'=>Yii::app()->user->isAdmin
			),
			array(
				'label'=>'Manage Groups', 
				'url'=>array('group/admin'), 
				'linkOptions'=>array('id'=>'group_manage_menu_item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
			array(
				'label'=>'Manage Users', 
				'url'=>array('user/admin'),
				'linkOptions'=>array('id'=>'user_admin_menu_item'), 
				'visible'=>Yii::app()->user->isAdmin
			),
			array(
				'label'=>'Manage Events', 
				'url'=>array('event/admin'), 
				'linkOptions'=>array('id'=>'event_admin_menu_item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
			array(
				'label'=>'Manage EventBanter', 
				'url'=>array('eventbanter/admin'), 
				'linkOptions'=>array('id'=>'event_manage_menu_item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
			array(
				'label'=>'Manage GroupBanter', 
				'url'=>array('groupbanter/admin'), 
				'linkOptions'=>array('id'=>'group_manage_menu_item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
		);
	} 
	
	/**
	 * @param Event $model Event currently under scrutiny
	 * @return array of menu items for events
	 */
	public static function event() {
		return array(
			array(
				'label'=>'Create an Event', 
				'url'=>array('event/create'),
				'linkOptions'=>array('id'=>'event_create_menu_item'),
			),
			array(
				'label'=>'Calendar',
				'url'=>array('event/calendar', 
					'month' => date('m'), 
					'year' => date('Y'),
				),
				'linkOptions'=>array('id'=>'event_calendar_menu_item'),
			),	
		);
	}
	
	/**
	 * @return array of menu items for EventBanters
	 */
	public static function eventBanter() {
		return null;
	}
	
	/**
	 * @param Event $model Event currently under scrutiny
	 * @return array of menu items for events
	 */
	public static function eventMenu($model = null) {
		if(isset($model)) {
			$menu[] = array(
				'label'=>'Update This Event', 
				'url'=>array('event/update', 'id'=>$model->id),
				'linkOptions'=>array('id'=>'event_update_menu_item'),
			);
			$menu[] = array(
				'label'=>'Delete This Event', 
				'url'=>'#', 
				'linkOptions'=>array('submit'=>array(
					'event/delete',
					'id'=>$model->id,
				),
				'confirm'=>'Are you sure you want to delete this item?',
					'csrf' => true,
					'id'=>'event_delete_menu_item',
				),
			);
		}
		
		return $menu;
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
				'label'=>'Invite a User', 
				'url'=>array('group/invite'),
				'linkOptions'=>array('id'=>'group_invite_menu_item'),
			),
		);
	}
	
/**
	 * @param Group $model Group currently under scrutiny
	 * @return array of menu items for groups
	 */
	public static function groupMenu($model = null) {
		
		if(isset($model->id)) {
			$menu[] = array(
				'label'=>'Update This Group', 
				'url'=>array('group/updateprofile','id'=>$model->id),
				'linkOptions'=>array('id'=>'group_profile_menu_item'),
			);
		}
		
		return $menu;
	}
	
	/**
	 * @param GroupBanter $model GroupBanter current under scrutiny
	 * @return array of menu items for GroupBanters
	 */
	public static function groupBanter() {
		return null;
	}
	
	/**
	 * @param GroupBanter $model GroupBanter current under scrutiny
	 * @return array of menu items for GroupBanters
	 */
	public static function groupBanterMenu($model = null) {
		$menu = null;
		
		if(isset($model)
			&& Yii::app()->user->id == $model->creatorId) {
				
			$menu = array();
			$menu[] = array(
				'label'=>'Update', 
				'url'=>array('groupbanter/update', 'id'=>$model->id),
				'visible'=>Yii::app()->user->id == $model->creatorId,
			);
			
			$menu[] = array(
				'label'=>'Delete', 
				'url'=>'#', 
				'linkOptions'=>array('submit'=>array(
					'groupbanter/delete',
					'id'=>$model->id,
				),
				'confirm'=>'Are you sure you want to delete this item?',
					'csrf' => true,
					'id'=>'groupbanter_delete_menu_item',
				),
				'visible'=>Yii::app()->user->id == $model->creatorId,
			);
		}
		
		return $menu;
	}
	
	/**
	 * @param User $model User current under scrutiny
	 * @return array of menu items for user controller
	 */
	public static function user() {
		return null;
	}
	
/**
	 * @param User $model User current under scrutiny
	 * @return array of menu items for user controller
	 */
	public static function userMenu($model = null) {
		$menu = null;
		
		if(isset($model)
			&& Yii::app()->user->id == $model->id) {
				
			$menu = array();
			$menu[] = array('label'=>'Update Profile', 
				'url'=>array('user/update', 'id'=>$model->id),
				'linkOptions'=>array('id'=>'user_update_menu_item'), 
				'visible'=>Yii::app()->user->id == $model->id,
			);
			$menu[] = array('label'=>'Update Password', 
				'url'=>array('user/updatepassword', 'id'=>$model->id),
				'linkOptions'=>array('id'=>'user_update_menu_item'), 
				'visible'=>Yii::app()->user->id == $model->id,
			);
		}
		
		return $menu;
	}
	
	/**
	 * @return array main menu items
	 */
	public static function globalMenu() {
		return array(
			array(
				'label'=>'Home:Beta', 
				'url'=>array('/site/index')
			),
			array(
				'label'=>'Feed', 
				'url'=>array('/feed/index')
			),
			array(
				'label'=>'Groups', 
				'url'=>array('/group/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Events', 
				'url'=>array('/event/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Banter', 
				'url'=>array('/groupbanter/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Settings', 
				'url'=>array('/site/settings'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Login', 
				'url'=>array('/site/login'), 
				'visible'=>Yii::app()->user->isGuest
			),
			array(
				'label'=>'Logout ('.Yii::app()->user->model->firstName.')', 
				'url'=>array('/site/logout'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Admin', 
				'url'=>array('/group/create'), 
				'visible'=>Yii::app()->user->isAdmin
			),
		);
	}
}