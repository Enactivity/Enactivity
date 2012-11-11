<?php

Yii::import("application.components.db.ar.ActiveRecord");
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
class ActivityComment extends Comment implements LoggableRecord
{
	const MODELTYPE = 'Activity';
	
    /**
     * Returns the static model of the specified AR class.
     * @return ActivityComment the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array behaviors that this model should behave as
    */
    public function behaviors() {
    	$behaviors = parent::behaviors();
    	$behaviors = CMap::mergeArray($behaviors, array(
    		// Add new behaviors here
            'ActiveRecordLogBehavior'=>array(
                'class' => 'ext.behaviors.ActiveRecordLogBehavior',
                'ignoreAttributes' => array('modified'),
            ),
    	));
    	return $behaviors;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
    	$rules = parent::rules();
        $rules = CMap::mergeArray($rules, array(
    		// Add new rules here
    	));
    	return $rules;
    }
    
    /**
     * Ensure model is set to 'Activity'
     * @see ActiveRecord::beforeValidate()
     */
    public function beforeValidate() {
    	if(parent::beforeValidate()) {
    		$this->model = self::MODELTYPE;
    		
    		return true;
    	}
    	return false;
    }
    
    // public function defaultScope() {
    // 	return array(
    // 		'model' => self::MODELTYPE,
    // 	);
    // }
    
    /**
     * Set the ActivityComment's Activity
     * @param Activity $activity
     */
    public function setActivity(Activity $activity) {
    	$this->modelId = $activity->id;
    	$this->groupId = $activity->groupId;
    }

    /**
     * @see LoggableRecord
     **/
    public function getFocalModelClassForLog() {
        return get_class($this->modelObject);
    }

    /**
     * @see LoggableRecord
     **/
    public function getFocalModelIdForLog() {
        return $this->modelObject->primaryKey;
    }

    /**
     * @see LoggableRecord
     **/
    public function getFocalModelNameForLog() {
        return $this->modelObject->name;
    }
}