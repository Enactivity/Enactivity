<?php

class StoreController extends Controller
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
            array('allow',  // allow authenticated users to perform actions
                'actions'=>array('index','cart','checkout','create','delete', 'update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','view'),
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
    	// TODO: Make adminstratable 
        $this->render('view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionIndex()
    {
        $model=new CartItem;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['CartItem']))
        {
            $model->attributes=$_POST['CartItem'];
            if($model->save())
                $this->redirect(array('store/cart'));
        }

        $this->render('index',array(
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

        if(isset($_POST['CartItem']))
        {
            $model->attributes=$_POST['CartItem'];
            if($model->save())
                $this->redirect(array('cart'));
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
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('cart'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
    
    /**
     * Lists all models.
     */
    public function actionCart()
    {
    	$cartItems = new CActiveDataProvider('CartItem', array(
    		'data' => Yii::app()->user->model->cartItems)
    	);
    	
    	$cartItemsInProcess = new CActiveDataProvider('CartItem', array(
    	    'data' => Yii::app()->user->model->cartItemsInProcess)
    	);
    	
    	$cartItemsCompleted = new CActiveDataProvider('CartItem', array(
    	    'data' => Yii::app()->user->model->cartItemsCompleted)
    	);
    	
    	$this->render('cart',array(
        	'cartItems'=>$cartItems,
        	'cartItemsInProcess'=>$cartItemsInProcess,
        	'cartItemsCompleted'=>$cartItemsCompleted,
    	));
    }
    
    /**
     * Gather contact info and allow user to place order
     */
    public function actionCheckout() {
    	$dataProvider = new CActiveDataProvider('CartItem', array(
    		'data' => Yii::app()->user->model->cartItems)
    	);
    	
    	$model = Yii::app()->user->model;
    	$model->scenario = User::SCENARIO_CHECKOUT;
    	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User'])) {
			$model->attributes = $_POST['User'];
			if($model->save() && CartItem::placeOrder(Yii::app()->user->id)) {
				Yii::app()->user->setFlash('success', "Your order has been placed.");
				$this->redirect("index");
			}
		}

    	$this->render('checkout',array(
        	'dataProvider'=>$dataProvider,
        	'model'=>$model,
    	));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new CartItem('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['CartItem']))
            $model->attributes=$_GET['CartItem'];

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
        $model=CartItem::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='cart-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}