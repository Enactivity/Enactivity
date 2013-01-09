<?php

Yii::import("application.components.widgets.MenuDefinitions");

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/defaultlayout';

	/**
	 * @var boolean whether to include <head> in layout render 
	 */
	public $layoutIncludesHead = true;

	private $_pageTitle;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'ensureAtLeastOneActiveMembershipForUser', // perform access control for CRUD operations
			);
	}

	/** 
	 * The filter method for 'ensureAtLeastOneActiveMembershipForUser'.  This filter will
	 * redirect the current user if they are logged in and have not yet activated a membership
	 * in at least one group.
	 * @return void
	 **/
	public function filterEnsureAtLeastOneActiveMembershipForUser($filterChain) {
		if(Yii::app()->user->isAuthenticated && Yii::app()->user->model->groupsCount <= 0) {
			Yii::app()->user->setFlash("notice", "Please select at least one group to use with " . Yii::app()->name);
			$this->redirect(array('membership/index'));
		}
		else {
			$filterChain->run();
		}
	}

	public function render($view, $data=null, $return=false) {

		if(!isset($data['appUser'])) {
			$data['appUser'] = Yii::app()->user;
		}

		if(Yii::app()->request->isPjaxRequest) {
			return $this->renderPjaxResponse($view, $data);
		}

		return parent::render($view, $data, $return);
	}

	public function renderPjaxResponse($view, $data) {
		$this->disableWebLogging();
		
		$this->layoutIncludesHead = false;
		echo '<title>' . PHtml::encode($this->pageTitle) .'</title>' . PHP_EOL;

		return parent::render($view, $data);
	}
	
	/**
	 * Renders the view for ajax response
	 * Produces html code and ends application
	 * @param string path to view
	 * @param array data to pass to renderer
	 **/
	public function renderAjaxResponse($view, $data) {
		$this->disableWebLogging();

		echo $this->renderPartial($view, $data, false, true);
		Yii::app()->end();
	}

	public function beginLayout($view=null, $data=array()) {
		if($this->layoutIncludesHead) {
			return $this->beginContent($view, $data);
		}
	}

	public function endLayout() {
		if($this->layoutIncludesHead) {
			return $this->endContent();
		}
	}

	/** 
	 * @override
	 */
	public function getPageTitle() {
		if(is_null($this->_pageTitle)) {
			$this->_pageTitle = ucfirst(basename($this->getId()));
			if($this->getAction() !== null && strcasecmp($this->getAction()->getId(), $this->defaultAction)) {
				$this->_pageTitle = ucfirst($this->getAction()->getId())  . ' ' . $name;
			}
		}
		return $this->_pageTitle . ' | ' . Yii::app()->name;
	}

	/** 
	 * @override
	 */
	public function setPageTitle($value)
	{
	    $this->_pageTitle=$value;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadActivityModel($id)
	{
		$model = Activity::model()->findByPk($id);
		if(is_null($model)) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadCommentModel($id)
	{
		$model=Comment::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadFeedModel($id)
	{
		$model=ActiveRecordLog::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param mixed the integer ID or string slug of the model to be loaded
	 */
	public function loadMembershipModel($id)
	{
		$model = Membership::model()->findByPk((int) $id);
		if(isset($model)) {
			return $model;
		}

		throw new CHttpException(404, 'The requested page does not exist.');
	}	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Task
	 * @throws CHttpException
	 */
	public function loadTaskModel($id)
	{
		$model=Task::model()->findByPk((int)$id);
		if(is_null($model)) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadUserModel($id)
	{
		$model=User::model()->findByPk((int)$id);
		if(is_null($model)) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Return a new  comment based on post data
	 * @param Model $model model the user is commenting on
	 * @param Comment $comment
	 * @return Comment
	 */
	public function handleNewComment($model, $comment = null) {
		if(is_null($comment)) {
			$comment = new Comment();
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performCommentAjaxValidation($comment);

		if(isset($_POST['Comment'])) {

			if($comment->publishComment($model, $_POST['Comment'])) {
				$this->redirect(array('view','id'=>$model->id, '#'=>'comment-' . $comment->id));
			}
		}
		return $comment;
	}

	/**
	 * Prevents any CWebLogRoute instances from outputting to html
	 * Useful for Ajax responses where there is no HTML body to attach to
	 */
	protected function disableWebLogging() {
		// disable web logging pollution of output
		foreach (Yii::app()->log->routes as $route) {
			if ($route instanceof CWebLogRoute) {
				$route->enabled = false;
			}
		}
	}
}