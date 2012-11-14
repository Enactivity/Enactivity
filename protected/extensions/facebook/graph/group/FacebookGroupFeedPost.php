<?php

/*
 * Class used to post to facebook group feed
 * @author Harrison Vuong
 */

class FacebookGroupFeedPost extends CComponent {

    protected function renderView($viewPath, $descriptionData) {
		return Yii::app()->controller->renderPartial($viewPath, $descriptionData, true);
    }

    public function post($groupFacebookId, $link, $name, $message, $viewPath, $descriptionData) {
        Yii::app()->FB->addGroupPost($groupFacebookId, array(
            'link' => $link,
            'description' => $this->renderView($viewPath, $descriptionData),
            'name' => $name,
            'message' => $message,
        ));
    }

}