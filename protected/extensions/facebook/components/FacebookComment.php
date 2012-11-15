<?php

Yii::import("ext.facebook.components.FacebookGraphObject");

/*
 * Class used to save and get facebook comments
 */
class FacebookComment extends FacebookGraphObject {

    public $facebookPostId;
    public $message;

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

    public static function comment($facebookPostId, $attributes) {
        $comment = new FacebookComment();
        $comment->facebookPostId = $facebookPostId;
        $comment->attributes = $attributes;

        if($comment->save()) {
            return true;
        }
        throw new CException("Facebook comment was invalid: " . CVarDumper::dumpAsString($this->errors()));
    }
}