<?php

/**
 * This is the model class for table "cart_item".
 *
 * The followings are the available columns in table 'cart_item':
 * @property string $id
 * @property string $userId
 * @property string $sweaterType
 * @property string $sweaterColor
 * @property string $letterColor
 * @property string $letterThreadColor
 * @property string $letters
 * @property string $extraSmallCount
 * @property string $smallCount
 * @property string $mediumCount
 * @property string $largeCount
 * @property string $extraLargeCount
 * @property string $extraExtraLargeCount
 * @property string $placed
 * @property string $delivered
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property User $user
 */
class CartItem extends CActiveRecord
{
	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
	const SCENARIO_ORDER = 'order';
	const SCENARIO_UPDATE = 'update'; // default set by Yii
	
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
            	'sweaterType, sweaterColor, letterColor, 
            	letterThreadColor, letters, extraSmallCount, 
            	smallCount, mediumCount, largeCount, extraLargeCount, 
            	extraExtraLargeCount', 
            	'required',
            ),
            
        	array(
        		'sweaterType', 
            	'in',
            	'range' => array_keys(self::getSweaterChoices()),
        	),
        	
        	array(
            	'sweaterColor', 
            	'in',
            	'range' => array_keys(self::getSweaterColors()),
        	),
        	
	        array(
	        	'letterColor', 
                'in',
                'range' => array_keys(self::getLetterColors()),
    	    ),
        
        	array(
                'letterThreadColor', 
                'in',
                'range' => array_keys(self::getLetterThreadColors()),
        	),
            
            array(
            	'placed, delivered', 
            	'default', 
            	'setOnEmpty'=>true,
            	'value'=>null,
            ),
            
        	array(
        		'extraSmallCount, smallCount, 
        		mediumCount, largeCount, extraLargeCount, 
                extraExtraLargeCount', 
                'numerical', 
                'min'=>0,
        	),
       		array(
                'extraSmallCount, smallCount, 
                mediumCount, largeCount, extraLargeCount, 
                extraExtraLargeCount', 
                'default', 
                'value'=>0,
        	),
            array(
            	'sweaterType, sweaterColor, letterColor, 
            	letterThreadColor, letters', 
            	'length', 
            	'max'=>45,
            ),
            
            array('letters', 'validateGreekWords'),
            
            array('extraSmallCount, smallCount, mediumCount, largeCount, extraLargeCount, extraExtraLargeCount', 'validateAtLeastOneSize'),
            
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
            	'userId, sweaterType, sweaterColor, 
            	letterColor, letterThreadColor, letters, 
            	extraSmallCount, smallCount, mediumCount, 
            	largeCount, extraLargeCount, extraExtraLargeCount, 
            	placed, delivered, created, modified', 
            	'safe', 
            	'on'=>'search',
            ),
        );
    }
    
    /**
     * Validate that an attribute is made up of greek letters
     * @param string $attribute
     * @param string $params
     * @return boolean false if error, $true if not
     */
    public function validateGreekWords($attribute,$params) {
    	$stringChunks = explode(' ', $this->$attribute);
    	$errors = false;
    	
    	// Check no more than 4 letters
    	if(sizeof($stringChunks) > 4) {
    		$errors = true;
    		$this->addError($attribute, "Can't fit more than 4 letters on the front of a sweater.");
    	}
    	
    	// Check that letters are greek
    	foreach($stringChunks as $word) {
    		if($word != '' && !in_array(strtolower($word), self::getGreekLetters())) {
    			$errors = true;
    			$this->addError($attribute, $word . ' is not a greek letter.');
    		}
    	}
    	
    	return !$errors;
    }
    
    /**
     * Validates that at least one sweater size was set
     * @param string $attribute
     * @param string $params
     */
    public function validateAtLeastOneSize($attribute,$params) {
    	if(
    		(int) $this->extraSmallCount < 1
    		&& (int) $this->smallCount < 1
    		&& (int) $this->mediumCount < 1
    		&& (int) $this->largeCount < 1
    		&& (int) $this->extraLargeCount < 1
    		&& (int) $this->extraExtraLargeCount < 1
    	)
    	{
    		$this->addError($attribute, 'Must order at least one sweater');
    	}
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
            'id' => 'ID',
            'userId' => 'User',
            'sweaterType' => 'Sweater Type',
            'sweaterColor' => 'Sweater Color',
            'letterColor' => 'Letter Color',
            'letterThreadColor' => 'Letter Thread Color',
            'letters' => 'Letters',
            'extraSmallCount' => 'Extra Small',
            'smallCount' => 'Small',
            'mediumCount' => 'Medium',
            'largeCount' => 'Large',
            'extraLargeCount' => 'Extra Large',
            'extraExtraLargeCount' => 'Extra Extra Large',
            'placed' => 'Is Placed',
            'delivered' => 'Is Delivered',
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
        $criteria->compare('sweaterType',$this->sweaterType,true);
        $criteria->compare('sweaterColor',$this->sweaterColor,true);
        $criteria->compare('letterColor',$this->letterColor,true);
        $criteria->compare('letterThreadColor',$this->letterThreadColor,true);
        $criteria->compare('letters',$this->letters,true);
        $criteria->compare('extraSmallCount',$this->extraSmallCount,true);
        $criteria->compare('smallCount',$this->smallCount,true);
        $criteria->compare('mediumCount',$this->mediumCount,true);
        $criteria->compare('largeCount',$this->largeCount,true);
        $criteria->compare('extraLargeCount',$this->extraLargeCount,true);
        $criteria->compare('extraExtraLargeCount',$this->extraExtraLargeCount,true);
        $criteria->compare('placed',$this->placed);
        $criteria->compare('delivered',$this->delivered);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('modified',$this->modified,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
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
     * Get an array of db keys => english names
     * @return array of strings:
     */
    public static function getSweaterChoices() {
    	return array(
    		'hoodie' => "Hooded",
    		'crewneck' => "Crew Neck",
    		'zipuphoodie' => "Zip Up Hooded",
    	);
    }
    
    /**
     * Get an array of db colors => english names
     * @return array of strings:
     */
    public static function getSweaterColors() {
    	return array(
    		'black' => "Black",
        	'blue' => "Blue",
       		'red' => "Red",
    	);
    }
    
    /**
    * Get an array of db colors => english names
    * @return array of strings:
    */
    public static function getLetterColors() {
    	return array(
        	'black' => "Black",
          	'blue' => "Blue",
            'red' => "Red",
    	);
    }
    
    /**
    * Get an array of db colors => english names
    * @return array of strings:
    */
    public static function getLetterThreadColors() {
    	return array(
        	'black' => "Black",
            'blue' => "Blue",
            'red' => "Red",
    	);
    }
    
    /**
     * Order items in the user's cart
     * @param int $userId User id
     */
    public static function placeOrder($userId) {
    	$cartItemModel = new CartItem();
    	$cartItemModel->scenario = self::SCENARIO_ORDER;
    	$updatedItemCount = $cartItemModel->updateAll(
    		array('placed'=>PDateTime::timeAsMySQL()),
    		'userId=:userId',
    		array(':userId'=>$userId)
    	);
    	return $updatedItemCount > 0;
    }
    
    /**
     * Get the Greek letters
     * @return array of letters
     */
    public static function getGreekLetters() {
    	return array('alpha',
			'beta',
			'gamma',
			'delta',
			'epsilon',
			'zeta',
			'eta',
			'theta',
			'iota',
			'kappa',
			'lambda',
			'mu',
			'nu',
			'xi',
			'omicron',
			'pi',
			'rho',
			'sigma',
			'tau',
			'upsilon',
			'phi',
			'chi',
			'psi',
			'omega',
		);
    }
    
    /**
     * Has the cart item order been delivered?
     * @return boolean
    */
    public function getIsDelivered() {
    	return !is_null($this->delivered);
    }
    
    public function setIsDelivered($delivered) {
    	if((bool) $delivered) {
    		$this->delivered = PDateTime::timeAsMySQL();
    	}
    	else {
    		$this->delivered = null;	
    	}
    }
}