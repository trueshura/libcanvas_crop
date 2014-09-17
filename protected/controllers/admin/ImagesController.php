<?php

class ImagesController extends Controller
{
//        public $emCategories;
        public $toolbar;

        function __construct($id, $module=NULL) {
            $this->toolbar = NULL;
//            $this->emCategories= NULL;
            parent::__construct($id, $module);
        }
        
        protected function createNewCat($model){
                if(isset($_POST['newCat'])){
                    $cat=new Category;
                    $cat->attributes=$_POST['Category'];
                    if($cat->validate()){
                        $cat->save();
                        array_push($model->imgCats,$cat->id);
                    }
                }            
        }
        
	public function actionAdd()        
	{
            $model=new Images;
            $model->scenario="Add";
            if(isset($_POST['Images'])){
                $model->attributes=$_POST['Images'];
                $this->createNewCat($model);
                
                $transaction=$model->dbConnection->beginTransaction();
                try{

                    $files=CUploadedFile::getInstances($model,'fileName');                
                    foreach($files as $file){
                        $newImg=new Images;
                        $newImg->imgCats=$model->imgCats;
                        $newImg->fileName=$file;
                        if($newImg->validate()){
                            $newImg->save();
                        }
                    }
                }catch(Exception $e){
                    $transaction->rollback();
                    throw $e;
                }            
                $this->redirect(array('index'));
            }
            $this->render('add',array('model'=>$model));
	}
        
	public function actionEdit($id)
	{
            $model=$this->loadModel($id);
            $model->scenario="Edit";
            
            if(isset($_POST['Images'])){
                $model->attributes=$_POST['Images'];
                $this->createNewCat($model);
                if($model->validate()){
                    $model->save();
                }
                $this->redirect(array('index'));
            }else{
                $this->render('add',array('model'=>$model));
            }
	}
        
 	public function actionDelete($id)
 	{
            $model=$this->loadModel($id);

            $this->performAjaxDeletion($model);

            $model->delete();
            $this->redirect(array('index'));
	}

	public function actionIndex()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

                
                $dataProvider=new CActiveDataProvider('Images');
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
				'actions'=>array('add','index','edit','delete','test'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        protected function performAjaxDeletion($model)
	{
		if(isset($_GET['ajax']))
		{    
                    $model->delete();
                    echo "deleted";
                    Yii::app()->end();
		}
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