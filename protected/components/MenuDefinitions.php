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
				'label'=>'Manage Goals', 
				'url'=>array('goal/admin'), 
				'linkOptions'=>array('id'=>'goal_manage_menu_item'),
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

	public static function task() {
		return array();
	}
	
	/**
	 * @param Task $model Task currently under scrutiny
	 * @return array of menu items for tasks
	 */
	public static function taskMenu($model = null) {
		if(isset($model)) {
			$menu[] = array(
				'label'=>'Update This Task', 
				'url'=>array('task/update', 'id'=>$model->id),
				'linkOptions'=>array('id'=>'task_update_menu_item'),
			);
			
			// 'participate' button
			if($model->isUserParticipating()) {
				$menu[] = array(
					'label'=>'Stop participating', 
					'url'=>array('task/unparticipate', 'id'=>$model->id),
					'linkOptions'=>array(
						'submit'=>array(
							'task/unparticipate',
							'id'=>$model->id,
						),
						'csrf' => true,
						'id'=>'task_unparticipate_menu_item' . $model->id,
					),
				);
			}
			else {
				$menu[] = array(
					'label'=>'Participate', 
					'url'=>array('task/participate', 'id'=>$model->id),
					'linkOptions'=>array(
						'submit'=>array(
							'task/participate',
							'id'=>$model->id,
						),
						'csrf' => true,
						'id'=>'task_unparticipate_menu_item' . $model->id,
					),
				);
			}
			
//			// only show when there is no owner
//			if($model->ownerId == null) {
//				$menu[] = array(
//					'label'=>'Take Ownership', 
//					'url'=>array('task/own', 'id'=>$model->id),
//					'linkOptions'=>array(
//						'submit'=>array(
//							'task/own',
//							'id'=>$model->id,
//						),
//						'csrf' => true,
//						'id'=>'task_owner_menu_item' . $model->id,
//					),
//				);
//			}
//			elseif($model->ownerId == Yii::app()->user->id) {
//				$menu[] = array(
//					'label'=>'Give Up Ownership', 
//					'url'=>array('task/unown', 'id'=>$model->id),
//					'linkOptions'=>array(
//						'submit'=>array(
//							'task/unown',
//							'id'=>$model->id,
//						),
//						'csrf' => true,
//						'id'=>'task_owner_menu_item' . $model->id,
//					),
//				);
//			}
//			
//			if($model->ownerId == null 
//			|| $model->ownerId == Yii::app()->user->id) {
//				if($model->isCompleted) {
//					$menu[] = array(
//						'label'=>'Mark Not Done', 
//						'url'=>array('task/uncomplete', 'id'=>$model->id),
//						'linkOptions'=>array(
//							'submit'=>array(
//								'task/uncomplete',
//								'id'=>$model->id,
//							),
//							'csrf' => true,
//							'id'=>'task_uncomplete_menu_item' . $model->id,
//						),
//					);
//				}
//				else {
//					$menu[] = array(
//						'label'=>'Mark Done', 
//						'url'=>array('task/complete', 'id'=>$model->id),
//						'linkOptions'=>array(
//							'submit'=>array(
//								'task/complete',
//								'id'=>$model->id,
//							),
//							'csrf' => true,
//							'id'=>'task_complete_menu_item' . $model->id,
//						),
//					);
//				}
				
				if($model->isTrash) {
					$menu[] = array(
						'label'=>'UnTrash', 
						'url'=>array('task/untrash', 'id'=>$model->id),
						'linkOptions'=>array(
							'submit'=>array(
								'task/untrash',
								'id'=>$model->id,
							),
							'csrf' => true,
							'id'=>'task_untrash_menu_item' . $model->id,
						),
					);
				}
				else {
					$menu[] = array(
						'label'=>'Trash', 
						'url'=>array('task/trash', 'id'=>$model->id),
						'linkOptions'=>array(
							'submit'=>array(
								'task/trash',
								'id'=>$model->id,
							),
							'confirm'=>'Are you sure you want to trash this item?',
							'csrf' => true,
							'id'=>'task_trash_menu_item' . $model->id,
						),
					);
				}	
			}

//		}
		
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
				'url'=>array('/site/index'),
				'visible'=>Yii::app()->user->isGuest
			),
			array(
				'label'=>'What\'s Next', 
				'url'=>array('/task/whatsnext'),
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'What\'s On', 
				'url'=>array('/task/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Feed', 
				'url'=>array('/feed/index'),
				'visible'=>!Yii::app()->user->isGuest
			),
			array(
				'label'=>'Groups', 
				'url'=>array('/group/index'), 
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