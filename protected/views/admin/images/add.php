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
                    $this->widget('CMultiFileUpload',
                        array(
                            'model'=>$model,
                            'attribute' => 'fileName',
                            'accept'=> 'jpg|jpeg',
                            'denied'=>'Only jpg files allowed',
                            'remove'=>'[x]',
                            'duplicate'=>'Already Selected',
                            'options'=>array(
                                'onFileAppend'=>'function(e, v, m){handleFileSelect(e);}',
                                'onFileRemove'=>'function(e, v, m){ $("#thumb"+e.id).parent().remove(); }',
                                ),
                            ));
/*                    
                    echo $form->labelEx($model,'fileName'); 
                    echo $form->fileField($model,'fileName',array("multiple" =>1));
                    echo $form->error($model,'fileName');
 * 
 */
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
            echo CHtml::activeCheckBoxList($model,"ImgCats",Category::getAllCats());
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
    
	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить',array(id=>"imageSubmit")); ?>
	</div>
    
<?php $this->endWidget(); ?>

</div><!-- form -->