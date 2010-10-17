<?php

/**
 * This is the model class for table "group".
 *
 * The followings are the available columns in table 'group':
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property Event[] $events
 * @property GroupUser[] $groupUsers
 * @property User[] $users
 */
class Group extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Group the static model class
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
		return 'group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('name, slug', 'required'),
		array('name', 'length', 'max'=>255),
		array('slug', 'length', 'max'=>50),
		array('created, modified', 'safe'),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, name, slug, created, modified', 'safe', 'on'=>'search'),
		);
		//FIXME: users can use restricted words for slug
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'events' => array(self::HAS_MANY, 'Event', 'groupId'),
			'groupUsers' => array(self::HAS_MANY, 'GroupUser', 'groupId',
				'condition' => 'group_user.status="' . GroupUser::STATUS_ACTIVE .'"'),
			'usersCount' => array(self::STAT, 'GroupUser', 'groupId', 
				'condition' => 'group_user.status="' . GroupUser::STATUS_ACTIVE .'"'),
			'users' => array(self::MANY_MANY, 'User', 
				'group_user(groupId, userId)',
				//'condition' => 'group_user.status="' . GroupUser::STATUS_ACTIVE .'"'
				),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'slug' => 'Slug',
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
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			//lowercase unique values
			$this->slug = strtolower($this->slug);
			return true;

		}
		return false;
	}

	protected function afterValidate() {
		if(parent::afterValidate()) {
			return true;
		}
		return false;
	}

	protected function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->created = new CDbExpression('NOW()');
				$this->modified = new CDbExpression('NOW()');
			}
			else {
				$this->modified = new CDbExpression('NOW()');
			}
			return true;
		}
		return false;
	}
}