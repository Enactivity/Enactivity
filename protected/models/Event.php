<?php

/**
 * This is the model class for table "event".
 *
 * The followings are the available columns in table 'event':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property integer $creatorId
 * @property integer $groupId
 * @property string $starts
 * @property string $ends
 * @property string $location
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property User $creator
 * @property Group $group
 * @property EventUser[] $eventUsers
 * @property EventUser[] $eventUsersAttending
 * @property int $eventUsersAttendingCount
 * @property EventUser[] $eventUsersNotAttending
 * @property int $eventUsersNotAttendingCount
 */
class Event extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Event the static model class
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
		return 'event';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('name, groupId, starts, ends', 'required'),
		array('creatorId, groupId', 'numerical', 'integerOnly'=>true),
		array('name, location', 'length', 'max'=>255),
		array('description', 'length', 'max'=>4000),
		array('created, modified', 'safe'),

		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, name, description, creatorId, groupId, starts, ends, location, created, modified', 'safe', 'on'=>'search'),
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
			'eventUsers' => array(self::HAS_MANY, 'EventUser', 'eventId'),
			'eventUsersAttending' => array(self::HAS_MANY, 'EventUser', 'eventId',
				'condition' => 'status="' . EventUser::STATUS_ATTENDING . '"'),
			'eventUsersAttendingCount' => array(self::STAT, 'EventUser', 'eventId',
				'condition' => 'status="' . EventUser::STATUS_ATTENDING . '"'),
			'eventUsersNotAttending' => array(self::HAS_MANY, 'EventUser', 'eventId',
				'condition' => 'status="' . EventUser::STATUS_NOT_ATTENDING . '"'),
			'eventUsersNotAttendingCount' => array(self::STAT, 'EventUser', 'eventId',
				'condition' => 'status="' . EventUser::STATUS_NOT_ATTENDING . '"'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'creatorId' => 'Creator',
			'groupId' => 'Group',
			'starts' => 'Starts',
			'ends' => 'Ends',
			'location' => 'Location',
			'created' => 'Created',
			'modified' => 'Modified',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('creatorId',$this->creatorId);
		$criteria->compare('groupId',$this->groupId);
		$criteria->compare('starts',$this->starts,true);
		$criteria->compare('ends',$this->ends,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate() {
		if(parent::beforeValidate()) {			
			return true;
		}
		return false;
	}

	protected function afterValidate() {
		if(parent::afterValidate()) {
			return true;
		}
		return false;
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				// Set current user as 
				$this->creatorId = Yii::app()->user->id;
				$this->created = new CDbExpression('NOW()');
				$this->modified = new CDbExpression('NOW()');
			}
			else {
				$this->modified = new CDbExpression('NOW()');
			}
			return true;
		}
		else {
			return false;
		}
	}
}