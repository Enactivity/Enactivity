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
	
	public static function footer() {
		return array(
			array(
				'label'=>PHtml::encode('@Poncla'), 
				'url'=>'http://twitter.com/#!/poncla',
				'linkOptions'=>array('id'=>'twitter-menu-item'), 
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
				'linkOptions'=>array('id'=>'group-create-menu-item'), 
				'visible'=>Yii::app()->user->isAdmin
			),
			array(
				'label'=>'Manage Groups', 
				'url'=>array('group/admin'), 
				'linkOptions'=>array('id'=>'group-manage-menu-item'),
				'visible'=>Yii::app()->user->isAdmin,
			),
			array(
				'label'=>'Manage Users', 
				'url'=>array('user/admin'),
				'linkOptions'=>array('id'=>'user-admin-menu-item'), 
				'visible'=>Yii::app()->user->isAdmin
			),
			array(
				'label'=>'Manage Tasks', 
				'url'=>array('task/admin'), 
				'linkOptions'=>array('id'=>'task-admin-menu-item'),
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
				'label'=>'Invite People', 
				'url'=>array('group/invite'),
				'linkOptions'=>array('id'=>'group-invite-menu-item'),
			),
		);
	}
	
	/**
	 * @param Group $model Group currently under scrutiny
	 * @return array of menu items for groups
	 */
	public static function groupMenu($model = null) {
		return array();
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
				'label'=>'Update', 
				'url'=>array('task/update', 'id'=>$model->id),
				'linkOptions'=>array(
					'id'=>'task-update-menu-item-' . $model->id,
					'class'=>'task-update-menu-item',
					'title'=>'Update this task',
				),
			);
			
			// 'participate' button
			if($model->isUserParticipating) {
				$menu[] = array(
					'label'=>'Quit', 
					'url'=>array('task/unparticipate', 'id'=>$model->id),
					'linkOptions'=>array(
						'submit'=>array(
							'task/unparticipate',
							'id'=>$model->id,
						),
						'csrf' => true,
						'id'=>'task-useruncomplete-menu-item-' . $model->id,
						'class'=>'task-useruncomplete-menu-item',
						'title'=>'Resume work on this task',
					),
				);
			}
			else {
				$menu[] = array(
					'label'=>'Sign up', 
					'url'=>array('task/participate', 'id'=>$model->id),
					'linkOptions'=>array(
						'submit'=>array(
							'task/participate',
							'id'=>$model->id,
						),
						'csrf' => true,
						'id'=>'task-participate-menu-item-' . $model->id,
						'class'=>'task-participate-menu-item',
						'title'=>'Sign up for task',
					),
				);
			}
			
			if($model->isTrash) {
				$menu[] = array(
					'label'=>'Restore', 
					'url'=>array('task/untrash', 'id'=>$model->id),
					'linkOptions'=>array(
						'submit'=>array(
							'task/untrash',
							'id'=>$model->id,
						),
						'csrf' => true,
						'id'=>'task-untrash-menu-item-' . $model->id,
						'class'=>'task-untrash-menu-item',
						'title'=>'Restore this task',
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
						'id'=>'task-trash-menu-item-' . $model->id,
						'class'=>'task-trash-menu-item',
						'title'=>'Trash this task',
					),
				);
			}	
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
				'linkOptions'=>array('id'=>'user-update-menu-item'), 
				'visible'=>Yii::app()->user->id == $model->id,
			);
			$menu[] = array('label'=>'Update Password', 
				'url'=>array('user/updatepassword', 'id'=>$model->id),
				'linkOptions'=>array('id'=>'user-update-menu-item'), 
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
// 			array(
// 				'label'=>'Home:Beta', 
// 				'url'=>array('/site/index'),
// 				'visible'=>Yii::app()->user->isGuest
// 			),
// 			array(
// 				'label'=>'What\'s Next', 
// 				'url'=>array('/task/whatsnext'),
// 				'visible'=>!Yii::app()->user->isGuest
// 			),
			array(
				'label'=>'Tasks', 
				'url'=>array('/task/index'), 
				'visible'=>!Yii::app()->user->isGuest
			),
// 			array(
// 				'label'=>'Goings on', 
// 				'url'=>array('/feed/index'),
// 				'visible'=>!Yii::app()->user->isGuest
// 			),
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
				'label'=>'Logout', 
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