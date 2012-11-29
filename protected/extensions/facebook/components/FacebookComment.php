<?php

Yii::import("ext.facebook.components.FacebookGraphObject");

/*
 * Class used to save and get facebook comments
 */
class FacebookComment extends FacebookGraphObject {

    const SCENARIO_INSERT = 'insert'; // default set by Yii

    public $facebookPostId;
    public $message;

    public $authorFacebookId;
    public $authorFullName;
    
    public $created;

    /**
     * @see CModel::attributeNames
     */
    public function attributeNames() {
        return array(
            'id',
            'facebookPostId', // Id of facebook post to comment on
            'message',
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
            array('message', 'required'),
            
            // trim inputs
            array('message', 'filter', 'filter'=>'trim'),
        );
    }

    protected function post() {
        $response = Yii::app()->FB->addPostComment($this->facebookPostId, array(
            'message' => $this->message,
        ));

        if(isset($response['id'])) {
            $this->id = $response['id'];
            return true;
        }

        return false;
    }

    /**
     * Comment on the appropriate post
     * @var int post object id on Facebook
     * @var array of attributes to comment
     * @return boolean
     */
    public function comment($facebookPostId, $attributes) {
        $this->scenario = self::SCENARIO_INSERT;

        $this->facebookPostId = $facebookPostId;
        $this->attributes = $attributes;

        if($this->save()) {
            return true;
        }
        throw new CException("Facebook comment was invalid: " . CVarDumper::dumpAsString($this->errors()));
    }

    public function getCreator() {
        return User::findByFacebookId($this->authorFacebookId);
    }
}