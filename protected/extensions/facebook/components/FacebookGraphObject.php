<?php

/*
 * Class used as basis of communicating with complex facebook objects
 */
abstract class FacebookGraphObject extends CModel {

    public $id;

    public function save($runValidation=true) 
    { 
        if(!$runValidation || $this->validate($attributes)) {
            return $this->post($attributes);
        }
        else {
            return false;
        }
    }

    /** 
     * The equivalent of the CActiveRecord::insert.  The specific
     * Facebook graph call to submit the object to Facebook's graph
     */
    abstract protected function post();
}