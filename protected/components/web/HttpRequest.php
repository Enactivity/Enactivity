<?

class HttpRequest extends CHttpRequest {

	function getIsPjaxRequest() {
		return isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX']==='true';
	}
}