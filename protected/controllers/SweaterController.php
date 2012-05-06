<?php

class SweaterController extends Controller
{
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','create','delete','view','update'),
				'expression'=>'$user->isAdmin',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Sweater;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sweater']))
		{
			$model->attributes=$_POST['Sweater'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Sweater']))
		{
			$model->attributes=$_POST['Sweater'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$sweater = new Sweater();
		$sweater->attributes = $_GET;

		$cartItem = new CartItem();

		$sweaterSettings = array();
		if(!$sweater->style) {
			// FIXME: replace array_values with DISTINCT sweater column results
			$sweaterSettings['style'] = Sweater::getStyles();
		}
		elseif(!$sweater->clothColor) {
			$sweaterSettings['clothColor'] = Sweater::getClothColors();
		}
		elseif(!$sweater->letterColor) {
			$sweaterSettings['letterColor'] = Sweater::getLetterColors();
		}
		elseif(!$sweater->stitchingColor) {
			$sweaterSettings['stitchingColor'] = Sweater::getStitchingColors();
		}
		elseif(!$sweater->size) {
			$sweaterSettings['size'] = Sweater::getSizes();
		}
		else {
			$sweater = $sweater->findByAttributes($_GET);
			$cartItem = $this->handleNewSweaterPurchase($sweater->id);
		}

		foreach ($sweaterSettings as $sweaterParameter => $parameterArray) {
			foreach ($parameterArray as $key => $value) {
				$urlParams = $_GET;
				$urlParams[$sweaterParameter] = $value;
				$sweaterSettings[$sweaterParameter][$value] = $this->createUrl('', $urlParams);
				unset($sweaterSettings[$sweaterParameter][$key]);
			}
		}

		$this->render('index',array(
			'cartItem'=>$cartItem,
			'sweater'=>$sweater,
			'sweaters'=>$sweaterSettings,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Sweater('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Sweater']))
			$model->attributes=$_GET['Sweater'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Sweater::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Return a new cartItem based on POST data
	 * @param CartItem
	 * @return CartItem if not saved, directs otherwise
	 */
	public function handleNewSweaterPurchase($sweaterId, $model = null) {
		if(is_null($model)) {
			$model = new CartItem(CartItem::SCENARIO_INSERT);
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CartItem'])) {
			if($model->buySweater($sweaterId, $_POST['CartItem'])) {
				$this->redirect(array('/store/cart'));
			}
		}

		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sweater-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
