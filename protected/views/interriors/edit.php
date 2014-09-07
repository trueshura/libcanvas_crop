<?php
/* @var $this InterriorsController */
/* @var $model Interriors */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'interriors-edit-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
	'enableAjaxValidation'=>true,
)); 

Yii::app()->clientScript->registerCssFile("files/styles.css");
Yii::app()->clientScript->registerScriptFile("files/js/atom.js");
Yii::app()->clientScript->registerScriptFile("files/js/libcanvas.js");
Yii::app()->clientScript->registerScriptFile("files/js/scripts.js?v2");
Yii::app()->clientScript->registerScriptFile("files/js/controller.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile("files/js/carcass.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile("files/js/interrior.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile("files/js/ceiling.js",CClientScript::POS_END);
Yii::app()->clientScript->registerScript("inter-script","
    new function () {
	LibCanvas.extract();
	atom.patching(window);

        atom.dom(function () {
       
                atom.dom('#Interriors_fileName').addEvent('change', handleInterriorSelect);
                atom.dom('#interrSubmit').addClass('hidden');
                atom.dom('#complex_int').addClass('disabled');

		c_ctrl=new Canvas.Controller();
	});
    }",CClientScript::POS_HEAD);


?>


	<?//var_dump($model);?>
        <?//var_dump($this);?>
        <?//var_dump($_POST);?>

	<?php echo $form->errorSummary($model); ?>

	<div id="selectFile" class="row">
		<?php echo $form->labelEx($model,'fileName'); ?>
		<?php echo $form->fileField($model,'fileName'); ?>
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