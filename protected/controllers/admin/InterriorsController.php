<?php

class InterriorsController extends Controller
{
        public $toolbar;

        function __construct($id, $module=NULL) {
            $this->toolbar = NULL;
            parent::__construct($id, $module);
        }
 
 	public function actionDelete($id)
 	{
            $model=$this->loadModel($id);

            $this->performAjaxDeletion($model);

            $model->delete();
            $this->redirect(array('index'));
	}

	public function actionEdit($id)
	{
            $model=$this->loadModel($id);
            $model->scenario="Edit";
            
            if(isset($_POST['Interriors']))
		{
			$model->attributes=$_POST['Interriors'];
                        if($model->validate()){
                            $model->save();
                            $this->redirect(array('index'));
                        }
                }
            $this->setToolbar();
            $this->render('add',array('model'=>$model));
	}
	public function actionAdd()
	{
            $model=new Interriors('Add');
            if(isset($_POST['Interriors']))
		{   
			$model->attributes=$_POST['Interriors'];
                        if($model->validate()){
                            $model->save();
                            $this->redirect(array('index'));
                        }
                }
            $this->setToolbar();
            $this->render('add',array('model'=>$model));
	}
	public function actionIndex()
	{   
            $dataProvider=new CActiveDataProvider('Interriors');
            $this->render('index',array(
                'dataProvider'=>$dataProvider,
		));
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
	
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
        public function loadModel($id)
	{
		$model=Interriors::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxDeletion($model)
	{
		if(isset($_GET['ajax']))
		{    
                    $model->delete();
                    echo "deleted";
                    Yii::app()->end();
		}
	}

        /*
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
        public function getToolbar(){
            return $this->toolbar;
        }
        
        public function setToolbar(){
            $this->toolbar=array(
			'items' => array(
				        array(
				            'label'=>'Разметить углы',
				            'icon-position'=>'left',
				            'url'=>array('/#'),
                                            'linkOptions'=>array('id'=>"complex_int")
				        ),
				    ),
			'htmlOptions' => array('style' => 'clear: both;'),
                );
        }
}