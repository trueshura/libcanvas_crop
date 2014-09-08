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
		$this->render('add');
	}

	public function actionDelete()
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