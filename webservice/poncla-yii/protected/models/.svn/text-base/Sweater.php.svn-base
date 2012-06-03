<?php

/**
 * This is the model class for table "sweater".
 *
 * The followings are the available columns in table 'sweater':
 * @property string $id
 * @property string $style
 * @property string $clothColor
 * @property string $letterColor
 * @property string $stitchingColor
 * @property string $size
 * @property integer $available
 * @property string $created
 * @property string $modified
 */
class Sweater extends CActiveRecord
{
	const SCENARIO_DELETE = 'delete';
	const SCENARIO_INSERT = 'insert'; // default set by Yii
	const SCENARIO_UPDATE = 'update'; // default set by Yii

	const SIZE_MAX_LENGTH = 20;

	/**
	 * Returns the static model of the specified AR class.
	 * @return Sweater the static model class
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
		return 'sweater';
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
			array('style, clothColor, letterColor, stitchingColor, size', 'required'),

			array(
				'available', 
				'numerical', 
				'integerOnly'=>true
			),
			
			array(
				'style', 
				'length', 
				'max'=>20
			),
			
			array(
				'clothColor, letterColor, stitchingColor', 
				'length', 
				'max'=>50
			),

			array(
	    		'style', 
	        	'in',
	        	'range' => self::getStyles(),
	    	),
	    	
	    	array(
	        	'clothColor', 
	        	'in',
	        	'range' => self::getClothColors(),
	    	),
	    	
	        array(
	        	'letterColor', 
	            'in',
	            'range' => self::getLetterColors(),
		    ),
	    
	    	array(
	            'stitchingColor', 
	            'in',
	            'range' => self::getStitchingColors(),
	    	),
			
			array(
				'size', 
				'length', 
				'max'=>self::SIZE_MAX_LENGTH,
			),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, style, clothColor, letterColor, stitchingColor, size, available, created, modified', 'safe', 'on'=>'search'),
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
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'style' => 'Style',
            'clothColor' => 'Cloth Color',
            'letterColor' => 'Letter Color',
            'stitchingColor' => 'Stitching Color',
            'size' => 'Size',
            'available' => 'Available',
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
		$criteria->compare('style',$this->style,true);
		$criteria->compare('clothColor',$this->clothColor,true);
		$criteria->compare('letterColor',$this->letterColor,true);
		$criteria->compare('stitchingColor',$this->stitchingColor,true);
		$criteria->compare('size',$this->size,true);
		$criteria->compare('available',$this->available);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('modified',$this->modified,true);

		return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
		));
	}

	/**
	 * Save a new sweater, runs validation
	 * @param array $attributes
	 * @return boolean
	 */
	public function insertSweater($attributes=null) {
		if($this->isNewRecord) {
			$this->attributes = $attributes;
			return $this->save();
		}
		else {
			throw new CDbException(Yii::t('sweater','The sweater cannot be inserted because it is not new.'));
		}
	}

	/**
	 * Update the cart item, runs validation
	 * @param array $attributes
	 * @return boolean
	 */
	public function updateSweater($attributes=null) {
		if(!$this->isNewRecord) {
			$this->attributes = $attributes;
			return $this->save();
		}
		else {
			throw new CDbException(Yii::t('sweater','The sweater cannot be updated because it is new.'));
		}
	}

	/**
	 * Get an array of db keys => english names
	 * @return array of strings:
	 */
	public static function getStyles() {
		return array(
        	"Crew Neck",
        	"Hooded",
        	"Zip Up Hooded",
		);
	}

	/**
	 * Get an array of db colors => english names
	 * @return array of strings:
	 */
	public static function getClothColors() {
		return array(
        	"Black",
            "Blue",
           	"Red",
		);
	}

	/**
	 * Get an array of db colors => english names
	 * @return array of strings:
	 */
	public static function getLetterColors() {
		return array(
    	   	"White",
    	   	"Black",
    	   	"Dark Royal",
    	   	"Royal",
    	  	"Colombia",
    	   	"Lilac",
    	   	"Purple",
    	   	"Maroon",
    	   	"Cardinal",
    	   	"Red",
    	   	"Devil Red",
    	   	"Burgandy",
        	"Greek Pink",
   	    	"Neon Pink",
   	    	"Pink",
    	    "Navy",
    	    "Cream",
    	    "Tan",
    	    "Eagle Grey",
    	    "Grey",
    	    "Neon Green",
    	    "Kelly Green",
    	    "Dark Green",
    	    "Brown",
    	    "Gold",
    	    "Light Gold",
    	    "Old Gold",
    	    "Maize",
    	    "Orange",
    	    "Shark Teal",
    	    "Silver",
    	    "Jaguar Blue",
		);
	}

	/**
	 * Get an array of db colors => english names
	 * @return array of strings:
	 */
	public static function getStitchingColors() {
		return array(
	    	"White",
	    	"Black",
	    	"Dark Royal",
	    	"Royal",
	    	"Colombia",
	    	"Lilac",
	    	"Purple",
	    	"Maroon",
	    	"Cardinal",
	    	"Red",
	    	"Devil Red",
	    	"Burgandy",
	    	"Greek Pink",
	    	"Neon Pink",
	    	"Pink",
	    	"Navy",
	    	"Cream",
	    	"Tan",
	    	"Eagle Grey",
	    	"Grey",
	    	"Neon Green",
	    	"Kelly Green",
	    	"Dark Green",
	    	"Brown",
	    	"Gold",
	    	"Light Gold",
	    	"Old Gold",
	    	"Maize",
	    	"Orange",
	    	"Shark Teal",
	    	"Silver",
	    	"Jaguar Blue",
		);
	}

	public static function getSizes() {
		return array(
			'Extra Small',
			'Small',
			'Medium',
			'Large',
			'Extra Large',
			'Extra Extra Large',
		);
	}

	/**
	 * Get the Name of a color
	 * @param $string $key
	 * @return string
	 */
	public static function getSweaterColorName($key) {
		$colors = self::getSweaterColors();
		return $colors[$key];
	}

	/**
	 * Get the Name of a color
	 * @param $string $key
	 * @return string
	 */
	public static function getLetterColorName($key) {
		$colors = self::getLetterColors();
		return $colors[$key];
	}

	/**
	 * Get the Name of a color
	 * @param $string $key
	 * @return string
	 */
	public static function getLetterThreadColorName($key) {
		$colors = self::getLetterColors();
		return $colors[$key];
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
		return array(
			'alpha',
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