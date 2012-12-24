<?

class HttpRequest extends CHttpRequest {

	function getIsPjaxRequest() {
		return isset($_SERVER['X-PJAX']); // && $_SERVER['X-PJAX']==='XMLHttpRequest';
	}
}