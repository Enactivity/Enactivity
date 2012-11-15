<?php

/*
 * Class used to post to facebook group feed
 * @author Harrison Vuong
 */

class FacebookGroupPost extends CComponent {

    protected function renderView($viewPath, $viewData) {
		return Yii::app()->controller->renderPartial($viewPath, $viewData, true);
    }

    public function post($groupFacebookId, $link, $name, $message, $viewPath, $viewData) {
        return Yii::app()->FB->addGroupPost($groupFacebookId, array(
            'link' => $link,
            'description' => $this->renderView($viewPath, $viewData),
            'name' => $name,
            'message' => $message,
        ));
    }

}