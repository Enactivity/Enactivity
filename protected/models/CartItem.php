<?php

/**
 * This is the model class for table "cart_item".
 *
 * The followings are the available columns in table 'cart_item':
 * @property string $id
 * @property string $userId
 * @property string $sweater_type
 * @property string $sweater_color
 * @property string $letter_color
 * @property string $letter_thread_color
 * @property string $letters
 * @property string $extra_small_count
 * @property string $small_count
 * @property string $medium_count
 * @property string $large_count
 * @property string $extra_large_count
 * @property string $extra_extra_large_count
 * @property integer $isPlaced
 * @property integer $isDelivered
 * @property string $created
 * @property string $modified
 *
 * The followings are the available model relations:
 * @property User $user
 */
class CartItem extends CActiveRecord
{
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
            	'sweater_type, sweater_color, letter_color, 
            	letter_thread_color, letters, extra_small_count, 
            	small_count, medium_count, large_count, extra_large_count, 
            	extra_extra_large_count', 
            	'required',
            ),
            
        	array(
        		'sweater_type', 
            	'in',
            	'range' => array_keys(self::getSweaterChoices()),
        	),
        	
        	array(
            	'sweater_color', 
            	'in',
            	'range' => array_keys(self::getSweaterColors()),
        	),
        	
	        array(
	        	'letter_color', 
                'in',
                'range' => array_keys(self::getLetterColors()),
    	    ),
        
        	array(
                'letter_thread_color', 
                'in',
                'range' => array_keys(self::getLetterThreadColors()),
        	),
            
            array(
            	'isPlaced, isDelivered', 
            	'default', 
            	'setOnEmpty'=>true,
            	'value'=>null,
            ),
            
        	array(
        		'extra_small_count, small_count, 
        		medium_count, large_count, extra_large_count, 
                extra_extra_large_count', 
                'numerical', 
                'min'=>0,
        	),
       		array(
                'extra_small_count, small_count, 
                medium_count, large_count, extra_large_count, 
                extra_extra_large_count', 
                'default', 
                'value'=>0,
        	),
            array(
            	'sweater_type, sweater_color, letter_color, 
            	letter_thread_color, letters', 
            	'length', 
            	'max'=>45,
            ),
            
            array('letters', 'validateGreekWords'),
            
            array('extra_small_count, small_count, medium_count, large_count, extra_large_count, extra_extra_large_count', 'validateAtLeastOneSize'),
            
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
            	'userId, sweater_type, sweater_color, 
            	letter_color, letter_thread_color, letters, 
            	extra_small_count, small_count, medium_count, 
            	large_count, extra_large_count, extra_extra_large_count, 
            	isPlaced, isDelivered, created, modified', 
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
    		(int) $this->extra_small_count < 1
    		&& (int) $this->small_count < 1
    		&& (int) $this->medium_count < 1
    		&& (int) $this->large_count < 1
    		&& (int) $this->extra_large_count < 1
    		&& (int) $this->extra_extra_large_count < 1
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
            'sweater_type' => 'Sweater Type',
            'sweater_color' => 'Sweater Color',
            'letter_color' => 'Letter Color',
            'letter_thread_color' => 'Letter Thread Color',
            'letters' => 'Letters',
            'extra_small_count' => 'Extra Small',
            'small_count' => 'Small',
            'medium_count' => 'Medium',
            'large_count' => 'Large',
            'extra_large_count' => 'Extra Large',
            'extra_extra_large_count' => 'Extra Extra Large',
            'isPlaced' => 'Is Placed',
            'isDelivered' => 'Is Delivered',
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
        $criteria->compare('sweater_type',$this->sweater_type,true);
        $criteria->compare('sweater_color',$this->sweater_color,true);
        $criteria->compare('letter_color',$this->letter_color,true);
        $criteria->compare('letter_thread_color',$this->letter_thread_color,true);
        $criteria->compare('letters',$this->letters,true);
        $criteria->compare('extra_small_count',$this->extra_small_count,true);
        $criteria->compare('small_count',$this->small_count,true);
        $criteria->compare('medium_count',$this->medium_count,true);
        $criteria->compare('large_count',$this->large_count,true);
        $criteria->compare('extra_large_count',$this->extra_large_count,true);
        $criteria->compare('extra_extra_large_count',$this->extra_extra_large_count,true);
        $criteria->compare('isPlaced',$this->isPlaced);
        $criteria->compare('isDelivered',$this->isDelivered);
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
    	$updatedItemCount = $cartItemModel->updateAll(
    		array('isPlaced'=>PDateTime::timeAsMySQL()),
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
}