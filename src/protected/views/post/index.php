<?php
$this->breadcrumbs=array(
	Yii::t('all','Posts'),
);

$this->menu=array(
	array('label'=>Yii::t('Post','Create Post'), 'url'=>array('create')),
	array('label'=>Yii::t('Post','Manage Post'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('all','Posts')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
