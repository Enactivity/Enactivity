<?php
class FacebookGroupFeedPost extends CApplicationComponent {

    protected function renderView($viewPath) {
		Yii::app()->controller->renderPartial($viewPath, $return = true);
    }

    public function post($groupFacebookId, $link, $name, $message, $viewPath) {
        Yii::app()->FB->addGroupPost($groupFacebookId, array(
            'link' => $link,
            'description' => $this->renderView($viewPath),
            'name' => $name,
            'message' => $message,
        ));
    }

}