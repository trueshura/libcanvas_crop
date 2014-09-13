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

?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</p>
