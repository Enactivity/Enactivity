<?php

/**
 * This is the model class for table "group".
 *
 * The followings are the available columns in table 'group':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property GroupUser[] $groupUsers
 * @property User[] $users
 */
class Group extends CActiveRecord
{
	const NAME_MAX_LENGTH = 255;
	const NAME_MIN_LENGTH = 3;
	
	const SLUG_MAX_LENGTH = 255;
	const SLUG_MIN_LENGTH = 3;
	
	const EMAIL_MAX_LENGTH = 50;
	const EMAIL_MIN_LENGTH = 5;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Group the static model class
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
		return 'group';
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
			'DateTimeZoneBehavior'=>array(
				'class' => 'ext.behaviors.DateTimeZoneBehavior',
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
		array('name, slug', 'required'),
		array('name', 'length', 'max'=>255),
		array('slug', 'length', 'max'=>50),
		
		// trim inputs
		array('name, slug', 'filter', 'filter'=>'trim'),
		array('name, slug', 'unique', 'allowEmpty' => false, 
			'caseSensitive'=>false),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, name, slug, created, modified', 'safe', 'on'=>'search'),
		);
		//FIXME: users can use restricted words for slug
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'groupUsers' => array(self::HAS_MANY, 'GroupUser', 'groupId'),
			'groupUsersActive' => array(self::HAS_MANY, 'GroupUser', 'groupId',
				'condition' => 'status="' . GroupUser::STATUS_ACTIVE .'"'),
			'groupUsersActiveCount' => array(self::STAT, 'GroupUser', 'groupId', 
				'condition' => 'status="' . GroupUser::STATUS_ACTIVE .'"'),
			'groupUsersPending' => array(self::HAS_MANY, 'GroupUser', 'groupId',
				'condition' => 'status="' . GroupUser::STATUS_PENDING .'"'),
			'groupUsersPendingCount' => array(self::STAT, 'GroupUser', 'groupId', 
				'condition' => 'status="' . GroupUser::STATUS_PENDING .'"'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Group',
			'name' => 'Name',
			'slug' => 'Slug',
			'created' => 'Created',
			'modified' => 'Last modified',
			'groupUsersActiveCount' => 'Number of Active Users',
			'groupUsersPendingCount' => 'Number of Pending Users',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function defaultScope() {
		return array(
			'order' => 'name ASC',
		);
	}
	
	/**
	 * @see CActiveRecord::beforeValidate()
	 */
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			//lowercase unique values
			$this->slug = strtolower($this->slug);
			return true;

		}
		return false;
	}
	
	/**
	 * Find a group by its slug attribute
	 * @param string $slug
	 * @return group model or null if none is found
	 */
	public function findBySlug($slug) {
		return Group::model()->findByAttributes(
				array(
					'slug'=>$slug,
				)
		);
	}
	
	/**
	 * Get the url for viewing this group
	 */
	public function getPermalink()
	{
		if(!empty($this->slug)) {
			return Yii::app()->request->hostInfo .
			Yii::app()->getBaseUrl() .
			"/" . $this->slug;
		}
		return Yii::app()->request->hostInfo .
			Yii::app()->createUrl('group/view', 
			array(
            	'id'=>$this->id,
			)
		);
	}
	
	/**
	 * Get the list of Active users in this group filtered by 
	 * group status
	 * @param int $groupId
	 * @param String $status
	 * @return IDataProvider
	 */
	public function getMembersByStatus($groupStatus) {
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		
		$dataProvider= $model->search();
		$dataProvider->criteria->addCondition(
			'id IN (SELECT userId AS id FROM group_user' 
				. ' WHERE groupId=:groupId' 
				. ' AND status = :groupStatus)'
		);
		$dataProvider->criteria->params[':groupId'] = $this->id;
		$dataProvider->criteria->params[':groupStatus'] = $groupStatus;
		
		// ensure only active users are returned
		$dataProvider->criteria->addCondition('status = :userStatus');
		$dataProvider->criteria->params[':userStatus'] = User::STATUS_ACTIVE;
		
		$dataProvider->criteria->order = 'firstName ASC';
		
		return $dataProvider;
	}
}