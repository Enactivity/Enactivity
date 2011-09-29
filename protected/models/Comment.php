<?php

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
class Comment extends CActiveRecord
{
	const CONTENT_MAX_LENGTH = 4000;
	
	const SCENARIO_INSERT = 'insert';
	const SCENARIO_REPLY = 'reply';
	
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
            array('groupId, creatorId, model, modelId, content', 'required'),
            array('groupId, creatorId, modelId', 'length', 'max'=>11),
            array('model', 'length', 'max'=>45),
            
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
	    	self::SCENARIO_REPLY => 'replied to',
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
}