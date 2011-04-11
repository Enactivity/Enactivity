<?php

/**
 * This is the model class for table "goal".
 *
 * The followings are the available columns in table 'goal':
 * @property integer $id
 * @property string $name
 * @property integer $groupId
 * @property integer $ownerId
 * @property integer $isCompleted
 * @property integer $isTrash
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property User $owner
 * @property Group $group
 * @property Task[] $tasks
 */
class Goal extends CActiveRecord
{
	const NAME_MAX_LENGTH = 255;
	
	const SCENARIO_CREATE = 'create';
	const SCENARIO_READ = 'read';
	const SCENARIO_UPDATE_NAME = 'update name';
	const SCENARIO_TRASH = 'trash';
	const SCENARIO_UNTRASH = 'untrash';
	const SCENARIO_COMPLETE = 'complete';
	const SCENARIO_NOTCOMPLETE = 'uncomplete';
	const SCENARIO_SET_OWNER = 'set ownership';
	const SCENARIO_UNSET_OWNER = 'unset ownership';
	const SCENARIO_DELETE = 'delete';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return Goal the static model class
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
		return 'goal';
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
			// Record C-UD operations to this record
			'ActiveRecordLogBehavior'=>array(
				'class' => 'ext.behaviors.ActiveRecordLogBehavior',
				'feedAttribute' => $this->name,
				'ignoreAttributes' => array('modified'),
			)
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
			array('name, groupId', 'required'),
			
			// integer only values
			array('groupId, ownerId, isCompleted, isTrash', 'numerical', 'integerOnly'=>true),
			
			// not/complete scenario
			array('isCompleted', 'required', 'on' => array(self::SCENARIO_COMPLETE, self::SCENARIO_NOTCOMPLETE)),
			
			// un/set owner scenario
			array('ownerId', 'required', 'on' => array(self::SCENARIO_SET_OWNER, self::SCENARIO_UNSET_OWNER)),
			
			// un/trash scenario
			array('isTrash', 'required', 'on' => array(self::SCENARIO_TRASH, self::SCENARIO_UNTRASH)),
			
			array('name', 'length', 'max'=>self::NAME_MAX_LENGTH),
			array('name', 'filter', 'filter'=>'trim'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, groupId, ownerId, isCompleted, isTrash, created, modified', 'safe', 'on'=>'search'),
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
			'owner' => array(self::BELONGS_TO, 'User', 'ownerId'),
			'group' => array(self::BELONGS_TO, 'Group', 'groupId'),
			'tasks' => array(self::HAS_MANY, 'Task', 'goalId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Id',
			'name' => 'Name',
			'groupId' => 'Group',
			'ownerId' => 'Owner',
			'isCompleted' => 'Is Completed',
			'isTrash' => 'Is Trash',
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
		$criteria->compare('groupId',$this->groupId);
		$criteria->compare('ownerId',$this->ownerId);
		$criteria->compare('isCompleted',$this->isCompleted);
		$criteria->compare('isTrash',$this->isTrash);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}