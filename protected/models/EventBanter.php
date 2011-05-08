<?php

/**
 * This is the model class for table "event_banter".
 *
 * The followings are the available columns in table 'event_banter':
 * @property integer $id
 * @property integer $creatorId
 * @property integer $eventId
 * @property string $content
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Event $event
 * @property User $creator
 */
class EventBanter extends CActiveRecord
{
	const CONTENT_MAX_LENGTH = 4000;
	
	const SCENARIO_REPLY = 'reply';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return EventBanter the static model class
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
		return 'event_banter';
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
			array('creatorId, eventId, content', 'required'),
			array('creatorId, eventId', 'numerical', 'integerOnly'=>true),
			
			// trim inputs
			array('content', 'filter', 'filter'=>'trim'),
			array('content', 'length', 'max'=>self::CONTENT_MAX_LENGTH),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, creatorId, eventId, content, created, modified', 'safe', 'on'=>'search'),
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
			'creator' => array(self::BELONGS_TO, 'User', 'creatorId'),
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
			'eventId' => 'Event',
			'content' => 'Thoughts',
			'created' => 'Posted',
			'modified' => 'Last modified',
		);
	}
	
	public function scenarioLabels() {
		return array(
			self::SCENARIO_REPLY => 'replied',
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
		$criteria->compare('eventId',$this->eventId);
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
	
	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				$this->creatorId = Yii::app()->user->id;	
			}
			
			return true;
		}
		return false;
	}
	
	protected function afterSave() {
		parent::afterSave();
		
		$log = new ActiveRecordLog;
		$log->groupId = $this->event->groupId;
		$log->action = 'replied to';
		$log->model = 'Event';
		$log->modelId = $this->eventId;
		$log->modelAttribute = '';
		$log->userId = Yii::app()->user->id;
		$log->save();
	}
}