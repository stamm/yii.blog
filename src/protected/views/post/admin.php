<?php
$this->breadcrumbs=array(
	Yii::t('Post', 'Posts')=>array('index'),
	Yii::t('Post', 'Manage'),
);

$this->menu=array(
	array('label'=>Yii::t('Post', 'List Post'), 'url'=>array('index')),
	array('label'=>Yii::t('Post', 'Create Post'), 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('post-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Posts</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'post-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'content_display:html',
		array(
			'name' => 'status',
			'filter' => Lookup::items('PostStatus'),
			'type' => 'raw',
			'value' => 'Lookup::item("PostStatus", $data->status)',
		),
		array(
			'name' => 'post_time',
			'type' => 'raw',
			'value' => 'date("Y-m-d H:i:s", $data->post_time)',
		),
		/*
		'update_time',
		'post_time',
		'author_id',
		'url',
		'short_url',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
