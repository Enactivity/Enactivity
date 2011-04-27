<?php

/**
 * This is the model class for table "activerecordlog".
 *
 * The followings are the available columns in table 'activerecordlog':
 * @property integer $id
 * @property integer $groupId
 * @property string $model
 * @property integer $modelId
 * @property string $action
 * @property string $modelAttribute
 * @property integer $userId
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Group $group
 */
class ActiveRecordLog extends CActiveRecord
{
	const ACTION_POSTED = 'posted';
	const ACTION_DELETED = 'deleted';
	const ACTION_UPDATED = 'updated';
	
	public $modelObject;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return ActiveRecordLog the static model class
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
		return 'activerecordlog';
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
			array('groupId, model', 'required'),
			array('groupId, modelId, userId', 'numerical', 'integerOnly'=>true),
			array('model, modelAttribute', 'length', 'max'=>45),
			
			// trim inputs
			array('action, model, modelAttribute', 'filter', 'filter'=>'trim'),
			
			array('action', 'length', 'max'=>20),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, groupId, model, modelId, action, modelAttribute, userId, created, modified', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'group' => array(self::BELONGS_TO, 'Group', 'groupId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'groupId' => 'Group',
			'model' => 'Model',
			'modelId' => 'Model',
			'action' => 'Action',
			'modelAttribute' => 'Model Attribute',
			'userId' => 'User',
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
		$criteria->compare('groupId',$this->groupId);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('modelId',$this->modelId);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('modelAttribute',$this->modelAttribute,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function scopes() {
		return array(
			'grouped' => array(
				'group' => 'model, modelId, action, HOUR(created)'
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
	
	protected function afterFind() {
		$model = new $this->model;
		$this->modelObject = $model->findByPk($this->modelId);
	}
}