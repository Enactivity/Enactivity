<?php

/**
 * This is the model class for table "cart_item".
 *
 * The followings are the available columns in table 'cart_item':
 * @property string $id
 * @property string $userId
 * @property string $productType
 * @property string $productId
 * @property integer $quantity
 * @property string $purchased
 * @property string $delivered
 * @property string $created
 * @property string $modified
 */
class CartItem extends CActiveRecord
{
	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
	const SCENARIO_PURCHASE = 'purchase';
	const SCENARIO_UPDATE = 'update'; // default set by Yii

	const PRODUCT_TYPE_SWEATER = 'sweater';

	const QUANTITY_MIN_VALUE = 1;

	private $_productActiveRecord = null;

	/**
	 * Returns the static model of the specified AR class.
	 * @return CartItem the static model class
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
		return 'cart_item';
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
			array(
				'userId, productType, productId, quantity', 
				'required',
			),

			array(
				'quantity',
				'default',
				'value'=>self::QUANTITY_MIN_VALUE, 
			),
			array(
				'quantity', 
				'numerical', 
				'integerOnly'=>true,
				'min'=>self::QUANTITY_MIN_VALUE,
				'tooSmall'=>'Must buy at least one',
			),

			array(
				'delivered', 
				'safe',
			),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userId, productType, productId, quantity, purchased, delivered, created, modified', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'Id',
            'userId' => 'User',
            'productType' => 'Product Type',
            'productId' => 'Product Id',
            'quantity' => 'Quantity',
            'purchased' => 'Purchased',
            'delivered' => 'Delivered',
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
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('productType',$this->productType,true);
		$criteria->compare('productId',$this->productId,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('purchased',$this->purchased,true);
		$criteria->compare('delivered',$this->delivered,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
		));
	}

	public function init() {
		parent::init();
		$this->quantity = self::QUANTITY_MIN_VALUE;
	}

	protected function beforeValidate() {
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				$this->userId = Yii::app()->user->id;
			}
			return true;
		}
		return false;
	}

	/**
	 * Save a new cartItem, runs validation
	 * @param array $attributes
	 * @return boolean
	 */
	public function insertCartItem($attributes=null) {
		if($this->isNewRecord) {
			$this->attributes = $attributes;
			return $this->save();
		}
		else {
			throw new CDbException(Yii::t('cartItem','The cartItem cannot be inserted because it is not new.'));
		}
	}

	/**
	 * Update the cart item, runs validation
	 * @param array $attributes
	 * @return boolean
	 */
	public function updateCartItem($attributes=null) {
		if(!$this->isNewRecord) {
			$this->attributes = $attributes;
			return $this->save();
		}
		else {
			throw new CDbException(Yii::t('cartitem','The cartitem cannot be updated because it is new.'));
		}
	}

	/**
	 * Set the scenario as purchase and update record
	 * @return boolean
	**/
	public function purchase() {
		$this->scenario = self::SCENARIO_PURCHASE;
		$this->isPurchased = true;
		return $this->save();
	}

	/** 
	 * Save a new CartItem with a sweater product type
	 * @param array $attributes
	 * @return boolean
	 **/ 
	public function buySweater($sweaterId, $attributes = null) {
		$this->productType = self::PRODUCT_TYPE_SWEATER;
		$this->productId = $sweaterId;
		$this->isPurchased = true;
		
		return $this->insertCartItem($attributes);
	}

	/**
	 * Flags and saves all non-ordered items as ordered
	 * @param User user
	 * @return boolean
	**/
	public static function placeOrder($user) {
		$successful_order = true; 
		
		$cartItems = $user->cartItems;
		foreach ($cartItems as $cartItem) {
			$successful_order = $cartItem->purchase() && $successful_order;
		}

		return $successful_order;
	}

	/**
	 * Has the cart item order been delivered?
	 * @return boolean
	 */
	public function getIsDelivered() {
		return !is_null($this->delivered);
	}

	/**
	 * Set the delivered flag
	 * @param int|bool has order been delivered
	 * @return null
	 **/
	public function setIsDelivered($delivered) {
		if((bool) $delivered) {
			$this->delivered = PDateTime::timeAsMySQL();
		}
		else {
			$this->delivered = null;
		}
	}

	/**
	 * Has the cart item order been delivered?
	 * @return boolean
	 */
	public function getIsPurchased() {
		return !is_null($this->purchased);
	}

	/**
	 * Set the place flag
	 * @param int|bool has order been purchased
	 * @return null
	 **/
	public function setIsPurchased($purchased) {
		if((bool) $purchased) {
			$this->purchased = PDateTime::timeAsMySQL();
		}
		else {
			$this->purchased = null;
		}
	}

	/**
	 * The instanced model, loaded by afterFind
	 * @var CActiveRecord
	*/
	public function getProduct() {
		if(isset($this->_productActiveRecord)) {
			return $this->_productActiveRecord;
		}
		
		$model = new $this->productType;
		$this->_productActiveRecord = $model->findByPk($this->productId);
		return $this->_productActiveRecord;
	}
}