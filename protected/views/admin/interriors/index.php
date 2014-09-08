<?php
/* @var $this InterriorController */

$this->breadcrumbs=array(
	'Интерьеры',
);
$this->menu=array(
    array('label'=>'Добавить', 'url'=>array('/admin/interriors/add'), 'tag'=>'new',),
);

?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>
<p>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</p>
