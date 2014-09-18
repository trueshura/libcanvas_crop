<?php
/* @var $this ImagesController */
/* @var $model Images */
/* @var $form CActiveForm */


$this->breadcrumbs=array(
	'Потолки',
);
$this->menu=array(
    array('label'=>'Добавить', 'url'=>array('/admin/images/add'), 'tag'=>'new',)
);

$this->filterCats=$model->catId;

?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
<?php $form=$this->beginWidget('CActiveForm', array(
        'htmlOptions'=>array('id'=>'image-index-form'),
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// See class documentation of CActiveForm for details on this,
	// you need to use the performAjaxValidation()-method described there.
        
        
));
//var_dump($model->catId);

    $catsList=Category::getAllCats();
    $catsList[0]="Все категории";
    echo CHtml::activeDropDownList($model,"catId",$catsList);
    echo CHtml::submitButton('Фильтровать',array(id=>"imageSubmit"));
    $this->endWidget();
    
?>    
    
</p>
<p>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->search(),
    'itemView'=>'_view',
)); ?>
</p>
