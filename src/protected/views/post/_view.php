<div class="note">

	<?php $link = $data->getLink(); ?>
	<h1><?php echo CHtml::link($data->title, $link); ?></h1>
	<span><?php echo Yii::app()->dateFormatter->format('d MMMM', $data->update_time); ?></span>
	<div class="text">
		<?php echo $data->content_display; ?>
	</div>
	<?php $count = $data->commentCount; ?>
	<?php echo CHtml::link(
		Yii::t('Comment', '{n} comment|{n} comments', $count),
		$link);
	?>

</div>