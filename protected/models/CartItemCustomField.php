<?php

/**
 * This is the model class for table "cart_item_custom_field".
 *
 * The followings are the available columns in table 'cart_item_custom_field':
 * @property string $id
 * @property string $cartItemId
 * @property string $key
 * @property string $value
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property CartItem $id0
 */
class CartItemCustomField extends CActiveRecord
{
	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
	const SCENARIO_UPDATE = 'update'; // default set by Yii

	/**
	 * Returns the static model of the specified AR class.
	 * @return CartItemCustomField the static model class
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
		return 'cart_item_custom_field';
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
			array('cartItemId, key, value', 'required'),
			array('cartItemId', 'length', 'max'=>10),
			array('key', 'length', 'max'=>50),
			array('value', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cartItemId, key, value, created, modified', 'safe', 'on'=>'search'),
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
			'cartItem' => array(self::BELONGS_TO, 'CartItem', 'cartItemId'),
		);
	}

	/**
	 * Insert a new custom field or update if it already exists
	 * @param string|int CartItem id
	 * @param string key name
	 * @param string value
	 */
	public static function saveCustomField($cartItemId, $key, $value) {
		$customField = self::model()->findByAttributes(array(
			'cartItemId'=>$cartItemId,
			'key'=>$key,
		));
		if(is_null($customField)) {
			Yii::log('CI id: ' . $cartItemId);
			$customField = new CartItemCustomField();
			$customField->cartItemId = $cartItemId;
			$customField->key = $key;
		}

		$customField->value = $value;

		Yii::log('CI info: ' . CVarDumper::dumpAsString($customField));

		if($customField->save()) {
			return true;
		}
		throw new CDbException(Yii::t('CartItemCustomField',
			'The custom field failed to save, errors: ' . print_r($customField->errors, true)));
	}

	/**
	 * Get the custom field's value
	 * @param string|int CartItem id
	 * @param string key name
	 * @return string
	 */
	public static function getCustomFieldValue($cartItemId, $key) {
		$customField = self::model()->findByAttributes(array(
			'cartItemId'=>$cartItemId,
			'key'=>$key,
		));
		if(is_null($customField)) {
			return null;
		}

		return $customField->value;

	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cartItemId' => 'Cart Item',
			'key' => 'Key',
			'value' => 'Value',
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
		$criteria->compare('cartItemId',$this->cartItemId,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}