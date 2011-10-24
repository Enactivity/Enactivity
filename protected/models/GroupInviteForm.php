<?php
/**
 * RegistrationForm class.
 * RegistrationForm is the data structure for keeping
 * user registration form data. It is used by the 'registration' action of 'UserController'.
 * @property integer $groupId
 * @property string $emails
 */
class GroupInviteForm extends CFormModel {
	
	/**
	 * @var int
	 */
	public $groupId;
	
	/**
	 * @var string
	 */
	public $emails;
	
	public function rules() {
		return array(
			array('groupId, emails', 'required'),
			
			// trim inputs
			array('emails', 'filter', 'filter'=>'trim'),
			
			array('groupId', 'validateGroupId'),
			array('emails', 'validateEmails'),
		);
	}
	
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'groupId'=>'Group',
			'emails'=>'Emails',
		);
	}
	
	/**
	 * Validate that the group id is an existing group
	 * @param string $attribute
	 * @param array $params
	 */
	public function validateGroupId($attribute, $params) {
		if(is_null(Group::model()->findByPk($this->$attribute))) {
			$this->addError($attribute, 'Group must be valid');	
		}
	}
	
	/**
	 * Validate that each email in the emails list is a valid 
	 * email.
	 * @param string $attribute
	 * @param array $params
	 */
	public function validateEmails($attribute, $params) {
		$emails = $this->splitEmails($this->$attribute);
		foreach ($emails as $email) {
			$validator = new CEmailValidator;
			if(!$validator->validateValue($email))
			{
				$this->addError($attribute, $email . ' is not a valid email address.');
			}
		}
	}
	
	/**
	 * Split the emails 
	 * @param string $emails
	 * @param array an array containing substrings
	 */
	public function splitEmails($emails) {
		$uncheckedEmails = preg_split('/[\s,;]+/', trim($emails));
		$checkedEmails = array();
		foreach($uncheckedEmails as $email) {
			if('' != $email) {
				$checkedEmails[] = $email;
			}
		}
		return $checkedEmails;
	}
	
	/**
	 * Sets the values of the group id to be the user's current 
	 * group if the user is only in one group
	 * 
	 * @param CModelEvent event parameter
	 */
	public function onBeforeValidate($event) {
		if (($this->groupId == null)
		&& (Yii::app()->user->model->groupsCount == 1)) {
			
			$this->groupId = $this->getUserGroupId();
		}
	}
	
	/**
	 * Invite user to group specified in form
	 * @return true if successful
	 * @throws CHttpException
	 */
	public function inviteUsers() {
		// array to capture results
		$successfulEmails = array();
		$alreadyMemberEmails = array();
		
		foreach($this->splitEmails($this->emails) as $email) {
			$user = User::model()->findByAttributes(array('email' => $email));
		
			if(is_null($user)) {
				//Create a new user with the email invite
				$user = new User;
				if(!$user->inviteUser($email)) {
					throw new CHttpException(500, 'There was an error when trying to generate invites. Please try again later.');
				}
			}
		
			// Get group
			$group = Group::model()->findByPk($this->groupId);
		
			if(!GroupUser::model()->isGroupMember($group->id, $user->id)) {
				$groupuser = new GroupUser();
				$groupuser->inviteGroupUser($group->id, $user->id);
		
				// Send email
				$successfulEmails[] = $user->email;
			}
			else {
				$alreadyMemberEmails[] = $user->email;
			}
		}
		if(!empty($successfulEmails)) {
			Yii::app()->user->setFlash('success', 'Your invitation has been sent to ' . implode(', ', $successfulEmails));
		}
		if(!empty($alreadyMemberEmails)) {
			Yii::app()->user->setFlash('notice', implode(', ', $alreadyMemberEmails) . ' is/are already a member of the group');
		}
		if(sizeof($successfulEmails) > 0) {
			return true;
		}
		return false;
	}
	
	/**
	 * Returns the user's one user group
	 * @return int id
	 */
	protected function getUserGroupId() {
		if(Yii::app()->user->model->groupsCount == 1) {
			return Yii::app()->user->model->groups[0]->id;
		}
		throw new Exception("Error when attempting to set user group.");
	}
	
}