<?php
class FacebookGroupFeedPost extends CApplicationComponent {

    protected function renderView($viewPath) {
		Yii::app()->controller->renderPartial($viewPath, $return = false);
    }

    public static function post($groupFacebookId, $link, $viewPath, $name) {
        Yii::app()->FB->addGroupPost($groupFacebookId, array(
            'link' => $this->link.
            'description' => $this->renderView($viewPath),
            'name' => $this->name,
        ))
    }

}