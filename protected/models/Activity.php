<?php

Yii::import("application.components.db.ar.ActiveRecord");

/**
 * This is the model class for table "activity".
 *
 * The followings are the available columns in table 'activity':
 * @property string $id
 * @property string $groupId
 * @property string $authorId
 * @property string $facebookId
 * @property string $name
 * @property string $description
 * @property string $status
 * @property string $participantsCount
 * @property string $participantsCompletedCount
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Group $group
 * @property User $author
 */
class Activity extends ActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Activity the static model class
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
		return 'activity';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('authorId, name, status, created, modified', 'required'),
			array('groupId, authorId, participantsCount, participantsCompletedCount', 'length', 'max'=>10),
			array('facebookId, name', 'length', 'max'=>255),
			array('status', 'length', 'max'=>15),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, groupId, authorId, facebookId, name, description, status, participantsCount, participantsCompletedCount, created, modified', 'safe', 'on'=>'search'),
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
			'author' => array(self::BELONGS_TO, 'User', 'authorId'),
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
			'authorId' => 'Author',
			'facebookId' => 'Facebook',
			'name' => 'Name',
			'description' => 'Description',
			'status' => 'Status',
			'participantsCount' => 'Participants Count',
			'participantsCompletedCount' => 'Participants Completed Count',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('groupId',$this->groupId,true);
		$criteria->compare('authorId',$this->authorId,true);
		$criteria->compare('facebookId',$this->facebookId,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('participantsCount',$this->participantsCount,true);
		$criteria->compare('participantsCompletedCount',$this->participantsCompletedCount,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}