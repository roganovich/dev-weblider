<?php
/* @var $this MaterialHistoryController */
/* @var $data MaterialHistory */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('material_type')); ?>:</b>
	<?php echo CHtml::encode($data->material_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('matarial_id')); ?>:</b>
	<?php echo CHtml::encode($data->matarial_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_at')); ?>:</b>
	<?php echo CHtml::encode($data->created_at); ?>
	<br />


</div>