<?php
/* @var $this InterriorsController */
/* @var $model Interriors */
/* @var $form CActiveForm */

$this->breadcrumbs=array(
	'Интерьеры' => array('/interriors'),
);

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'htmlOptions'=>array('enctype'=>'multipart/form-data','id'=>'interriors-edit-form'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
        
        
)); 

Yii::app()->clientScript->registerCssFile("files/styles.css");
Yii::app()->clientScript->registerScriptFile("files/js/atom.js");
Yii::app()->clientScript->registerScriptFile("files/js/libcanvas.js");
Yii::app()->clientScript->registerScriptFile("files/js/scripts.js?v2");
Yii::app()->clientScript->registerScriptFile("files/js/controller.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile("files/js/carcass.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile("files/js/interrior.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile("files/js/ceiling.js",CClientScript::POS_END);

if($model->scenario =='Add'){
    Yii::app()->clientScript->registerScript("inter-add-script","
        atom.dom(function () {
       
                atom.dom('#interrSubmit').addClass('hidden');
                atom.dom('#complex_int').addClass('disabled');
                atom.dom('#Interriors_fileName').addEvent('change', handleInterriorSelect);
        });",CClientScript::POS_HEAD);
    array_push($this->breadcrumbs,"Добавить");
}elseif($model->scenario =='Edit'){
    Yii::app()->clientScript->registerScript("inter-edit-script","
        atom.dom(function () {
                atom.dom('#selectFile').addClass('hidden');
                atom.dom('#complex_int').addEvent('click',beginComplex);

                window.Em={};
                window.Em.loadValues=true;
                window.Em.initInterr='images/uploads/".$model->fileName."';
                if(c_ctrl){
                //Контроллер уже создан
                    loadValues();
                }
        });",CClientScript::POS_HEAD);
    array_push($this->breadcrumbs,"Редактировать");
}
?>

	<?php echo $form->errorSummary($model); ?>

	<div id="selectFile" class="row">
		<?php echo $form->labelEx($model,'fileName'); ?>
		<?php 
                if($model->scenario =='Add'){
                    echo $form->fileField($model,'fileName'); 
                }else{
                    echo $form->hiddenField($model,'fileName');
                }
                ?>
		<?php echo $form->error($model,'fileName'); ?>
	</div>
        <div class="row">
                <?php echo $form->hiddenField($model,'id'); ?>
                <?php echo $form->hiddenField($model,'strCorners'); ?>
                <?php echo $form->hiddenField($model,'strProjection'); ?>
                <?php echo $form->hiddenField($model,'isComplex'); ?>

        <div id="scene"></div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить',array(id=>"interrSubmit")); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->