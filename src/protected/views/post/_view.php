<div class="note">

	<p><?php echo date('Y-m-d H:i', $data->update_time); ?></p>
	<h1><?php echo CHtml::link($data->title, $data->getLink()); ?></h1>
	<div class="text">
		<?php echo $data->content_display; ?>
	</div>

</div>