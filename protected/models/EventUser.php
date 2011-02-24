<?php

/**
 * This is the model class for table "event_user".
 *
 * The followings are the available columns in table 'event_user':
 * @property integer $id
 * @property integer $eventId
 * @property integer $userId
 * @property string $status
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Event $event
 * @property User $user
 */
class EventUser extends CActiveRecord
{
	const STATUS_ATTENDING = 'Attending';
	const STATUS_NOT_ATTENDING = 'Not Attending';

	/**
	 * Returns the static model of the specified AR class.
	 * @return EventUser the static model class
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
		return 'event_user';
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
		array('eventId, userId', 'required'),
		array('eventId, userId', 'numerical', 'integerOnly'=>true),
		array('status', 'length', 'max'=>15),
		array('created, modified', 'safe'),

		array('status', 'in', 'range'=>array(
		self::STATUS_ATTENDING,
		self::STATUS_NOT_ATTENDING,
		)
		),
			
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, eventId, userId, status, created, modified', 'safe', 'on'=>'search'),
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
			'event' => array(self::BELONGS_TO, 'Event', 'eventId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'eventId' => 'Event',
			'userId' => 'User',
			'status' => 'Status',
			'created' => 'Initially Responded On',
			'modified' => 'Last Responded On',
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
		$criteria->compare('eventId',$this->eventId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	protected function afterSave() {
		parent::afterSave();
		
		$log = new ActiveRecordLog;
		$log->groupId = $this->event->groupId;
		$log->action = strcasecmp($this->status, self::STATUS_ATTENDING) == 0 ? 'is attending' : 'is not attending';
		$log->model = 'Event';
		$log->modelId = $this->eventId;
		$log->modelAttribute = '';
		$log->userId = Yii::app()->user->id;
		$log->save();
	}
	
	/**
	 * Return a list of the available statuses
	 * @return array of status values
	 */
	public static function getStatuses() {
		return array(self::STATUS_ATTENDING,
			self::STATUS_NOT_ATTENDING);
	}
	
	public function scopeEvent($eventId)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'eventId = :eventId',
			'params' => array(':eventId' => $eventId),
		));
		return $this;
	}
	
	public function scopeUser($userId)
	{
		$this->getDbCriteria()->mergeWith(array(
			'condition'=>'userId = :userId',
			'params' => array(':userId' => $userId),
		));
		return $this;
	}
	
	/**
	 * Set an event user status for the current event and user
	 * @param int $eventId
	 * @param String $status
	 * @return EventUser new or updated EventUser object
	 */
	public function setRSVP($eventId, $userId, $status) {
		//look up if RSVP already exists
		$eventuser = EventUser::model()
			->scopeEvent($eventId)
			->scopeUser($userId)
			->find();
		if(is_null($eventuser)) { 
			//if not exist, create new RSVP
			$eventuser = new EventUser;
		}
		
		//set RSVP status
		$eventuser->eventId = $eventId;
		$eventuser->userId = $userId;
		$eventuser->status = $status;
		if(!$eventuser->save()) {
			var_dump( $eventuser->getErrors());
		}
			
		Yii::app()->user->setFlash('success', 'You have replied that you are '. strtolower($status) . '.');
		$this->refresh();
		return $eventuser;
	}
}