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
	const NAME_MAX_LENGTH = 75;
	const NAME_MIN_LENGTH = 3;
	
	const DESCRIPTION_MAX_LENGTH = 4000;
	
	const LOCATION_MAX_LENGTH = 255;
	
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
		array('name, groupId, starts, ends', 'required'),
		array('creatorId, groupId', 'numerical', 'integerOnly'=>true),
		array('name', 'length', 'max'=>self::NAME_MAX_LENGTH),
		array('description', 'length', 'max'=>self::DESCRIPTION_MAX_LENGTH),
		array('location', 'length', 'max'=>self::LOCATION_MAX_LENGTH),
		array('created, modified', 'safe'),
		
		array('ends', 'validateDateAfter', 'beforeDate'=>'starts'),

		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, name, description, creatorId, groupId, starts, ends, location, created, modified', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * Validate that the given date comes after the specified
	 * 'beforeDate'
	 * @param string $attribute the attribute to test
	 * @param array $params
	 * @return boolean true if date comes after parameter date, false otherwise
	 */
	public function validateDateAfter($attribute, $params) {
		$ends = $this->$attribute;
		$starts = $this->$params['beforeDate'];
		
		$ends = strtotime($ends);
		$starts = strtotime($starts);
		
		if($ends < $starts) {
			$this->addError($attribute, 'End time cannot be before start time.');
		}
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
			'name' => 'Summary',
			'description' => 'Details',
			'creatorId' => 'Created by',
			'groupId' => 'Group',
			'starts' => 'Starts',
			'ends' => 'Ends',
			'location' => 'Location',
			'created' => 'Created',
			'modified' => 'Last modified',
			'datesAsSentence' => 'When',
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

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			// Format start and end datetimes into SQL datetimes
			$this->starts = date("Y-m-d H:i:s",  strtotime($this->starts));
			$this->ends = date("Y-m-d H:i:s",  strtotime($this->ends));
			
			if($this->isNewRecord)
			{
				// Set current user as creator 
				$this->creatorId = Yii::app()->user->id;
			}
			return true;
		}
		return false;
	}
	
	/**
	 * Returns the dates in the form of a sentence 
	 * @return string the dates in the form of a sentence 
	 */
	public function getDatesAsSentence() {
		$date = Yii::app()->dateformatter->formatDateTime($this->starts, 
			'full', 'short'); 
		$date .= " - ";
		$date .= Yii::app()->dateformatter->formatDateTime($this->ends, 
			'long', 'short');
		return $date;
	}
	
	/**
	 * Get the list of users who have RSVPed with the given
	 * status value
	 * @param String $status
	 * @return CActiveDataProvider of User models
	 */
	public function getAttendeesByStatus($eventStatus) {
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		
		$dataProvider = $model->search();
		
		// search for users mapped to event with the status
		$dataProvider->criteria->addCondition(
			'id IN (SELECT userId AS id FROM ' . EventUser::model()->tableName()
				. ' WHERE eventId=:eventId' 
				. ' AND status =:eventStatus)'
		);
		$dataProvider->criteria->params[':eventId'] = $this->id;
		$dataProvider->criteria->params[':eventStatus'] = $eventStatus;
		
		// ensure only active users are returned
		$dataProvider->criteria->addCondition('status = :userStatus');
		$dataProvider->criteria->params[':userStatus'] = User::STATUS_ACTIVE;
		
		// order by first name
		$dataProvider->criteria->order = 'firstName ASC';
		
		return $dataProvider;
	}
	
	/**
	 * Get a list of events that take place in the future for a given user
	 * @param int $userId
	 * @return CActiveDataProvider of Event models
	 */
	public function getFutureEventsForUser($userId) {
		$this->unsetAttributes();  // clear any default values
		
		$dataProvider = $this->search();
		$dataProvider->criteria->addCondition('id IN (SELECT id FROM ' . $this->tableName() 
			.  ' WHERE groupId IN (SELECT groupId FROM ' . GroupUser::model()->tableName() 
			. ' WHERE userId=:userId))');
		$dataProvider->criteria->params[':userId'] = $userId;
		
		$dataProvider->criteria->addCondition('ends > NOW()');
		
		$dataProvider->criteria->order = 'starts ASC';
		
		return $dataProvider;
	}
	
	/**
	 * Get the event user status for the event and user
	 * @param int $userId
	 * @return EventUser 
	 */
	public function getRSVP($userId) {
		return EventUser::model()->getRSVP($this->id, $userId);
	}
}