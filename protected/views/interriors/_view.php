<?php
/* @var $this InterriorsController */
/* @var $data Interriors */
?>

<div class="view" id="view<?=$data->id?>">
	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->fileName), array('edit', 'id'=>$data->id)); ?>
	<br />
        <?php echo CHtml::link(CHtml::image(CHtml::encode('images/uploads/thumbs/thumb_'.$data->fileName)),array('edit', 'id'=>$data->id)); ?>
        <?php echo CHtml::ajaxSubmitButton("Удалить",array('delete', 'id'=>$data->id,'ajax' => 1),
                        array('update' => "#view".$data->id),
                        array(
                            'confirm' => 'Вы уверены, что хотите удалить этот интерьер?',
                            )
                        );?>
</div>