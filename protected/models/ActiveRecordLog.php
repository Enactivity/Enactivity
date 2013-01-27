<?php

Yii::import("application.components.db.ar.ActiveRecord");

/**
 * This is the model class for table "activerecordlog".
 *
 * The followings are the available columns in table 'activerecordlog':
 * @property integer $id
 * @property integer $groupId
 * @property string $focalModel
 * @property integer $focalModelId
 * @property string $focalModelName
 * @property string $model
 * @property integer $modelId
 * @property string $action
 * @property string $modelAttribute
 * @property string $oldAttributeValue
 * @property string $newAttributeValue
 * @property integer $userId
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property User $user
 * @property Group $group
 */
class ActiveRecordLog extends ActiveRecord
{
	const ACTION_POSTED = 'insert';
	const ACTION_DELETED = 'delete';
	const ACTION_UPDATED = 'update';
	
	/**
	 * The instanced focal model, loaded by afterFind
	 * @var ActiveRecord
	 */
	private $_focalModelObject;
	
	
	private $_modelObject;
	
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
			array('groupId, focalModel, focalModelId, focalModelName, model, modelId', 'required'),
			array('groupId, modelId, userId', 'numerical', 'integerOnly'=>true),
			array('focalModel, model, modelAttribute', 'length', 'max'=>45),
			
			// trim inputs
			array('action, model, modelAttribute', 'filter', 'filter'=>'trim'),
			
			array('modelAttribute, oldAttributeValue, newAttributeValue', 
				'default', 
				'setOnEmpty' => true, 
				'value' => null
			),
			
			array('action', 'length', 'max'=>20),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, groupId, model, modelId, action, modelAttribute, oldAttributeValue, newAttributeValue, userId, created, modified', 'safe', 'on'=>'search'),
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
			'focalModel' => 'Focal Model',
			'focalModelId' => 'Focal Model',
			'model' => 'Model',
			'modelId' => 'Model',
			'action' => 'Action',
			'modelAttribute' => 'Model Attribute',
			'oldAttributeValue' => 'Old Attribute Value',
			'newAttributeValue' => 'New Attribute Value',
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
		$criteria->compare('focalModel',$this->focalModel,true);
		$criteria->compare('focalModelId',$this->focalModelId);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('modelId',$this->modelId);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('modelAttribute',$this->modelAttribute,true);
		$criteria->compare('oldAttributeValue',$this->oldAttributeValue,true);
		$criteria->compare('newAttributeValue',$this->newAttributeValue,true);		
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
	
	public function defaultScope() {
		return array(
			'order' => 'created DESC'
		);
	}
	
	/**
	 * Scope definition for banters that share group value with
	 * the user's groups 
	 * @param int $userId
	 * @return ActiveRecordLog model
	 */
	public function scopeUsersGroups($userId) {
		$this->getDbCriteria()->mergeWith(
			array(
				'condition' => 'id IN (SELECT id FROM ' . $this->tableName() 
				.  ' WHERE groupId IN (SELECT groupId FROM ' . Membership::model()->tableName()
				. ' WHERE userId=:userId))',
				'params' => array(':userId' => $userId)
			)
		);
		return $this;
	}
	
	public function getFocalModelObject() {
		if(isset($this->_focalModelObject)) {
			return $this->_focalModelObject;
		}
		
		$focalModel = new $this->focalModel;
		$this->_focalModelObject = $focalModel->findByPk($this->focalModelId);
		return $this->_focalModelObject;
	}
	
	/**
	 * The instanced model, loaded by afterFind
	 * @var ActiveRecord
	*/
	public function getModelObject() {
		if(isset($this->_modelObject)) {
			return $this->_modelObject;
		}
		
		$model = new $this->model;
		$this->_modelObject = $model->findByPk($this->modelId);
		return $this->_modelObject;
	}

	/** 
	 * Gets the scenario label for a model based on the action
	 * @return string
	 **/
	public function getModelLabel() {
		$model;
		if($this->modelObject) {
			$model = $this->modelObject;
		}
		else {
			$model = new $this->model;
		}

		return $model->getScenarioLabel($this->action);
	}

	public function getIsComment() {
		return strcasecmp($this->model, 'Comment') == 0;
	}

	/**
	 * Unset focal and model objects to clear memory
	 * @return null
	 **/
	public function unsetModels() {
		if($this->_focalModelObject) {
			$this->_focalModelObject->detachBehaviors();
			unset($this->_focalModelObject);
		}

		if($this->_modelObject) {
			$this->_modelObject->detachBehaviors();
			unset($this->_modelObject);
		}
	}
}