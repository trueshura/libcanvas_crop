<?php

class ImagesController extends Controller
{
        public $emCategories;
        public $toolbar;

        function __construct($id, $module=NULL) {
            $this->toolbar = NULL;
            $this->emCategories= NULL;
            parent::__construct($id, $module);
        }

	public function actionAdd()
	{
            $model=new Images('Add');
            if(isset($_POST['Images'])){
                $model->attributes=$_POST['Images'];
                if($model->validate()){
                    $model->save();
                    $this->redirect(array('index'));
                    
                }    
            }
            $this->render('add',array('model'=>$model));
	}
        
	public function actionEdit($id)
	{   
            $model=$this->loadModel($id);
            $model->scenario="Edit";
            
            $this->render('add',array('model'=>$model));
	}
        
	public function actionDelete($id)
	{
		$this->render('delete');
	}

	public function actionIndex()
	{
                $dataProvider=new CActiveDataProvider('Images');
                //$this->emCategories=new CActiveDataProvider('Categories');
                $this->render('index',array(
                    'dataProvider'=>$dataProvider,
		));
	}
        
        public function loadModel($id)
	{
		$model=Images::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('add','index','edit','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}