<?php
/* @var $this ImagesController */
$this->breadcrumbs=array(
	'Потолки' => array('/admin/images'),
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'htmlOptions'=>array('enctype'=>'multipart/form-data','id'=>'image-edit-form'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
        
        
)); 

Yii::app()->clientScript->registerCssFile("files/styles.css");
Yii::app()->clientScript->registerScriptFile("files/js/atom.js");
Yii::app()->clientScript->registerScriptFile("files/js/scripts.js?v2");

if($model->scenario =='Add'){
    array_push($this->breadcrumbs,"Добавить");
    Yii::app()->clientScript->registerScript("file-add-script","
        atom.dom(function () {
            atom.dom('#Images_fileName').addEvent('change', handleFileSelect);
            atom.dom('#newCatName').addEvent('blur', function(){
                atom.dom('#newCat').first.checked=(atom.dom('#newCatName').first.value!='');
            });
        });
        ",CClientScript::POS_HEAD);
}elseif($model->scenario =='Edit'){
    array_push($this->breadcrumbs,"Редактировать");
}
?>

	<div id="selectFile" class="row">
		<?php 
                if($model->scenario =='Add'){
                    echo $form->labelEx($model,'fileName'); 
                    echo $form->fileField($model,'fileName',array("multiple" =>1));
                    echo $form->error($model,'fileName');
                }else{
                    echo $form->hiddenField($model,'fileName');
                    echo CHtml::image(CHtml::encode('images/uploads/thumbs/thumb_'.$model->fileName));
                }
                ?>
	</div>
        <div id="list"></div>
        <div class="categories">
            <?php ?>
            <p>Категории</p>
        <?php
            $CatImg=new CategorizedImages;
            $allCats=Category::getAllCats();
            $imgCats=$model->getImgCats();
            foreach($allCats as $catId => $catLabel){
                echo CHtml::activeCheckBox($CatImg,"[$catId]catID");
//                echo CHtml::checkBox($elemId,isset($imgCats[$catId]),array('id'=>$elemId));
                echo CHtml::label($catLabel,$elemId);
            }
        ?>
            <p>
        <?php
            $Category=new Category;
            echo CHtml::checkBox("newCat",false,array('id'=>'newCat','name'=>'newCat'));
            echo CHtml::label("Создать новую категорию","newCat");
            echo CHtml::activeTextField($Category,"description");
        ?>
            </p>
        </div>
        <div class="categories">
        <?php
            $CatImg2=new CategorizedImages;
            $CatImg2->allCats=Category::getAllCats();
//            $imgCats=$model->getImgCats();
//            $imgCats=$model->getTstCats();
//            echo CHtml::checkBoxList("asdas",$imgCats,$CatImg2->allCats);            
            echo CHtml::activeCheckBoxList($model,"tstCats2",$CatImg2->allCats);
            
//            echo CHtml::activeCheckBoxList($model,"cats",$CatImg2->allCats);
            
            
//            var_dump($CatImg2->allCats);
//            var_dump($model->cats);
//            var_dump($cats);
        ?>
            
        </div>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить',array(id=>"imageSubmit")); ?>
	</div>
    
<?php $this->endWidget(); ?>

</div><!-- form -->