<?php
/**
 * Wrapper component around Facebook library
 */

// Require rather than import because of facebook file name case mismatching.
require_once(Yii::getPathOfAlias('ext.vendors.facebook') . '/facebook.php');

class FB extends CApplicationComponent {

	/**
	 * @var string Facebook application id.
	 */
	public $appID;
	
	/**
	 * @var string Facebook application secret.
	 */
	public $appSecret;
	
	/**
	 * @var string the application namespace.
	 */
	public $appNamespace;
	
	/**
	 * @var boolean whether file uploads are enabled.
	 */
	public $isFileUploadEnabled;

	/**
	 * @var string comma separated list of additional permissions to ask of users
	 */
	public $scope;

	protected $_facebook;

	/**
	 * Initializes this component.
	 */
	public function init()
	{
		$config = array(
			'appId' => $this->appID,
			'secret' => $this->appSecret
		);

		if (!is_null($this->isFileUploadEnabled)) {
			$config['isFileUploadEnabled'] = $this->isFileUploadEnabled;
		}

		$this->_facebook = new Facebook($config);
	}

	/**
	 * Registers an Open Graph action with Facebook.
	 * @param string $action the action to register.
	 * @param array $params the query parameters.
	 */
	public function registerAction($action, $params=array())
	{
		$this->api('me/'.$this->appNamespace.':'.$action, $params);
	}

	/**
	 * Calls the Facebook API.
	 * @param string $query the query to send.
	 * @param array $params the query parameters.
	 * @return array the response.
	 */
	protected function api($query, $params=array())
	{
		$data = array();

		if ($params !== array()) {
			$query .= '?'.http_build_query($params);
		}

		try {
			$data = $this->_facebook->api('/'.$query);
			Yii::trace(
				CVarDumper::dumpAsString($query)
				. ": " 
				. CVarDumper::dumpAsString($data)
				, 'facebook');
		}
		catch (FacebookApiException $e)
		{
			throw $e;
		}

		return $data;
	}

	/**
	 * Calls the Facebook API with a POST command.
	 * @param string $query the query to send.
	 * @param array $params the query parameters.
	 * @return array the response.
	 */
	protected function post($query, $params) {
		try {
			$data = $this->_facebook->api('/'.$query, 'POST', $params);
		}
		catch (FacebookApiException $e)
		{
			throw $e;
		}

		return $data;
	}

	/**
	 * Returns the locale based on the application language.
	 * @return string the locale.
	 */
	public function getLocale()
	{
		$language = Yii::app()->language;

		if ($language !== null)
		{
			$pieces = explode('_', $language);
			if (count($pieces) === 2)
				return $pieces[0].'_'.strtoupper($pieces[1]);
		}

		return 'en_US';
	}

	/**
	 * Returns the Facebook application instance.
	 * @return Facebook the instance.
	 */
	protected function getFacebook()
	{
		return $this->_facebook;
	}

	public function logout() {
		$this->facebook->destroySession();
	}

	public function getLoginUrl() {
		return $this->facebook->getLoginUrl(array(
			'redirect_uri'=>$this->redirectURI,
			'scope'=>$this->scope,
		));
	}

	/** 
	 * @return string url to oauth landing pages passed as part of loging attempt
	 * @see https://developers.facebook.com/apps 'Website with Facebook Login'
	 **/
	public function getRedirectURI() {
		return Yii::app()->createAbsoluteUrl('site/login');
	}

	// FACEBOOK WRAPPERS

	/**
	 * Get the application or user access token from FB
	 * @return string
	 **/
	public function getAccessToken() {
		return $this->facebook->getAccessToken();
	}

	/**
	 * Gets the current user's facebook id from Facebook
	 * Note: this kicks off massive side-effects (like, signing the user in)
	 * @return int|null the current user's facebook id
	 **/
	public function getCurrentUserFacebookId() {
		return $this->facebook->getUser();
	}

	/**
	 * Maps to facebook/me
	 * @return array
	 **/
	public function getCurrentUserDetails() {
		return $this->api('me');
	}

	/**
	 * Maps to facebook/me/groups
	 * @return array
	 **/
	public function getCurrentUserGroups() {
		return $this->api('me/groups');
	}

	/**
	 * Get the image url of the user
	 * @return string absolute url of image file
	 **/
	public function getCurrentUserPictureURL() {
		$id = $this->currentUserFacebookId;
		return "https://graph.facebook.com/$id/picture";
	}

	/**
	 * Maps to facebook/me/picture
	 * @return string absolute url of image file
	 **/
	public function getGroupPictureURL($groupFacebookId) {
		return "https://graph.facebook.com/$groupFacebookId/picture";
	}

	public function addGroupPost($groupFacebookId, $params) {
		$params['method'] = 'post';
		return $this->api($groupFacebookId . '/feed', $params);
	}
}