<?php

/*
 * Class used to post to facebook group feed
 * @see https://developers.facebook.com/docs/reference/api/group/#posts
 * @author Harrison Vuong
 */
class FacebookGroupPost extends CModel {

    /**
     * @var string the facebook id of the post once it's been posted on Facebook
     **/
    public $id;

    /** 
     * @var string (either message or link required)
     **/
    public $message; 
    
    /**
     * @var string URL (either message or link required)
     **/
    public $link;

    /**
     * @var string thumbnail image (can only be used if link is specified) (optional)
     **/
    public $picture; 
    
    /** 
     * @var string name (can only be used if link is specified) (optional)
     **/
    public $name; 
    
    /**
     * @var string caption (can only be used if link is specified) (optional)
     **/
    public $caption; 
    
    /**
     * @var string description (can only be used if link is specified) (optional)
     **/
    public $description; 

    /**
     * @override CModel::attributeNames
     */ 
    public function attributeNames() {
        return array(
            'message',
            'link',
            'picture',
            'name',
            'caption',
            'description',
        );
    }

    public function getPostableAttributes() {
        $postable = array();

        foreach ($this->attributes as $name => $value) {
            if(!is_null($value)) {
                $postable[$name] = $value;
            }
        }

        return $postable;
    }

    /** 
     * @param int id of group 
     * @param array attributes to post to fb
     * @see https://developers.facebook.com/docs/reference/api/group/#posts
     * @return boolean true if successful
     **/
    public function post($groupFacebookId, $attributes = array()) {
        $this->setAttributes($attributes, false); // lil hack until there are rules() in this class
        if($this->validate()) {
            $response = Yii::app()->FB->addGroupPost($groupFacebookId, $this->postableAttributes);
            $this->id = $response['id'];
            return true;
        }
        throw ModelValidationException('Failed to post to group feed.', $this);
    }
}