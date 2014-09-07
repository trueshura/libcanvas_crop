<?php
/* @var $this InterriorController */

$this->breadcrumbs=array(
	'Интерьеры',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</p>
