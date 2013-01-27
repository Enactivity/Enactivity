<?php

Yii::import("application.components.db.ar.ActiveRecord");
Yii::import("application.components.db.ar.EmailableRecord");
Yii::import("application.components.db.ar.LoggableRecord");

/**
 * This is the model class for table "comment".
 *
 * The followings are the available columns in table 'comment':
 * @property string $id
 * @property string $groupId
 * @property string $creatorId
 * @property string $model
 * @property string $modelId
 * @property string $content
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property User $creator
 */
class Comment extends ActiveRecord implements EmailableRecord, LoggableRecord
{
	const CONTENT_MAX_LENGTH = 4000;
	
	const SCENARIO_INSERT = 'insert';

    private $_modelObject;
	
    /**
     * Returns the static model of the specified AR class.
     * @return Comment the static model class
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
        return 'comment';
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
            'ActiveRecordLogBehavior'=>array(
                'class' => 'ext.behaviors.ActiveRecordLogBehavior',
                'scenarios' => array(
                    self::SCENARIO_INSERT => array(),
                ),
            ),
            'EmailNotificationBehavior'=>array(
                'class' => 'ext.behaviors.model.EmailNotificationBehavior',
                'scenarios' => array(
                    self::SCENARIO_INSERT => array(),
                ),
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
            array('content', 'required'),
            
        	// trim inputs
        	array('content', 'filter', 'filter'=>'trim'),
        	array('content', 'length', 'max'=>self::CONTENT_MAX_LENGTH),
            
        	// The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, groupId, creatorId, model, modelId, content, created, modified', 'safe', 'on'=>'search'),
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
            'group' => array(self::BELONGS_TO, 'Group', 'groupId'),
            'creator' => array(self::BELONGS_TO, 'User', 'creatorId'),
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'groupId' => 'Group',
            'creatorId' => 'Creator',
            'model' => 'Model',
            'modelId' => 'Model Id',
            'content' => 'Comment',
            'created' => 'Created',
            'modified' => 'Modified',
        );
    }
    
    public function scenarioLabels() {
    	return array(
    		self::SCENARIO_INSERT => 'commented on',
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

        $criteria->compare('id',$this->id,true);
        $criteria->compare('groupId',$this->groupId,true);
        $criteria->compare('creatorId',$this->creatorId,true);
        $criteria->compare('model',$this->model,true);
        $criteria->compare('modelId',$this->modelId,true);
        $criteria->compare('content',$this->content,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('modified',$this->modified,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    public function publishComment($model, $attributes = null) {
        $this->scenario = self::SCENARIO_INSERT;
        
        $this->attributes = $attributes;
        $this->groupId = $model->groupId;
        $this->modelId = $model->id;
        $this->model = get_class($model);
        
        return $this->save();
    }

    public function getModelObject() {
        if(isset($this->_modelObject)) {
            return $this->_modelObject;
        }

        if(isset($this->model)) {
            $model = new $this->model;
            $this->_modelObject = $model->findByPk($this->modelId);
            return $this->_modelObject;
        }

        return null;
    }

    public function getViewURL() {
        $controller = strtolower($this->model);

        return Yii::app()->createAbsoluteUrl($controller . '/view',
            array(
                'id'=>$this->modelId,
                '#'=>$this->id
            )
        );
    }

    public function getFocalModelClassForLog() {
        return $this->modelObject->focalModelClassForLog;
    }

    public function getFocalModelIdForLog() {
        return $this->modelObject->focalModelIdForLog;
    }

    public function getFocalModelNameForLog() {
        return $this->modelObject->focalModelNameForLog;
    }
    	
	public function whoToNotifyByEmail()
	{
		//go through group and store in array with all active users
        if($this->groupId) {
            $group = Group::model()->findByPk($this->groupId);
            $users = $group->getMembersByStatus(User::STATUS_ACTIVE);
            return $users->data;
        }
        return array();
	}

    public function getEmailName() {
        return $this->modelObject->emailName;
    }
}