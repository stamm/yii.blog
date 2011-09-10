<div class="note">

	<h1><?php echo CHtml::link($data->title, $data->getLink()); ?></h1>
	<span><?php echo Yii::app()->dateFormatter->format('d MMMM', $data->update_time); ?></span>
	<div class="text">
		<?php echo $data->content_display; ?>
	</div>

</div>