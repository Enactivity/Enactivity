<?php

/**
 * This is the model class for table "group_profile".
 *
 * The followings are the available columns in table 'group_profile':
 * @property integer $groupId
 * @property string $description
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Group $group
 */
class GroupProfile extends CActiveRecord
{
	const DESCRIPTION_MAX_LENGTH = 4000;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return GroupProfile the static model class
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
		return 'group_profile';
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
			array('groupId', 'required'),
			array('groupId', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>4000),
			array('created, modified', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('groupId, description, created, modified', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'groupId' => 'Group',
			'description' => 'Description',
			'created' => 'Created',
			'modified' => 'Last modified',
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

		$criteria->compare('groupId',$this->groupId);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param mixed the integer ID to be loaded 
	 */
	public function loadModel($id)
	{
		$model = GroupProfile::model()->findByPk((int) $id);
		if(isset($model)) {
			return $model;
		}
		throw new CHttpException(404, 'The requested page does not exist.');
	}
}