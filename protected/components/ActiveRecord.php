<?php
class ActiveRecord extends CActiveRecord {
	
	protected function beforeDelete() {
		
		if(parent::beforeDelete()) {
			
			// check security for access rules
			$params = array(get_class($this) => $this); 
			return Yii::app()->user->checkAccess('delete' . get_class($this), $params);
		}
		
		return false;
	}
	
	protected function beforeFind() {
		
		if(parent::beforeFind()) {
			
			// check security for access rules
			$params = array(get_class($this) => $this); 
			return Yii::app()->user->checkAccess('find' . get_class($this), $params);
		}
		
		return false;
	}
	
	protected function beforeSave() {
		
		if(parent::beforeSave()) {
			
			// check security for access rules
			if($this->isNewRecord) {
				$accessOperation = 'create' . get_class($this);
			}
			else {
				$accessOperation = 'update' . get_class($this);
			}
			// load model into parameters
			$params = array(get_class($this) => $this); 
			
			if(Yii::app()->user->checkAccess($accessOperation, $params)) {
				return true;
			}
			throw new CHttpException(401, 'Sorry, you\'re not authorized to do that');
		}
		
		return false;
	}
}