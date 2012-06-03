<?php

/**
 * This is the model class for table "group_banter".
 *
 * The followings are the available columns in table 'group_banter':
 * @property integer $id
 * @property integer $creatorId
 * @property integer $groupId
 * @property integer $parentId
 * @property string $content
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property User $creator
 * @property Group $group
 * @property GroupBanter $parent
 * @property GroupBanter[] $replies
 * @property int repliesCount 
 */
class GroupBanter extends CActiveRecord
{
	const CONTENT_MAX_LENGTH = 4000;
	
	const SCENARIO_REPLY = 'reply';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return GroupBanter the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'group_banter';
	}

	/**
	 * @return array behaviors that this model should behave as
	 */
	public function behaviors() {
		return array(
			// Update created and modified dates on before save events
			'CTimestampBehavior'=>array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'created',
				'updateAttribute' => 'modified',
				'setUpdateOnCreate' => true,
			),
			// Set the groupId automatically when user is in only one group
			'DefaultGroupBehavior'=>array(
				'class' => 'ext.behaviors.DefaultGroupBehavior',
			), 
		);
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('creatorId, groupId, content', 'required'),
			array('creatorId, groupId, parentId', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>self::CONTENT_MAX_LENGTH),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, creatorId, groupId, parentId, content, created, modified', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'creator' => array(self::BELONGS_TO, 'User', 'creatorId'),
			'group' => array(self::BELONGS_TO, 'Group', 'groupId'),
			'parent' => array(self::BELONGS_TO, 'GroupBanter', 'parentId'),
			'replies' => array(self::HAS_MANY, 'GroupBanter', 'parentId', 
				'order' => 'replies.created ASC',
			),
			'repliesCount' => array(self::STAT, 'GroupBanter', 'parentId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'creatorId' => 'Posted by',
			'groupId' => 'Group',
			'parentId' => 'Parent',
			'content' => 'Thoughts',
			'created' => 'Posted',
			'modified' => 'Last modified',
			'repliesCount' => 'Replies'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('creatorId',$this->creatorId);
		$criteria->compare('groupId',$this->groupId);
		$criteria->compare('parentId',$this->parentId);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function scopes() {
		return array(
			'parentless'=>array(
				'condition'=>'parentId IS NULL',
    		),
    		'oldestToNewest'=>array(
    			'order' => 'created ASC',
    		),
    		'newestToOldest'=>array(
    			'order' => 'created DESC',
    		),
		);
	}
	
	/**
	 * Scope definition for banters that share group value with
	 * the user's groups 
	 * @param int $userId
	 * @return Group model
	 */
	public function scopeUsersGroups($userId) {
		$this->getDbCriteria()->mergeWith(array(
			'condition' => 'id IN (SELECT id FROM ' . $this->tableName() 
				.  ' WHERE groupId IN (SELECT groupId FROM ' . GroupUser::model()->tableName() 
				. ' WHERE userId=:userId))',
			'params' => array(':userId' => $userId)
		));
		return $this;
	}
	
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				$this->creatorId = Yii::app()->user->id;	
			}
			
			return true;
		}
		return false;
	}
}