<?php
/* @var $this ImagesController */
/* @var $data Images */
?>


<div class="view" id="view<?=$data->id?>">
    	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->fileName), array('edit', 'id'=>$data->id)); ?>
	<br />
        <?php echo CHtml::link(CHtml::image(CHtml::encode('images/uploads/thumbs/thumb_'.$data->fileName)),array('edit', 'id'=>$data->id)); ?>
        <div class="categories">
        <?php
            $allCats=Category::getAllCats();
            $imgCats=$data->getImgCats();
            foreach($allCats as $catId => $catLabel){
                $elemId='['.$data->id.']check'.$catId;
                echo CHtml::checkBox("img".$data->id,in_array($catId,$imgCats),array('id'=>$elemId,'name'=>$elemId,'disabled'=>true));
                echo CHtml::label($catLabel,$elemId);

            }
        ?>
        </div>
        <?php echo CHtml::ajaxSubmitButton("Удалить",array('delete', 'id'=>$data->id,'ajax' => 1),
                        array('update' => "#view".$data->id),
                        array(
                            'confirm' => 'Вы уверены, что хотите удалить эту картинку?',
                            )
                        );?>

</div>